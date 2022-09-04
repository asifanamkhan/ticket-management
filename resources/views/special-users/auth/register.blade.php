@extends('special-users.auth.layout.master')
@section('content')

    <div class="">
        <div
            class="my-auto mx-auto xl:ml-20 bg-white dark:bg-dark-1 xl:bg-transparent px-5 sm:px-8 py-8 xl:p-0 rounded-md shadow-md xl:shadow-none w-full sm:w-3/4 lg:w-2/4 xl:w-auto">

            <form method="POST" action="{{ route('special-user.register') }}" enctype="multipart/form-data">
                @csrf

                <h2 class="intro-x font-bold text-2xl xl:text-3xl text-center xl:text-left">
                    Special User Register
                </h2>
                <div class="grid grid-cols-2 gap-4">
                    <div class="intro-x mt-8">
                        <label for="" class="form-label">First Name <span class="text-theme-24">*</span></label>
                        <input type="text" name="full_name"
                               class="intro-x  form-control py-3 px-4 border-gray-300 block @error('full_name') border-theme-24 @enderror"
                               placeholder="Full name" value="{{ old('full_name') }}">
                        @error('full_name')
                        <span class="text-theme-24 mt-2">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="intro-x mt-8">
                        <label for="" class="form-label">Company Name <span class="text-theme-24">*</span></label>
                        <input type="text" name="company_name"
                               class="intro-x  form-control py-3 px-4 border-gray-300 block @error('company_name') border-theme-24 @enderror"
                               placeholder="Company name" value="{{ old('company_name') }}">
                        @error('company_name')
                        <span class="text-theme-24 mt-2">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="intro-x ">
                        <label>Type <span class="text-theme-24">*</span></label>
                        <div class="mt-2">
                            <select id="type" type="text" name="type" data-placeholder="Select a type"
                                    class="tom-select w-full">
                                <option value="">Select a type</option>
                                <option value="media" {{ old('type') === 'media' ? 'selected' : '' }}>Media</option>
                                <option value="sponsor" {{ old('type') === 'sponsor' ? 'selected' : '' }}>Sponsor</option>
                                <option value="usher" {{ old('type') === 'usher' ? 'selected' : '' }}>Usher</option>
                            </select>
                            @error('type')
                            <span class="text-theme-24 mt-2">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="intro-x ">
                        <label for="" class="form-label">Email <span class="text-theme-24">*</span></label>
                        <input type="email" name="email"
                               class="intro-x  form-control py-3 px-4 border-gray-300 block @error('email') border-theme-24 @enderror"
                               placeholder="Email" value="{{ old('email') }}">
                        @error('email')
                        <span class="text-theme-24 mt-2">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="intro-x ">
                        <label for="" class="form-label">Mobile <span class="text-theme-24">*</span></label>
                        <input type="number" name="mobile"
                               class="intro-x  form-control py-3 px-4 border-gray-300 block @error('mobile') border-theme-24 @enderror"
                               placeholder="mobile" value="{{ old('mobile') }}">
                        @error('mobile')
                        <span class="text-theme-24 mt-2">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="intro-x ">
                        <label for="" class="form-label">Address </label>
                        <input type="text" name="address"
                               class="intro-x  form-control py-3 px-4 border-gray-300 block @error('address') border-theme-24 @enderror"
                               placeholder="address" value="{{ old('address') }}">
                        @error('address')
                        <span class="text-theme-24 mt-2">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="intro-x ">
                        <label>Country </label>
                        <div class="mt-2">
                            <select id="country_id" type="text" name="country_id" data-placeholder="Select a country"
                                    class="tom-select w-full">
                                <option value="">Select a country</option>
                                @foreach($countries as $country)
                                    <option
                                        value="{{ $country->id }}" {{ $country->id == old('country_id') ? 'selected' : '' }}>{{ $country->name }}</option>
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
                        <input type="text" name="city"
                               class="intro-x  form-control py-3 px-4 border-gray-300 block @error('city') border-theme-24 @enderror"
                               placeholder="city" value="{{ old('city') }}">
                        @error('city')
                        <span class="text-theme-24 mt-2">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="intro-x ">
                        <label for="" class="form-label">Password <span class="text-theme-24">*</span></label>
                        <input type="password" name="password"
                               class="intro-x  form-control py-3 px-4 border-gray-300 block  @error('email') border-theme-24 @enderror"
                               placeholder="Password">
                        @error('password')
                        <span class="text-theme-24 mt-2">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class=" ">
                        <label for="" class="form-label">Confirm Password <span class="text-theme-24">*</span></label>
                        <input type="password" name="password_confirmation"
                               class="intro-x  form-control py-3 px-4 border-gray-300 block"
                               placeholder="Password confirm">
                    </div>

                    <div class="" id="document">
                        <label for="" class="form-label">Document </label>
                        <input type="file" name="document"
                               class="intro-x  form-control py-3 px-4 border-gray-300 block @error('document') border-theme-24 @enderror"
                               value="{{ old('document') }}">
                        @error('document')
                        <span class="text-theme-24 mt-2">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="intro-x">
                            <span>
                                {!! NoCaptcha::renderJs() !!}
                                {!! NoCaptcha::display() !!}
                            </span>
                        @if ($errors->has('g-recaptcha-response'))
                            <span class="text-theme-24 mt-2">
                                <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                            </span>
                        @endif
                    </div>
                    {{--<div class="intro-x text-gray-700 dark:text-gray-600 text-xs sm:text-sm mt-4">--}}
                    {{--@if (Route::has('password.request'))--}}
                    {{--<div class="intro-x w-100">--}}
                    {{--<label for="" class="form-label">Forgot Password ?</label>--}}
                    {{--</div>--}}
                    {{--<a class="text-theme-21" href="{{ route('password.request') }}">--}}
                    {{--{{ __('Reset your Password') }}--}}
                    {{--</a>--}}
                    {{--@endif--}}
                    {{--</div>--}}
                </div>
                <div class="intro-x mt-5 xl:mt-8 text-center xl:text-left">
                    <button class="btn btn-primary py-3 px-4 w-full xl:w-32 xl:mr-3 align-top">Register</button>
                    Already have an account?
                    <a class="text-theme-21 ml-1" href="{{ route('special-user.login.form') }}">
                        {{ __('login') }}
                    </a>
                </div>

            </form>
        </div>
    </div>

@endsection
@section('script')
    <script
        src="https://code.jquery.com/jquery-3.6.0.js"
        integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
        crossorigin="anonymous"></script>
    <script>

        $('#type').val() === 'sponsor' ? $('#document').show() : $('#document').hide();
        $('#type').on('change', function () {
            $('#type').val() === 'sponsor' ? $('#document').show() : $('#document').hide();

        })
    </script>

@endsection


