@extends('admin.layouts.master')

@section('content')
    <div class="intro-y flex items-center mt-8">
        <div class="breadcrumb mr-auto custom-breadcrumb">
            <a href="{{ route('admin.bulk-imports.index') }}" class="breadcrumb-link">Bulk imports</a>
            <i data-feather="chevron-right" class="breadcrumb__icon"></i>
            <span class="breadcrumb--active">File upload</span>
        </div>
    </div>

    <div class="intro-y box mt-8">
        <div class="p-8" id="input">
            @if (session()->has('bulk-import-create'))
                <div class="alert alert-success-soft show flex items-center mb-2" role="alert">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-triangle w-6 h-6 mr-2">
                        <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                        <line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line>
                    </svg> {{ session('bulk-import-create') }} </div>
            @endif
            <form action="{{ route('admin.bulk.mapping') }}" method="post">
                @csrf

                <div class="mt-4">
                    <label class="form-label">Select File</label>
                    <input name="file" id="file" type="file" style="display:none" />
                    <div action="/file-upload" class="dropzone" data-auto-upload="false" data-fallback="images">
                        <div class="dz-message" data-dz-message>
                            <div class="text-lg font-medium">Drop files here or click to upload.</div>
                            <div class="text-gray-600"> Selected files are <span class="font-medium">not</span> actually uploaded. </div>
                        </div>
                    </div>

                    @error('file')
                    <span class="text-theme-24 mt-2">
                                <strong>{{ $message }}</strong>
                            </span>
                    @enderror

                </div>

                <div class="text-right mt-4">
                    <button class="btn btn-primary w-24">Map</button>
                </div>
            </form>
        </div>
    </div>
@endsection
