<?php

namespace App\Http\Controllers\SpecialUser\Auth;

use App\Models\SpecialUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Repositories\Country\Country;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::ADMIN;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:specialUser');
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
            'full_name' => 'required',
            'company_name' => 'required',
            'type' => 'required',
            'email' => 'required|email|unique:special_users,email',
            'mobile' => 'numeric|min:10',
            'password' => 'required|min:8|confirmed',
            'g-recaptcha-response' => 'required|captcha'
        ],
        [
            'country_id.required' => 'The country field is required.',
            'g-recaptcha-response.required' => 'The captcha field is required.',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\Admin
     */
    protected function create(array $data)
    {
        return SpecialUser::create([
            'full_name' =>$data['full_name'],
            'company_name' => $data['company_name'],
            'type' => $data['type'],
            'email' => $data['email'],
            'mobile' => $data['mobile'],
            'address' => $data['address'],
            'country_id' => $data['country_id'],
            'city' => $data['city'],
            'password' => Hash::make($data['password']),
            'document' => $data['document'] ?? '',

        ]);
    }

    /**
     * Admin registration form.
     *
     * @return Illuminate\Contracts\Support\Renderable
     */
    public function showRegisterForm()
    {
        $countriesResponse = Country::all();
        $countries = [];
        if ($countriesResponse['status'] === 'success') {
            $countries = $countriesResponse['data'];
        }
        return view('special-users.auth.register', compact('countries'));
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Support\Facades\Redirect
     */
    protected function register(Request $request)
    {
        $this->validator($request->all())->validate();
        $admin = $this->create($request->all());
        return redirect()->intended('special-user/login');

    }
}
