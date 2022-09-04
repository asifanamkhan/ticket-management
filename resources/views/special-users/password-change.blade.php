@extends('special-users.layout.master')
@section('content')
    <div class="flex items-center p-5 border-b border-gray-200 dark:border-dark-5">
        <h2 class="font-medium text-base mr-auto">
            Change password
        </h2>
    </div>
    <div class="p-5">
        @if (session()->has('special-user-password-change'))
            <div class="alert alert-success-soft show flex items-center mb-2" role="alert">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                     class="feather feather-alert-triangle w-6 h-6 mr-2">
                    <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                    <line x1="12" y1="9" x2="12" y2="13"></line>
                    <line x1="12" y1="17" x2="12.01" y2="17"></line>
                </svg> {{ session('special-user-password-change') }} </div>
        @endif

            <form action="{{ route('special-user.password.update',Auth::guard('specialUser')->user()->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
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

                <div class="text-right mt-4">
                    <button class="btn btn-primary w-24">Save</button>
                </div>
            </form>

    </div>
@endsection
