<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\Country\Country;
use App\Repositories\Day;

use App\Repositories\Log;
use Illuminate\Http\Request;
use App\Repositories\Package;
use App\Repositories\Activity;
use App\Repositories\PackageType;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = Package::all([],['day','package_type']);
        $packages = [];

        if ($response['status'] === 'success') {
            $packages = $response['data'];
        }
        return view('admin.packages.index', compact('packages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $dayResponse = Day::select(['id', 'name']);
        $activityResponse = Activity::select('id,name');
        $typeResponse = PackageType::select('id,name');

        $days = [];
        $activities = [];
        $types = [];

        if ($dayResponse['status'] === 'success') {
            $days = $dayResponse['data'];
        }

        if ($activityResponse['status'] === 'success') {
            $activities = $activityResponse['data'];
        }

        if ($typeResponse['status'] === 'success') {
            $types = $typeResponse['data'];
        }

        return view('admin.packages.create', compact('days','activities', 'types'));
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
            // dd($request->all());
            $errors = [];
            $validator = Validator::make($request->all(), [
                "activities"    => "required|array|min:1"
            ]);
    
            if ($validator->fails()) {
                $errors = $validator->errors()->toArray();
            }

            $request['activities'] = isset($request['activities']) ? array_filter($request['activities']) : [];
            $request['day_limit'] = isset($request['day_limit']) ? array_filter($request['day_limit']) : [];
            $request['limit_per_visitor'] = isset($request['limit_per_visitor']) ? array_filter($request['limit_per_visitor']) : [];

            $response = Package::save($this->prepareRequest($request));

            if ($response['status'] === 'success') {
                $newPackage = $response['data'];
                $newPackageActivities = [];
                foreach ($newPackage->activities as $activity){
                    $newPackageActivities[] = $activity->name;
                }


                $packageTypeResponse = PackageType::first($response['data']->package_type_id);
                $dayResponse = Day::first($response['data']->day_id);

                $packageType = [];
                $day = [];

                if($packageTypeResponse['status'] === 'success'){
                    $packageType = $packageTypeResponse['data']->name;
                }

                if($dayResponse['status'] === 'success'){
                    $day = $dayResponse['data']->name;
                }

                $newPackage->unsetRelation('activities');

                $newPackage['activities'] = $newPackageActivities;
                $newPackage['package_type'] = $packageType;
                $newPackage['day'] = $day;

                $logResponse = Log::save([
                    'admin_id' => auth()->id(),
                    'log_name' => 'Package',
                    'log_type' => 'Created',
                    'description' => $request->name,
                    'field_id' => $response['data']->id,
                    'from' => '',
                    'to' => $newPackage
                ]);

            }

            if ($response['status'] === 'error') {
                if (is_array($response['data'])) {
                    $errors = array_merge($errors, $response['data']);
                }
            }

            if (count($errors) > 0) {
                Session::flash('package-status', $request->status === 'on' ? true : false);
                return back()->withInput($request->all())->withErrors($errors);
            }

            Session::flash('package-create', 'Package created successfully.');

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
        $response = Package::first($id,'id',['day','package_type','activities']);
        $package = $response['data'];

        if ($response['status'] === 'error' ) {
            throw new \Exception($package);
        }

        return view('admin.packages.show', compact('package'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  integer  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $response = Package::first($id);
        $dayResponse = Day::select(['id', 'name']);
        $activityResponse = Activity::select('id,name');
        $typeResponse = PackageType::select('id,name');
        //dd($response->activities());
        $days = [];
        $activities = [];
        $types = [];
        $package = null;

        if ($response['status'] === 'success') {
            $package = $response['data'];
        }

        if ($dayResponse['status'] === 'success') {
            $days = $dayResponse['data'];
        }

        if ($activityResponse['status'] === 'success') {
            $activities = $activityResponse['data'];
        }

        if ($typeResponse['status'] === 'success') {
            $types = $typeResponse['data'];
        }

        if ($response['status'] === 'error' ) {
            throw new \Exception($package);
        }

        return view('admin.packages.edit', compact('package','days','activities','types'));
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
            $request['activities'] = isset($request['activities']) ? array_filter($request['activities']) : [];
            $request['day_limit'] = isset($request['day_limit']) ? array_filter($request['day_limit']) : [];
            $request['limit_per_visitor'] = isset($request['limit_per_visitor']) ? array_filter($request['limit_per_visitor']) : [];

            $oldPackageResponse = Package::first($id);
            $oldPackage = [];

            if($oldPackageResponse['status'] === 'success'){
                $oldPackage = $oldPackageResponse['data'];
            }
            //dd($oldPackage);
            $oldPackageActivities = [];
            foreach ($oldPackage->activities as $activity){
                $oldPackageActivities[] = $activity->name;
            }

            $oldPackageTypeResponse = PackageType::first($oldPackage->package_type_id);
            $oldDayResponse = Day::first($oldPackage->day_id);

            $odlPackageType = [];
            $oldDay = [];

            if($oldPackageTypeResponse['status'] === 'success'){
                $odlPackageType = $oldPackageTypeResponse['data']->name;
            }

            if($oldDayResponse['status'] === 'success'){
                $oldDay = $oldDayResponse['data']->name;
            }


            $oldPackage->unsetRelation('activities');

            $oldPackage['activities'] = $oldPackageActivities;
            $oldPackage['package_type'] = $odlPackageType;
            $oldPackage['day'] = $oldDay;


            $errors = [];
            $validator = Validator::make($request->all(), [
                "activities"    => "required|array|min:1"
            ]);
    
            if ($validator->fails()) {
                $errors = $validator->errors()->toArray();
            }

            $response = Package::update($id, $this->prepareRequest($request));

            if ($response['status'] === 'error') {
                if (is_array($response['data'])) {
                    $errors = array_merge($errors, $response['data']);
                }
            }

            if ($response['status'] === 'success') {

                $newPackage = $response['data'];
                $newPackageActivities = [];
                foreach ($newPackage->activities as $activity){
                    $newPackageActivities[] = $activity->name;
                }

                $newPackageTypeResponse = PackageType::first($newPackage->package_type_id);
                $newDayResponse = Day::first($newPackage->day_id);

                $newPackageType = [];
                $newDay = [];

                if($newPackageTypeResponse['status'] === 'success'){
                    $newPackageType = $newPackageTypeResponse['data']->name;
                }

                if($newDayResponse['status'] === 'success'){
                    $newDay = $newDayResponse['data']->name;
                }


                $newPackage->unsetRelation('activities');

                $newPackage['activities'] = $newPackageActivities;
                $newPackage['package_type'] = $newPackageType;
                $newPackage['day'] = $newDay;

                $logResponse = Log::save([
                    'admin_id' => auth()->id(),
                    'log_name' => 'Package',
                    'log_type' => 'Updated',
                    'description' => $request->name,
                    'field_id' => $response['data']->id,
                    'from' => $oldPackage,
                    'to' => $newPackage
                ]);


            }


            if (count($errors) > 0) {
                Session::flash('update-package-status', $request->status === 'on' ? true : false);
                return back()->withInput($request->all())->withErrors($errors);
            }

            Session::flash('package-update', 'Package updated successfully.');

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
            $package = Package::delete($id);

            return response()->json($package);

        } catch (\Exception $ex) {
            return response()->json([
                'status' => 'error',
                'data' => $ex->getMessage()
            ]);
        }
        
    }

    protected function prepareRequest(Request $request)
    {
        return [
            'day_id'            => $request->day_id,
            'package_type_id'   => $request->package_type_id,
            'name'              => $request->name,
            'arabic_name'       => $request->arabic_name,
            'price'             => $request->price,
            'quantity'          => $request->quantity,
            'activities'        => $request->activities,
            'day_limit'        => $request->day_limit,
            'limit_per_visitor'        => $request->limit_per_visitor,
            'description'       => $request->description,
            'arabic_description'       => $request->arabic_description,
            'gate_access'       => $request->gate_access ?? 0,
            'status'            => $request->status === 'on' ? true : false,
            'fixed_quantity'    => $request->fixed_quantity ?? 0,
        ];
    }
}
