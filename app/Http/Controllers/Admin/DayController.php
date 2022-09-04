<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\Day;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class DayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = Day::all();
        $days = [];

        if ($response['status'] === 'success') {
            $days = $response['data'];
        }
        return view('admin.days.index', compact('days'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.days.create');
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
            $response = Day::save([
                'name' => $request->name,
                'arabic_name' => $request->arabic_name,
                'code' => $request->code,
                'from' => $request->from ?? null,
                'to' => $request->to ?? null,
            ]);

            if ($response['status'] === 'error') {;
                return back()->withInput($request->all())->withErrors($response['data']);
            }

            Session::flash('day-create', 'Day Created successfully.');

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
        return view('admin.days.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  integer  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $response = Day::first($id);
        $day = $response['data'];

        if ($response['status'] === 'error' ) {
            throw new \Exception($day);
        }

        return view('admin.days.edit', compact('day'));
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
            $response = Day::update($id, [
                'name' => $request->name,
                'arabic_name' => $request->arabic_name,
                'code' => $request->code,
                'from' => $request->from ?? null,
                'to' => $request->to ?? null,
            ]);

            if ($response['status'] === 'error') {
                return back()->withInput($request->all())->withErrors($response['data']);
            }

            Session::flash('day-update', 'Day Updated successfully.');

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
            $day = Day::delete($id);

            return response()->json($day);

        } catch (\Exception $ex) {
            return response()->json([
                'status' => 'error',
                'data' => $ex->getMessage()
            ]);
        }
        
    }
}
