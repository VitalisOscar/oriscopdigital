<?php

namespace App\Http\Controllers\Platform\Account\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        return view('web.auth.register');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['required', 'regex:/0([0-9]){9}/', 'unique:users,phone'],
            // 'kra_pin' => ['required', 'regex:/([A-Z]){1}([0-9]){9}([A-Z]){1}/'],
            // 'website' => ['nullable'],
            // 'documents' => ['required', 'array'],
            // 'documents.kra_pin' => ['required', 'file', 'mimes:png,jpg,jpeg,pdf'],
            // 'documents.certificate' => ['required', 'file', 'mimes:png,jpg,jpeg,pdf'],
            // 'operator' => ['array', 'required'],
            // 'operator.name' => ['required', 'string'],
            // 'operator.position' => ['required', 'string'],
            // 'operator.phone' => ['required', 'regex:/0([0-9]){9}/'],
            'password' => ['required', 'string', 'min:8'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            // 'kra_pin' => $data['kra_pin'],
            // 'website' => isset($data['website']) ? $data['website'] : null,
            // 'operator' => [
            //     'name' => $data['operator']['name'],
            //     'phone' => $data['operator']['phone'],
            //     'position' => $data['operator']['position'],
            // ],
            'verification' => null,
            // 'payments' => null,
            // 'documents' => [
            //     'kra_pin' => $data['documents']['kra_pin']->store(User::DOCUMENT_DIR_KRA),
            //     'certificate' => $data['documents']['certificate']->store(User::DOCUMENT_DIR_CERT),
            // ],
            'status' => User::STATUS_PENDING,
            'password' => Hash::make($data['password']),
        ]);
    }
}
