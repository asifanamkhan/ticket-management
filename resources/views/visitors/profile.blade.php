@extends('visitors.layout.master')
@section('content')
    <div class="flex items-center p-5 border-b border-gray-200 dark:border-dark-5">
        <h2 class="font-medium text-base mr-auto">
            Edit Personal Information
        </h2>
    </div>
    <div class="p-5">
        @if (session()->has('user-update'))
            <div class="alert alert-success-soft show flex items-center mb-2" role="alert">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                     class="feather feather-alert-triangle w-6 h-6 mr-2">
                    <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                    <line x1="12" y1="9" x2="12" y2="13"></line>
                    <line x1="12" y1="17" x2="12.01" y2="17"></line>
                </svg> {{ session('user-update') }} </div>
        @endif
        <form method="post" action="{{ route('visitor.profile.update', ['profile' => auth()->user()->id]) }}">
            @method('PUT')
            @csrf
            <div class="flex flex-col-reverse xl:flex-row flex-col">
                <div class="flex-1 mt-6 xl:mt-0">
                    <div class="grid grid-cols-12 gap-x-5">
                        <div class="col-span-12 2xl:col-span-6">
                            <div>
                                <label for="update-profile-form-1" class="form-label">First Name</label>
                                <input id="update-profile-form-1" type="text" name="first_name" class="form-control"
                                       placeholder="First Name"
                                       value=" {{ $errors->has('first_name') ? old('first_name') : auth()->user()->first_name }}">

                                @error('first_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="mt-3">
                                <label for="update-profile-form-1" class="form-label">Last Name</label>
                                <input id="update-profile-form-1" type="text" name="last_name" class="form-control"
                                       placeholder="Last Name"
                                       value="{{ $errors->has('last_name') ? old('last_name') : auth()->user()->last_name }}">

                                @error('last_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="mt-3">
                                <label for="update-profile-form-1" class="form-label">Email</label>
                                <input id="update-profile-form-1" type="text" name="email" class="form-control"
                                       placeholder="Email" value="{{ auth()->user()->email }}" readonly>
                            </div>
                            <div class="mt-3">
                                <label for="update-profile-form-4" class="form-label">Mobile Number</label>
                                <input id="update-profile-form-4" type="text" name="mobile" class="form-control"
                                       placeholder="Mobile Number"
                                       value="{{ $errors->has('mobile') ? old('mobile') : auth()->user()->mobile }}">

                                @error('mobile')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="mt-3">
                                <label for="" class="form-label">Gender</label>
                                <select id="" data-search="true" class="tom-select w-full"
                                        name="gender">
                                    <option value="">Select a gender</option>

                                    @if ($errors->has('gender'))
                                        <option value="male" {{  old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                        <option value="female" {{ old('gender') == 'female' ? 'selected' : ''  }}>Female</option>
                                        <option value="other" {{ old('gender') == 'other' ? 'selected' : ''  }}>Other</option>
                                    @else
                                        <option value="male" {{ auth()->user()->gender == 'male' ? 'selected' : '' }}>Male</option>
                                        <option value="female" {{ auth()->user()->gender == 'female' ? 'selected' : '' }}>Female</option>
                                        <option value="other" {{ auth()->user()->gender == 'other' ? 'selected' : '' }}>Other</option>
                                    @endif


                                </select>

                                @error('country_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="mt-3">
                                <label for="update-profile-form-4" class="form-label">City</label>
                                <input id="update-profile-form-4" type="text" name="city" class="form-control"
                                       placeholder="City"
                                       value="{{ $errors->has('city') ? old('city') : auth()->user()->city }}">

                                @error('city')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="mt-3">
                                <label for="update-profile-form-5" class="form-label">Address</label>
                                <textarea id="update-profile-form-5" name="address" class="form-control"
                                          placeholder="Adress">{{ $errors->has('address') ? old('address') : auth()->user()->address }}</textarea>

                                @error('address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="mt-3">
                                <label for="update-profile-form-2" class="form-label">Country</label>
                                <select id="update-profile-form-2" data-search="true" class="tom-select w-full"
                                        name="country_id">
                                    <option value="">Select a country</option>
                                    @foreach($countries as $country)
                                        @if ($errors->has('country_id'))
                                            <option value="{{ $country->id }}" {{ $country->id === old('country_id') ? 'selected' : '' }}>{{ $country->name }}</option>
                                        @else
                                            <option value="{{ $country->id }}" {{ $country->id === auth()->user()->country_id ? 'selected' : '' }}>{{ $country->name }}</option>
                                        @endif

                                    @endforeach
                                </select>

                                @error('country_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-span-12">

                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-20 mt-3">Save</button>
                </div>
                <div class="w-52 mx-auto xl:mr-0 xl:ml-6">
                    <div class="border-2 border-dashed shadow-sm border-gray-200 dark:border-dark-5 rounded-md p-5">
                        <div class="h-40 relative image-fit cursor-pointer zoom-in mx-auto">
                            {!! QrCode::size(150)->generate(route('scan.packages', ['id' => auth()->user()->id])) !!}
                        </div>
                        <div class="mx-auto cursor-pointer relative mt-5">
                            <a href="{{ route('visitor.qrcode.download') }}" type="button"
                               class="btn btn-primary w-full">Download</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
