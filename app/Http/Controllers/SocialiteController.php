<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    //

    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {   
        try {
           
            $user = Socialite::driver($provider)->user();
            $finduser = User::where('provider_id', $user->id)->first();


            if (! $finduser) {
                
                $finduser = new User;
                $finduser->first_name = $user->name;
                $finduser->email = $user->email;
                $finduser->provider = $provider;
                $finduser->provider_id = $user->id;
                $finduser->email_verified_at = date('Y-m-d H:i:s'); 

                $finduser->save();
            }

            if ($finduser) {
                Auth::login($finduser);
                $redirect = Session::has('previous_link') ? Session::get('previous_link') : url('/');
                Session::forget('previous_link');
                return redirect()->to($redirect);
            }

            return redirect()->route('login');
            
        } catch (\Exception $e) {
            throw new \Exception($e);
        }
    }
}
