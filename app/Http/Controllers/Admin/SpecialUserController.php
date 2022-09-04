<?php

namespace App\Http\Controllers\Admin;

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
        $response = SpecialUser::all();
        $specialUsers = [];

        if ($response['status'] === 'success') {
            $specialUsers = $response['data'];
        }
        return view('admin.special.index',compact('specialUsers'));
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
        return view('admin.special.create',compact('countries'));
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
                'message' => $request->message ?? '',
                'status' => $request->status === 'on' ? true : false,
                'password' => Hash::make($request->password),
                'document' => $request->document ?? '',

            ]);

            if ($response['status'] === 'error') {
                Session::flash('special-user-status', $request->status === 'on' ? true : false);
                return back()->withInput($request->all())->withErrors($response['data']);
            }

            Session::flash('special-user-create', 'Special user created successfully');

            return back();

        }
        catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $response = SpecialUser::first($id);
        $specialUser = $response['data'];

        if ($response['status'] === 'error' ) {
            throw new \Exception($specialUser);
        }

        return view('admin.special.show', compact('specialUser'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $specialUserResponse = SpecialUser::first($id);
        $specialUser = [];
        $countriesResponse = Country::all();
        $countries = [];

        if ($specialUserResponse['status'] === 'success') {
            $specialUser = $specialUserResponse['data'];
        }

        if ($countriesResponse['status'] === 'success') {
            $countries = $countriesResponse['data'];
        }

        return view('admin.special.edit',compact('specialUser','countries'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
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
                'status' => $request->status === 'on' ? true : false,
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
        return view('admin.special.change-password',compact('id'));
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $visitor= SpecialUser::delete($id);

            return response()->json($visitor);

        } catch (\Exception $ex) {
            return response()->json([
                'status' => 'error',
                'data' => $ex->getMessage()
            ]);
        }
    }
}
