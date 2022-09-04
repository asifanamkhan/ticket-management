<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Log;


class LogController extends Controller
{
    public function addOnIndex(){

        $activity_logs = Log::where('log_name','Activity')
            ->orderBy('id', 'DESC')
            ->get();

        return view('admin.log.activities.index',compact('activity_logs'));

    }

    public function addOnShow($id){
        $activity_log = Log::findOrFail($id);

        if($activity_log){
            return view('admin.log.activities.show',compact('activity_log'));

        }
    }

    public function packageIndex(){
        $activity_logs = Log::where('log_name','Package')
            ->orderBy('id', 'DESC')->get();
        //dd($activity_logs);
        return view('admin.log.packages.index',compact('activity_logs'));
    }

    public function packageShow($id){
        $activity_log = Log::findOrFail($id);
        //dd($activity_log->to);
        if($activity_log){
            return view('admin.log.packages.show',compact('activity_log'));

        }
    }

    public function visitorIndex(){
        $activity_logs = Log::where('log_name','Visitor')
            ->orderBy('id', 'DESC')->get();
        //dd($activity_logs);
        return view('admin.log.visitors.index',compact('activity_logs'));
    }

    public function visitorShow($id){
        $activity_log = Log::findOrFail($id);
        //dd($activity_log->to);
        if($activity_log){
            return view('admin.log.visitors.show',compact('activity_log'));

        }
    }
}
