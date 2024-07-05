<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Factory as ValidationFactory;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'userid' => 'required',
            'password' => 'required'
        ];
    }

    public function getCredentials()
    {
        // The form field for providing username or password
        // have name of "username", however, in order to support
        // logging users in with both (username and email)
        // we have to check if user has username or email
        $userid = $this->get('userid');
        if ($this->isEmail($userid)) {
            return [
                'email' => $userid,
                'password' => $this->get('password')
            ];
        }
        return $this->only('userid', 'password');
    }

    private function isEmail($param)
    {
        $factory = $this->container->make(ValidationFactory::class);

        return ! $factory->make(
            ['userid' => $param],
            ['userid' => 'email']
        )->fails();
    }
}
