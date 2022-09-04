<?php

namespace App\Http\Controllers\SpecialUser;

use Illuminate\Http\Request;
use App\Repositories\SpecialUser;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Repositories\Country\Country;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class SpecialUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::guard('specialUser')->user();
        $countries = [];
        $countryResponse = Country::all();
        if ($countryResponse['status'] === 'success') {
            $countries = $countryResponse['data'];
        }

        return view('special-users.dashboard', compact('user', 'countries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countriesResponse = Country::all();
        $countries = [];
        if ($countriesResponse['status'] === 'success') {
            $countries = $countriesResponse['data'];
        }
        return view('special-users.auth.register',compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            //dd($request->document);
            $validator = Validator::make($request->all(), [
                'full_name' => 'required',
                'company_name' => 'required',
                'type' => 'required',
                'email' => 'required|email|unique:special_users,email',
                'mobile' => 'numeric|min:10',
                'address' => 'required',
                'country_id' => 'required',
                'city' => 'required',
                'password' => 'required|min:8|confirmed',
                'g-recaptcha-response' => 'required|captcha'
            ],
                [
                    'country_id.required' => 'The country field is required.',
                    'g-recaptcha-response.required' => 'The captcha field is required.',
                ]);

            if ($validator->fails()) {
                $errors = $validator->errors()->toArray();
                return back()->withInput($request->all())->withErrors($errors);
            }

            $response = SpecialUser::save([
                'full_name' =>$request->full_name,
                'company_name' => $request->company_name,
                'type' => $request->type,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'address' => $request->address,
                'country_id' => $request->country_id,
                'city' => $request->city,
                'password' => Hash::make($request->password),
                'document' => $request->document ?? '',

            ]);

            if ($response['status'] === 'error') {
                return back()->withInput($request->all())->withErrors($response['data']);
            }

            Session::flash('special-user-create', 'thank you for submitting admin will review your request');

            return redirect()->route('home');
        }
        catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
    }

    public function profile($id){
        $specialUserResponse = SpecialUser::first($id);
        $specialUser = [];

        if($specialUserResponse['status'] === 'success'){
            $specialUser = $specialUserResponse['data'];
        }

        return view('special-users.profile',compact('specialUser'));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SpecialUser  $specialUser
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $specialUserResponse = SpecialUser::first($id);
        $specialUser = [];

        if($specialUserResponse['status'] === 'success'){
            $specialUser = $specialUserResponse['data'];
        }


        return view('special-users.show',compact('specialUser'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SpecialUser  $specialUser
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $countriesResponse = Country::all();
        $countries = [];

        $specialUserResponse = SpecialUser::first($id);
        $specialUser = [];

        if($specialUserResponse['status'] === 'success'){
            $specialUser = $specialUserResponse['data'];
        }

        if ($countriesResponse['status'] === 'success') {
            $countries = $countriesResponse['data'];
        }


        return view('special-users.edit',compact('specialUser','countries'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SpecialUser  $specialUser
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try{

            $response = SpecialUser::update($id,[
                'full_name' =>$request->full_name,
                'company_name' => $request->company_name,
                'type' => $request->type,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'address' => $request->address,
                'country_id' => $request->country_id,
                'city' => $request->city,
                'message' => $request->message,
                'document' => $request->document ?? '',
                'oldDocument' => $request->oldDocument ?? '',

            ]);

            //dd($response);

            if ($response['status'] === 'error') {
                Session::flash('special-user-status', $request->status === 'on' ? true : false);
                return back()->withInput($request->all())->withErrors($response['data']);
            }

            Session::flash('special-user-update', 'Special user updated successfully');

            return back();
        }
        catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
    }

    public function passwordChange($id){
        return view('special-users.password-change');
    }

    public function passwordUpdate(Request $request, $id)
    {
        try {
            $errors = [];
            $validator = Validator::make($request->all(), [
                'password' => 'required|min:8|confirmed',
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors()->toArray();
                return back()->withInput($request->all())->withErrors($errors);
            }

            $specialUserResponse = SpecialUser::first($id);

            if ($specialUserResponse['status'] === 'success') {

                $specialUser = $specialUserResponse['data'];
                $response = SpecialUser::update($id, [
                    'full_name' =>$specialUser->full_name,
                    'company_name' => $specialUser->company_name,
                    'type' => $specialUser->type,
                    'email' => $specialUser->email,
                    'mobile' => $specialUser->mobile,
                    'address' => $specialUser->address,
                    'country_id' => $specialUser->country_id,
                    'city' => $specialUser->city,
                    'document' => '',
                    'oldDocument' => $specialUser->document,
                    'password' => Hash::make($request->password),
                ]);
            }

            if ($specialUser['status'] === 'error') {
                return back()->withInput($request->all())->withErrors($response['data']);
            }

            Session::flash('special-user-password-change', 'Special user password changed successfully.');

            return back();
        }
        catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SpecialUser  $specialUser
     * @return \Illuminate\Http\Response
     */
    public function destroy(SpecialUser $specialUser)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SpecialUser  $specialUser
     * @return \Illuminate\Http\Response
     */
    public function updateProfile(Request $request, $id)
    {
        try{

            $response = SpecialUser::update($id,[
                'full_name' =>$request->full_name,
                'company_name' => $request->company_name,
                'type' => $request->type,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'address' => $request->address,
                'country_id' => $request->country_id,
                'city' => $request->city,
                'document' => $request->document ?? '',
                'oldDocument' => $request->oldDocument ?? '',

            ]);

            //dd($response);

            if ($response['status'] === 'error') {
                return back()->withInput($request->all())->withErrors($response['data']);
            }

            Session::flash('special-user-update', 'Profile updated successfully');

            return back();
        }
        catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
    }
}
