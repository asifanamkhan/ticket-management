@extends('admin.layouts.master')

@section('content')
    <div class="intro-y flex items-center mt-8">
        <div class="breadcrumb mr-auto custom-breadcrumb"> 
            <a href="{{ route('admin.days.index') }}" class="breadcrumb-link">Days</a> 
            <i data-feather="chevron-right" class="breadcrumb__icon"></i> 
            <span class="breadcrumb--active">Create Day</span> 
        </div>
    </div>

    <div class="intro-y box mt-8">
        <div class="p-8" id="input">
            @if (session()->has('day-create'))
                <div class="alert alert-success-soft show flex items-center mb-2" role="alert"> 
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-triangle w-6 h-6 mr-2">
                        <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                        <line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line>
                    </svg> {{ session('day-create') }} </div>
            @endif
            <form action="{{ route('admin.days.store') }}" method="post">
                @csrf
                <div class="grid grid-cols-1 gap-4 ">
                    <div class="grid grid-cols-1 ">
                        <div class="">
                            <label for="" class="form-label">Code <span class="text-theme-24">*</span></label>
                            <input type="text" name="code"
                                   class="form-control border-gray-300 @error('code') border-theme-24 @enderror"
                                   placeholder="FRI" value="{{ old('code') }}" autocomplete="code"
                                   autofocus>
                            @error('code')
                            <span class="text-theme-24 mt-2">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                    </div>

                    <div class="grid grid-cols-1">
                        <div class="">
                            <label for="" class="form-label">Name <span class="text-theme-24">*</span></label>
                            <input type="text" name="name"
                                   class="form-control border-gray-300 @error('name') border-theme-24 @enderror"
                                   placeholder="Friday" value="{{ old('name') }}" autocomplete="name"
                                   autofocus>
                            @error('name')
                            <span class="text-theme-24 mt-2">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 ">
                        <div class="">
                            <label for="" class="form-label">Arabic name <i class="text-theme-24">*</i></label>
                            <input type="text" name="arabic_name"
                                   class="form-control border-gray-300 @error('arabic_name') border-theme-24 @enderror"
                                   placeholder="Arabic name" value="{{ old('arabic_name') }}" autocomplete="arabic_name"
                                   autofocus>
                            @error('arabic_name')
                            <span class="text-theme-24 mt-2">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                    </div>

                    <div class="grid grid-cols-1 ">
                        <div class="">
                            <label for="" class="form-label">From</label>
                            <input type="date" name="from"
                                   class="form-control border-gray-300 @error('from') border-theme-24 @enderror"
                                   placeholder="Arabic name" value="{{ old('from') }}" autocomplete="from"
                                   autofocus>
                            @error('from')
                            <span class="text-theme-24 mt-2">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                    </div>

                    <div class="grid grid-cols-1 ">
                        <div class="">
                            <label for="" class="form-label">To</label>
                            <input type="date" name="to"
                                   class="form-control border-gray-300 @error('to') border-theme-24 @enderror"
                                   placeholder="Arabic name" value="{{ old('to') }}" autocomplete="to"
                                   autofocus>
                            @error('to')
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
