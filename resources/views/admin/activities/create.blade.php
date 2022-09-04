@extends('admin.layouts.master')

@section('content')
    <div class="intro-y flex items-center mt-8">
        <div class="breadcrumb mr-auto custom-breadcrumb"> 
            <a href="{{ route('admin.activities.index') }}" class="breadcrumb-link">Add ons</a>
            <i data-feather="chevron-right" class="breadcrumb__icon"></i> 
            <span class="breadcrumb--active">Create Add on</span>
        </div>
    </div>

    <div class="intro-y box mt-8">
        <div class="p-8" id="input">
            @if (session()->has('activity-create'))
                <div class="alert alert-success-soft show flex items-center mb-2" role="alert"> 
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-triangle w-6 h-6 mr-2">
                        <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                        <line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line>
                    </svg> {{ session('activity-create') }} </div>
            @endif
            <form action="{{ route('admin.activities.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-2 gap-4 ">
                    <div class="grid grid-cols-1 ">
                        <div class="">
                            <label for="" class="form-label">Name <i class="text-theme-24">*</i></label>
                            <input type="text" name="name"
                                   class="form-control border-gray-300 @error('name') border-theme-24 @enderror"
                                   placeholder="name" value="{{ old('name') }}" autocomplete="name"
                                   autofocus>
                            @error('name')
                            <span class="text-theme-24 mt-2">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <label for="" class="form-label">Arabic Name <i class="text-theme-24">*</i></label>
                            <input type="text" name="arabic_name"
                                   class="form-control border-gray-300 @error('arabic_name') border-theme-24 @enderror"
                                   placeholder="arabic name" value="{{ old('arabic_name') }}" autocomplete="arabic_name"
                                   autofocus>
                            @error('arabic_name')
                            <span class="text-theme-24 mt-2">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <label for="" class="form-label">Price</label>
                            <input type="number" name="price"
                                   class="form-control border-gray-300 @error('price') border-theme-24 @enderror"
                                   placeholder="price" value="{{ old('price') }}" autocomplete="price"
                                   autofocus>
                            @error('price')
                            <span class="text-theme-24 mt-2">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="grid grid-cols-3 mt-4">
                            <div class="">
                                <label for="" class="form-label">Highlight</label>
                                <div class="">
                                    @if(session()->has('activity-highlight'))
                                    <input type="checkbox" name="highlight" class="form-check-switch" {{ session()->get('activity-highlight') === true ? 'checked' : ''}} >
                                    @else
                                    <input type="checkbox" name="highlight" class="form-check-switch" >
                                    @endif
                                </div>
                                @error('highlight')
                                <span class="text-theme-24 mt-2">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="">
                                <label for="" class="form-label">Concert</label>
                                <div class="">
                                    @if(session()->has('activity-concert'))
                                        <input type="checkbox" name="concert" class="form-check-switch" {{ session()->get('activity-concert') === true ? 'checked' : ''}} >
                                    @else
                                        <input type="checkbox" name="concert" class="form-check-switch" >
                                    @endif
                                </div>
                                @error('concert')
                                <span class="text-theme-24 mt-2">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="">
                                <label for="" class="form-label">Status</label>
                                <div class="">
                                    @if(session()->has('activity-status'))
                                    <input type="checkbox" name="status" class="form-check-switch" {{ session()->get('activity-status') === true ? 'checked' : ''}} >
                                    @else
                                    <input type="checkbox" name="status" class="form-check-switch" checked >
                                    @endif
                                </div>
                                @error('status')
                                <span class="text-theme-24 mt-2">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-4">
                            <label class="form-label">Upload Image</label>
                            <input name="images[]" id="images" type="file" style="display:none" multiple/> 
                            <div action="/file-upload" class="dropzone" data-auto-upload="false" data-fallback="images"> 
                                <div class="dz-message" data-dz-message> 
                                    <div class="text-lg font-medium">Drop files here or click to upload.</div> 
                                    <div class="text-gray-600"> This is just a demo dropzone. Selected files are <span class="font-medium">not</span> actually uploaded. </div> 
                                </div> 
                            </div> 

                            @error('image')
                            <span class="text-theme-24 mt-2">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror

                        </div>

                    </div>

                    <div class="grid grid-cols-1">
                        <div class="intro-x ">
                            <label for="" class="form-label">Description</label>
                            <textarea name="description" class="editor">
                                {{ old('description') }}
                            </textarea>
                            @error('description')
                            <span class="text-theme-24 mt-2">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="intro-x mt-4">
                            <label for="" class="form-label">Arabic  Description</label>
                            <textarea name="arabic_description" class="editor">
                                {{ old('arabic_description') }}
                            </textarea>
                            @error('arabic_description')
                            <span class="text-theme-24 mt-2">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                </div>
                <div class="text-right mt-4">
                    <button class="btn btn-primary w-24">Save</button>
                </div>
            </form>
        </div>
    </div>
@endsection
