@extends('auth.layout.master')
@section('content')

    <div class="">
        <div class="my-auto mx-auto xl:ml-20 bg-white dark:bg-dark-1 xl:bg-transparent px-5 sm:px-8 py-8 xl:p-0 rounded-md shadow-md xl:shadow-none w-full sm:w-3/4 lg:w-2/4 xl:w-auto">

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <h2 class="intro-x font-bold text-2xl xl:text-3xl text-center xl:text-left">
                    Register
                </h2>
                <div class="grid grid-cols-2 gap-4">
                    <div class="intro-x mt-8">
                        <label for="" class="form-label">First Name <span class="text-theme-24">*</span></label>
                        <input type="text" name="first_name" class="intro-x  form-control py-3 px-4 border-gray-300 block @error('first_name') border-theme-24 @enderror" placeholder="First name" value="{{ old('first_name') }}">
                        @error('first_name')
                            <span class="text-theme-24 mt-2">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="intro-x mt-8">
                        <label for="" class="form-label">Last Name <span class="text-theme-24">*</span></label>
                        <input type="text" name="last_name" class="intro-x  form-control py-3 px-4 border-gray-300 block @error('last_name') border-theme-24 @enderror" placeholder="Last name" value="{{ old('last_name') }}">
                        @error('last_name')
                            <span class="text-theme-24 mt-2">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="intro-x ">
                        <label for="" class="form-label">Email <span class="text-theme-24">*</span></label>
                        <input type="email" name="email" class="intro-x  form-control py-3 px-4 border-gray-300 block @error('email') border-theme-24 @enderror" placeholder="Email" value="{{ old('email') }}">
                        @error('email')
                            <span class="text-theme-24 mt-2">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="intro-x ">
                        <label for="" class="form-label">Mobile <span class="text-theme-24">*</span></label>
                        <input type="number" name="mobile" class="intro-x  form-control py-3 px-4 border-gray-300 block @error('mobile') border-theme-24 @enderror" placeholder="mobile" value="{{ old('mobile') }}">
                        @error('mobile')
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

                    <div class="intro-x ">
                        <label for="" class="form-label">Address </label>
                        <input type="text" name="address" class="intro-x  form-control py-3 px-4 border-gray-300 block @error('address') border-theme-24 @enderror" placeholder="address" value="{{ old('address') }}">
                        @error('address')
                        <span class="text-theme-24 mt-2">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="intro-x ">
                         <label>Country </label>
                        <div class="mt-2">
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
                    </div>

                    <div class="intro-x ">
                        <label for="" class="form-label">City </label>
                        <input type="text" name="city" class="intro-x  form-control py-3 px-4 border-gray-300 block @error('city') border-theme-24 @enderror" placeholder="city" value="{{ old('city') }}">
                        @error('city')
                        <span class="text-theme-24 mt-2">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="intro-x ">
                        <label for="" class="form-label">State </label>
                        <input type="text" name="state" class="intro-x  form-control py-3 px-4 border-gray-300 block @error('state') border-theme-24 @enderror" placeholder="state" value="{{ old('state') }}">
                        @error('state')
                        <span class="text-theme-24 mt-2">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="intro-x ">
                        <label for="" class="form-label">Zip </label>
                        <input type="text" name="zip" class="intro-x  form-control py-3 px-4 border-gray-300 block @error('zip') border-theme-24 @enderror" placeholder="zip" value="{{ old('zip') }}">
                        @error('zip')
                        <span class="text-theme-24 mt-2">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="intro-x ">
                        <label for="" class="form-label">Password <span class="text-theme-24">*</span></label>
                        <input type="password" name="password" class="intro-x  form-control py-3 px-4 border-gray-300 block  @error('password') border-theme-24 @enderror" placeholder="Password">
                        @error('password')
                            <span class="text-theme-24 mt-2">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class=" ">
                        <label for="" class="form-label">Confirm Password <span class="text-theme-24">*</span></label>
                        <input type="password" name="password_confirmation" class="intro-x  form-control py-3 px-4 border-gray-300 block" placeholder="Password confirm">
                    </div>

                    <div class="intro-x">
                            <span>
                                {!! NoCaptcha::renderJs() !!}
                                {!! NoCaptcha::display() !!}
                            </span>
                        @if ($errors->has('g-recaptcha-response'))
                            <span class="text-theme-24 mt-2" >
                                <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="intro-x text-gray-700 dark:text-gray-600 text-xs sm:text-sm mt-4">
                        @if (Route::has('password.request'))
                            <div class="intro-x w-100">
                                <label for="" class="form-label">Forgot Password ?</label>
                            </div>
                            <a class="text-theme-21" href="{{ route('password.request') }}">
                                {{ __('Reset your Password') }}
                            </a>
                        @endif
                    </div>
                </div>
                <div class="intro-x mt-5 xl:mt-8 text-center xl:text-left">
                    <button class="btn btn-primary py-3 px-4 w-full xl:w-32 xl:mr-3 align-top">Register</button>
                        @if (Route::has('login'))
                        Already have an account?
                            <a class="text-theme-21 ml-1" href="{{ route('login') }}">
                                {{ __('login') }}
                            </a>
                        @endif
                </div>

            </form>
        </div>
    </div>

@endsection



