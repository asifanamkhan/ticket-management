<?php

namespace App\Http\Controllers\SpecialUser;

use App\Http\Controllers\Controller;
use App\Repositories\Country\Country;
use App\Repositories\SpecialUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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
        //
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SpecialUser  $specialUser
     * @return \Illuminate\Http\Response
     */
    public function show(SpecialUser $specialUser)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SpecialUser  $specialUser
     * @return \Illuminate\Http\Response
     */
    public function edit(SpecialUser $specialUser)
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
    public function update(Request $request, SpecialUser $specialUser)
    {
        //
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
}
