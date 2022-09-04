<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BulkImport;
use Illuminate\Http\Request;

class BulkImportController extends Controller
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
        //
    }

    public function fileUpload(){
        return view('admin.bulk-import.file-import');
    }

    public function mapping(){

        return view('admin.bulk-import.mapping');
    }

    public function save(){
        return view('admin.bulk-import.save');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BulkImport  $bulkImport
     * @return \Illuminate\Http\Response
     */
    public function show(BulkImport $bulkImport)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BulkImport  $bulkImport
     * @return \Illuminate\Http\Response
     */
    public function edit(BulkImport $bulkImport)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BulkImport  $bulkImport
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BulkImport $bulkImport)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BulkImport  $bulkImport
     * @return \Illuminate\Http\Response
     */
    public function destroy(BulkImport $bulkImport)
    {
        //
    }
}
