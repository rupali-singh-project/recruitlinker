<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Job Portal</title>
    <!-- base:css -->
    <link rel="stylesheet" href="{{asset('public/assets/vendors/mdi/css/materialdesignicons.min.css')}}">
    <link rel="stylesheet" href="{{asset('public/assets/vendors/base/vendor.bundle.base.css')}}">
    <!-- endinject -->
    <!-- plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{asset('public/assets/css/style.css')}}">
    <!-- endinject -->
    <link rel="shortcut icon" href="{{asset('public/assets/images/favicon.png')}}" />
    <link rel="stylesheet" href="{{asset('public/assets/vendors/summernote/summernote.min.css')}}">
    <link rel="stylesheet" href="{{asset('public/assets/vendors/sweetalerts/dist/sweetalert2.min.css')}}">
    <link rel="stylesheet" href="{{asset('public/assets/css\maps\horizontal-layout-light/style.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" />

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif
        }

        p {
            margin: 0
        }

        .container {
            max-width: 100%;
            margin: 10px auto;
            background-color: #e8eaf6;
            padding: 35px;
        }

        .box-right {
            padding: 30px 25px;
            background-color: white;
            border-radius: 15px
        }

        .box-left {
            padding: 20px 20px;
            background-color: white;
            border-radius: 15px
        }

        .textmuted {
            color: #7a7a7a
        }

        .bg-green {
            background-color: #d4f8f2;
            color: #06e67a;
            padding: 3px 0;
            display: inline;
            border-radius: 25px;
            font-size: 11px
        }

        .p-blue {
            font-size: 14px;
            color: #1976d2
        }

        .fas.fa-circle {
            font-size: 12px
        }

        .p-org {
            font-size: 14px;
            color: #fbc02d
        }

        .h7 {
            font-size: 15px
        }

        .h8 {
            font-size: 12px
        }

        .h9 {
            font-size: 10px
        }

        .bg-blue {
            background-color: #dfe9fc9c;
            border-radius: 5px
        }

        .form-control {
            box-shadow: none !important
        }

        .card input::placeholder {
            font-size: 14px
        }

        ::placeholder {
            font-size: 14px
        }

        input.card {
            position: relative
        }

        .far.fa-credit-card {
            position: absolute;
            top: 10px;
            padding: 0 15px
        }

        .fas,
        .far {
            cursor: pointer
        }

        .cursor {
            cursor: pointer
        }

        .btn.btn-primary {
            box-shadow: none;
            height: 40px;
            padding: 11px
        }

        .bg.btn.btn-primary {
            background-color: transparent;
            border: none;
            color: #1976d2
        }

        .bg.btn.btn-primary:hover {
            color: #539ee9
        }

        @media(max-width:320px) {
            .h8 {
                font-size: 11px
            }

            .h7 {
                font-size: 13px
            }

            ::placeholder {
                font-size: 10px
            }
        }
    </style>
    @yield('styles')
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-6 mb-2 text-right">
                <form action="{{url('logout')}}">
                    <button class="btn btn-warning"><i class="fas fa-log-out"></i>Logout</button>
                </form>
            </div>
            <div class="col-6 d-flex justify-content-end">
                <span><b>Hello, {{$sessUser['userid']}}</b></span>
            </div>
        </div>
        <div class="row m-0">
            <div class="col-md-7 col-12">
                <div class="row">
                    <div class="col-12 mb-4">
                        <div class="row box-right">
                            <div class="col-md-8 ps-0 ">
                                <p class="ps-3 textmuted fw-bold h6 mb-0">Total Amount</p>
                                <p class="h1 fw-bold d-flex"> <span class=" fa fa-inr textmuted pe-1 h6 align-text-top mt-1"></span>{{$totalAmount}} INR </p>
                                <p class=" px-2 text-muted">Please pay to continue using this application.</p>
                            </div>

                        </div>
                    </div>
                    <div class="col-12 px-0 mb-4">
                        <div class="box-right">

                            <div class="bg-blue p-2">
                                <div class="h8 textmuted">
                                    <p>Access our full suite of features and turbocharge your job search by making a payment. With our pay-to-use model, you'll open doors to a world of career advancement opportunities.</p>

                                    <p class="my-2">Why Pay to Use?</p>
                                    <ul>
                                        <li><b>Unlimited Access</b>: Enjoy unrestricted access to our extensive database of job listings.</li>
                                        <li><b>Enhanced Visibility</b>: Stand out to employers with a prioritized placement in search results.</li>
                                        <li><b>Customized Alerts</b>: Receive instant notifications about new job openings tailored to your preferences.</li>
                                        <li><b>Advanced Tools</b>: Utilize advanced search filters to pinpoint the perfect job opportunities.</li>
                                        <li><b>Dedicated Support</b>: Receive personalized assistance from our support team whenever you need it.</li>
                                    </ul>

                                    <p>To unlock these exclusive benefits and start exploring limitless career possibilities, proceed with the payment below. Your investment today will propel you closer to your dream job.</p>

                                    <p>Thank you for choosing our platform to fuel your career aspirations. Begin your paid journey today and seize the opportunities that await you!</p>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-md-5 col-12 ps-md-5 p-0 ">
                <div class="box-left">
                    <p class="textmuted h8">Invoice</p>
                    <p class="fw-bold h7">{{$sessUser['first_name']}} {{$sessUser['last_name']}}</p>
                    <!-- <p class="textmuted h8 mb-2"></p> -->
                    <div class="h8">
                        <div class="row m-0 border mb-3">
                            <div class="col-6 h8 pe-0 ps-2">
                                <p class="textmuted py-2">Items</p> <span class="d-block py-2 border-bottom">Premium Plan</span>
                            </div>
                            <div class="col-2 text-center p-0">
                                <p class="textmuted p-2">Qty</p> <span class="d-block p-2 border-bottom">1</span>
                            </div>
                            <div class="col-2 p-0 text-center h8 border-end">
                                <p class="textmuted p-2">Price</p> <span class="d-block border-bottom py-2">{{$totalAmount}}</span>
                            </div>
                            <div class="col-2 p-0 text-center">
                                <p class="textmuted p-2">Total</p> <span class="d-block py-2 border-bottom">{{$totalAmount}}</span>
                            </div>
                        </div>
                        <div class="d-flex h7 mb-2">
                            <p class="">Total Amount</p>
                            <p class="ms-auto">{{$totalAmount}}</p>
                        </div>

                    </div>
                    <div class="">
                        <p class="textmuted h8 mb-2">Make payment for this invoice by filling in the details</p>
                        <div class="form">
                            <form action="{{url('session')}}" method="POST">
                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                <button type="submit" class="w-100 btn btn-primary d-block h8" id=" checkout-live-button">Proceed To Pay</button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>