@extends('admin.layouts.master')

@section('content')
    <div class="intro-y flex items-center mt-8">
        <div class="breadcrumb mr-auto custom-breadcrumb">
            <a href="{{ route('admin.visitors.index') }}" class="breadcrumb-link">Visitor</a>
            <i data-feather="chevron-right" class="breadcrumb__icon"></i>
            <span class="breadcrumb--active">Create visitor</span>
        </div>
    </div>

    <div class="intro-y box mt-8">
        <div class="p-8" id="input">
            @if (session()->has('visitor-create'))
                <div class="alert alert-success-soft show flex items-center mb-2" role="alert">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-triangle w-6 h-6 mr-2">
                        <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                        <line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line>
                    </svg> {{ session('visitor-create') }} </div>
            @endif
            <form action="{{ route('admin.visitors.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-2 gap-4 ">
                    <div class="grid grid-cols-1 ">
                        <div class="">
                            <label for="" class="form-label">First name <i class="text-theme-24">*</i></label>
                            <input type="text" name="first_name"
                                   class="form-control border-gray-300 @error('first_name') border-theme-24 @enderror"
                                   placeholder="first name" value="{{ old('first_name') }}" autofocus>
                            @error('first_name')
                            <span class="text-theme-24 mt-2">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <label for="" class="form-label">Email <i class="text-theme-24">*</i></label>
                            <input type="text" name="email"
                                   class="form-control border-gray-300 @error('email') border-theme-24 @enderror"
                                   placeholder="email name" value="{{ old('email') }}" >
                            @error('email')
                            <span class="text-theme-24 mt-2">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>



                        <div class="mt-4">
                            <label for="" class="form-label">Address </label>
                            <input type="text" name="address"
                                   class="form-control border-gray-300 @error('address') border-theme-24 @enderror"
                                   placeholder="address" value="{{ old('address') }}">
                            @error('address')
                            <span class="text-theme-24 mt-2">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>


                            <div class="mt-4">
                                <label for="" class="form-label">City </label>
                                <input type="text" name="city"
                                       class="form-control border-gray-300 @error('city') border-theme-24 @enderror"
                                       placeholder="city" value="{{ old('city') }}">
                                @error('city')city
                                <span class="text-theme-24 mt-2">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="mt-4">
                                <label for="" class="form-label">password <span class="text-theme-24">*</span></label>
                                <input type="password" name="password"
                                       class="form-control border-gray-300 @error('password') border-theme-24 @enderror"
                                       placeholder="password" value="{{ old('password') }}">
                                @error('password')
                                <span class="text-theme-24 mt-2">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="mt-4">
                                <label for="" class="form-label">Confirm Password <span class="text-theme-24">*</span></label>
                                <input type="password" name="password_confirmation"
                                       class="form-control border-gray-300 @error('password_confirmation') border-theme-24 @enderror"
                                       placeholder="password_confirmation"
                                >

                            </div>

                    </div>

                    <div class="grid grid-cols-1">
                        <div class="">
                            <label for="" class="form-label">Last name <i class="text-theme-24">*</i></label>
                            <input type="text" name="last_name"
                                   class="form-control border-gray-300 @error('last_name') border-theme-24 @enderror"
                                   placeholder="last name" value="{{ old('last_name') }}">
                            @error('last_name')
                            <span class="text-theme-24 mt-2">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="intro-x ">
                            <label>Gender </label>
                            <div class="mt-2">
                                <select id="gender" type="text" name="gender" data-placeholder="Select a gender" class="tom-select w-full">
                                    <option value="">Select a gendergender</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="other">Other</option>

                                </select>
                                @error('gender')
                                <span class="text-theme-24 mt-2">
                                <strong>{{ $message }}</strong>
                            </span>
                                @enderror
                            </div>
                        </div>

                        <div class="">
                            <label for="" class="form-label">Mobile <i class="text-theme-24">*</i></label>
                            <input type="text" name="mobile"
                                   class="form-control border-gray-300 @error('mobile') border-theme-24 @enderror"
                                   placeholder="mobile" value="{{ old('mobile') }}">
                            @error('mobile')
                            <span class="text-theme-24 mt-2">
                                <strong>{{ $message }}</strong>
                            </span>mobile
                            @enderror
                        </div>

                        <div class="">
                            <label class="form-label">Country </label>
                            <select id="country_id" type="text" name="country_id" data-placeholder="Select a country" class="tom-select w-full">
                                <option value="">Select a country</option>
                                @foreach($countries as $country)
                                    <option value="{{ $country->id }}" {{ $country->id == old('country_id') ? 'selected' : '' }}>{{ $country->name }}</option>
                                @endforeach
                            </select>
                            @error('country_id')
                            <span class="text-theme-24 mt-2">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div >
                            <label for="" class="form-label" >State </label>
                            <input type="text" name="state" class="  form-control border-gray-300 @error('state') border-theme-24 @enderror" placeholder="state" value="{{ old('state') }}">
                            @error('state')
                            <span class="text-theme-24 mt-2">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div >
                            <label for="" class="form-label">Zip /label>
                            <input type="text" name="zip" class="form-control border-gray-300 @error('zip') border-theme-24 @enderror" placeholder="zip" value="{{ old('zip') }}">
                            @error('zip')
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
