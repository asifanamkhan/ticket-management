<?php

namespace App\Http\Controllers\Admin;


use App\Repositories\Log;
use Illuminate\Http\Request;
use App\Repositories\Activity;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = Activity::all();
        $activities = [];

        if ($response['status'] === 'success') {
            $activities = $response['data'];
        }
        return view('admin.activities.index', compact('activities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.activities.create');
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


            $response = Activity::save([
                'name' => $request->name,
                'arabic_name' => $request->arabic_name,
                'description' => $request->description,
                'arabic_description' => $request->arabic_description,
                'price' => $request->price ?? 0,
                'highlight' => $request->highlight === 'on' ? true : false,
                'status' => $request->status === 'on' ? true : false,
                'concert' => $request->concert === 'on' ? true : false,
                'images' => $request->has('images') ? $request->images : [],
            ]);

            if ($response['status'] === 'success') {
                $logResponse = Log::save([
                    'admin_id' => auth()->id(),
                    'log_name' => 'Activity',
                    'log_type' => 'Created',
                    'description' => $request->name,
                    'field_id' => $response['data']->id,
                    'from' => '',
                    'to' => $response['data']
                ]);

            }

            if ($response['status'] === 'error') {
                Session::flash('activity-highlight', $request->highlight === 'on' ? true : false);
                Session::flash('activity-status', $request->status === 'on' ? true : false);
                Session::flash('activity-concert', $request->concert === 'on' ? true : false);
                return back()->withInput($request->all())->withErrors($response['data']);
            }

            Session::flash('activity-create', 'Activity Created successfully.');

            return back();
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  integer $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $response = Activity::first($id);
        $activity = $response['data'];

        if ($response['status'] === 'error' ) {
            throw new \Exception($activity);
        }

        return view('admin.activities.show', compact('activity'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  integer  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $response = Activity::first($id);
        $activity = $response['data'];

        if ($response['status'] === 'error' ) {
            throw new \Exception($activity);
        }

        return view('admin.activities.edit', compact('activity'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  integer $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            //dd($request->except('_method','_token'));
            $oldActivityResponse = Activity::first($id);
            $oldActivity = [];

            if($oldActivityResponse['status'] === 'success'){
                $oldActivity = $oldActivityResponse['data'];
            }
            $response = Activity::update($id, [
                'name' => $request->name,
                'arabic_name' => $request->arabic_name,
                'description' => $request->description,
                'arabic_description' => $request->arabic_description,
                'price' => $request->price ?? 0,
                'highlight' => $request->highlight === 'on' ? true : false,
                'status' => $request->status === 'on' ? true : false,
                'concert' => $request->concert === 'on' ? true : false,
                'images' => $request->has('images') ? $request->images : [],
            ]);

            if ($response['status'] === 'success') {
                $logResponse = Log::save([
                    'admin_id' => auth()->id(),
                    'log_name' => 'Activity',
                    'log_type' => 'Updated',
                    'description' => $request->name,
                    'field_id' => $response['data']->id,
                    'from' => $oldActivity,
                    'to' => $response['data']
                ]);

            }

            if ($response['status'] === 'error') {
                Session::flash('activity-highlight', $request->highlight === 'on' ? true : false);
                Session::flash('activity-status', $request->status === 'on' ? true : false);
                Session::flash('activity-concert', $request->concert === 'on' ? true : false);
                return back()->withInput($request->all())->withErrors($response['data']);
            }

            Session::flash('activity-update', 'Activity Updated successfully.');

            return back();
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  integer $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $activity = Activity::delete($id);

            return response()->json($activity);

        } catch (\Exception $ex) {
            return response()->json([
                'status' => 'error',
                'data' => $ex->getMessage()
            ]);
        }
        
    }


    public function imageDelete($id,$image){


       try{
           $activity = Activity::first($id);

           if($activity['status'] === 'error'){
               return response()->json([
                   'status' => 'error',
                   'data' => 'No activity found'
               ]);
           }
           $images = $activity['data']['images'];

           if(count($images) > 0){
               $key = array_search($image, $images);

               if($key !== false){
                   unset($images[$key]);
               }
           }

           $activity = Activity::imageDelete($id,$images);

           $activity = Activity::first($id);

           if($activity['status'] === 'error'){
               return response()->json([
                   'status' => 'error',
                   'data' => 'No activity found'
               ]);
           }
           $images = $activity['data']['images'];

           $html = view('admin.activities.images', compact('images', 'id'))->render();

           if($activity['status'] === 'success'){
               return response()->json(['status' => 'success', 'data' => $html]);
           }
       }
       catch (\Exception $ex) {
           return response()->json([
               'status' => 'error',
               'data' => $ex->getMessage()
           ]);
       }

    }
}
