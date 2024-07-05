<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Stripe\Stripe;
use Stripe\Charge;
use App\Http\Traits\CustomUtils;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Session\Session as SessionSession;

class PaymentController extends Controller
{
    use CustomUtils;
    public function getSubscriptionPrice()
    {
        return 100.00;
    }

    public function checkout(Request $request)
    {
        $TotalAmount = $this->getSubscriptionPrice();
        $sessUser = $this->getSessUser($request);
        return view('payments.checkout', ['sessUser' => $sessUser, 'totalAmount' => $TotalAmount]);
    }

    public function session(Request $request)
    {
        \Stripe\Stripe::setApiKey('sk_test_51HY3ZHIGb51k0BVe58P8ENOOhtQGrneRnFwuiNP7hfp6xr1OgfrtJDyHqV9k6gVhXs5mqEjIndjr4auHqlWhwn7N00v35rMQNw');

        $session = \Stripe\Checkout\Session::create([
            'line_items'  => [
                [
                    'price_data' => [
                        'currency'     => 'inr',
                        'product_data' => [
                            'name' => 'Job Subscription Payment',
                        ],
                        'unit_amount'  => 10000,
                    ],
                    'quantity'   => 1,
                ],
            ],
            'mode'        => 'payment',
            'success_url' => route('success'),
            'cancel_url'  => route('checkout'),
        ]);
        $currSessUser = $this->getSessUser($request);
        DB::table('user_payment_details')->insert([
            'user_id' => $currSessUser['id'],
            'transaction_time' => Carbon::now(),
            'payment_status' => 'in_progress', // or succeeded
            'transaction_id' => $session['id'],
            'ip_address' => $request->ip()
        ]);
        Session::put('transaction_id', $session->id);
        return redirect()->away($session->url);
    }

    public function success(Request $request)
    {
        if (Session::get('transaction_id') != '') {
            $transaction_id = Session::get('transaction_id');
            if (DB::table('user_payment_details')->where('transaction_id', $transaction_id)->doesntExist()) {
                return "No such record found for transaction id .";
            }
            \Stripe\Stripe::setApiKey('sk_test_51HY3ZHIGb51k0BVe58P8ENOOhtQGrneRnFwuiNP7hfp6xr1OgfrtJDyHqV9k6gVhXs5mqEjIndjr4auHqlWhwn7N00v35rMQNw');

            // Retrieve the session from Stripe
            $stripeSession = \Stripe\Checkout\Session::retrieve($transaction_id);
            // Retrieve the payment intent ID from the session
            $paymentIntentId = $stripeSession->payment_intent;

            // Retrieve the transaction ID from the payment intent
            $paymentIntent = \Stripe\PaymentIntent::retrieve($paymentIntentId);
            DB::table('user_payment_details')->where('transaction_id', $transaction_id)->update([
                'payment_id' => $paymentIntent->id,
                'payment_status' => $paymentIntent->status,
                'amount' => ceil($paymentIntent->amount_received / 100),
            ]);
            $currSessUser = $this->getSessUser($request);
            DB::table('users')->where('id', $currSessUser['id'])->update(['accepted_agreements' => '1']);
            //payment confirmation on mail
            // to student
            $user = User::where('id', $currSessUser['id'])->first();
            $data = ['userData' => $user, 'payment_id' => $paymentIntent->id, 'amount' => ceil($paymentIntent->amount_received / 100), 'payment_time' => Carbon::now(), 'for' => 'student'];
            $mailData = [
                'to' => $user->email,
                'subject' => 'Payment Confirmation |Transaction ID : ' . $paymentIntent->id,
                'bladeName' => 'emails.paymentConfirm',
                'bladeData' => $data,
            ];
            $this->send_mail($mailData);
            // to admin
            $user = User::where('user_cat', 'Admin')->first();
            if ($user != null) {
                $adminName = $user['first_name'];
                $data['adminName'] = $adminName;
                $data['for'] = 'admin';
                $mailData = [
                    'to' => $user->email,
                    'subject' => 'Payment Confirmation |' . $paymentIntent->id,
                    'bladeName' => 'emails.paymentConfirm',
                    'bladeData' => $data,
                ];
                $this->send_mail($mailData);
            }
            return redirect(url('land'))->with('success', 'Payment transaction completed successfully.');
        } else {
            return "An Error has occurred while processing the transaction";
        }
    }
}
