<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\VisitorTicket;
use App\Repositories\Country\Country;
use App\Repositories\Log;
use App\Repositories\User;
use App\Repositories\Visitor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class VisitorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = Visitor::all();
        $visitors = [];

        if ($response['status'] === 'success') {
            $visitors = $response['data'];
        }

        return view('admin.visitors.index',compact('visitors'));
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
        return view('admin.visitors.create',compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $errors = [];
            $validator = Validator::make($request->all(), [
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|email|unique:users,email,NULL,provider,provider_id,NULL',
                'password' => 'required|min:8|confirmed',
                'mobile' => 'numeric|min:10',
                'city' => 'required',
                'address' => 'required',
                'country_id' => 'required',
                'state' => 'required',
                'zip' => 'required',
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors()->toArray();
                return back()->withInput($request->all())->withErrors($errors);
            }

            $response = Visitor::save([
                'first_name' =>$request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'mobile' => $request->mobile,
                'gender' => $request->gender,
                'address' => $request->address,
                'city' => $request->city,
                'country_id' => $request->country_id,
                'state' => $request->state,
                'zip' => $request->zip,
                'email_verified_at' => Carbon::now()
            ]);

            if ($response['status'] === 'success') {

                $countryResponse = Country::first($response['data']->country_id);
                $country = [];
                if($countryResponse['status'] === 'success'){
                    $country = $countryResponse['data']->name;
                }

                $newVisitor = $response['data'];
                $newVisitor['country'] = $country;

                $logResponse = Log::save([
                    'admin_id' => auth()->id(),
                    'log_name' => 'Visitor',
                    'log_type' => 'Created',
                    'description' => $request->first_name,
                    'field_id' => $response['data']->id,
                    'from' => '',
                    'to' => $newVisitor
                ]);

            }


            if ($response['status'] === 'error') {

                return back()->withInput($request->all())->withErrors($response['data']);
            }

            Session::flash('visitor-create', 'Visitor Created successfully.');

            return back();
        } catch (\Exception $ex) {
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
        $response = Visitor::first($id);
        $visitor = $response['data'];

        if ($response['status'] === 'error' ) {
            throw new \Exception($visitor);
        }

        return view('admin.visitors.show', compact('visitor'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $visitorResponse = Visitor::first($id);
        $visitor = [];
        $countriesResponse = Country::all();
        $countries = [];

        if ($visitorResponse['status'] === 'success') {
            $visitor = $visitorResponse['data'];
        }

        if ($countriesResponse['status'] === 'success') {
            $countries = $countriesResponse['data'];
        }

        return view('admin.visitors.edit',compact('visitor','countries'));
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
        try {

            $oldVisitorResponse = Visitor::first($id);
            $oldVisitor = [];

            if($oldVisitorResponse['status'] === 'success'){
                $oldVisitor = $oldVisitorResponse['data'];
            }

            $countryResponse = Country::first($oldVisitor->country_id);
            $country = [];

            if($countryResponse['status'] === 'success'){
                $country = $countryResponse['data']->name;
            }

            $oldVisitor['country'] = $country;

            $response = Visitor::update($id,[
                'first_name' =>$request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'gender' => $request->gender,
                'address' => $request->address,
                'city' => $request->city,
                'country_id' => $request->country_id,
                'state' => $request->state,
                'zip' => $request->zip,
                'email_verified_at' => $request->email_verified_at === 'on' ? Carbon::now() : NULL
            ]);

            if ($response['status'] === 'success') {

                $newVisitor = $response['data'];

                $countryResponse = Country::first($newVisitor->country_id);
                $country = [];

                if($countryResponse['status'] === 'success'){
                    $country = $countryResponse['data']->name;
                }

                $newVisitor['country'] = $country;

                $logResponse = Log::save([
                    'admin_id' => auth()->id(),
                    'log_name' => 'Visitor',
                    'log_type' => 'Updated',
                    'description' => $request->first_name,
                    'field_id' => $response['data']->id,
                    'from' => $oldVisitor,
                    'to' => $newVisitor
                ]);

            }


            if ($response['status'] === 'error') {
                Session::flash('visitor-verified', $request->email_verified_at === 'on' ? true : false);
                return back()->withInput($request->all())->withErrors($response['data']);
            }

            Session::flash('visitor-update', 'Visitor Updated successfully.');

            return back();
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
    }

    public function passwordChange($id){
        return view('admin.visitors.change-password',compact('id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function passwordUpdate(Request $request, $id){

       try{
           $errors = [];
           $validator = Validator::make($request->all(), [
               'password' => 'required|min:8|confirmed',
           ]);

           if ($validator->fails()) {
               $errors = $validator->errors()->toArray();
               return back()->withInput($request->all())->withErrors($errors);
           }

           $visitorResponse = Visitor::first($id);

           if($visitorResponse['status'] ==='success'){

               $visitor = $visitorResponse['data'];
               $response = Visitor::update($id,[
                   'first_name' =>$visitor->first_name,
                   'last_name' => $visitor->last_name,
                   'email' => $visitor->email,
                   'mobile' => $visitor->mobile,
                   'address' => $visitor->address,
                   'city' => $visitor->city,
                   'country_id' => $visitor->country_id,
                   'state' => $visitor->state,
                   'zip' => $visitor->zip,
                   'password' => Hash::make($request->password),
               ]);
           }

           if ($visitorResponse['status'] === 'error') {
               return back()->withInput($request->all())->withErrors($response['data']);
           }

           Session::flash('visitor-password-change', 'Visitor password changed successfully.');

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
            $visitor= Visitor::delete($id);

            return response()->json($visitor);

        } catch (\Exception $ex) {
            return response()->json([
                'status' => 'error',
                'data' => $ex->getMessage()
            ]);
        }
    }

    public function emailTicket($id){

        $visitorResponse = Visitor::first($id);

        if($visitorResponse['status'] === 'success'){
            $visitor = $visitorResponse['data'];

            Mail::to($visitor->email)->send(new VisitorTicket($visitor));
        }


        Session::flash('visitor-email-send', 'Send successfully');

        return back();

    }
}
