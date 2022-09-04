@extends('admin.layouts.master')

@section('content')
    <div class="intro-y flex items-center mt-8">
        <div class="breadcrumb mr-auto custom-breadcrumb">
            <a href="{{ route('admin.specials.index') }}" class="breadcrumb-link">Special User</a>
            <i data-feather="chevron-right" class="breadcrumb__icon"></i>
            <span class="breadcrumb--active">Edit {{ $specialUser->name }}</span>
        </div>
    </div>

    <div class="intro-y box mt-8">
        <div class="p-8" id="input">
            @if (session()->has('special-user-update'))
                <div class="alert alert-success-soft show flex items-center mb-2" role="alert">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-triangle w-6 h-6 mr-2">
                        <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                        <line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line>
                    </svg> {{ session('special-user-update') }} </div>
            @endif
            <form action="{{ route('admin.specials.update',$specialUser->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-2 gap-4 ">
                    <div class="grid grid-cols-1 ">
                        <div class="">
                            <label for="" class="form-label">Name <span class="text-theme-24">*</span></label>
                            <input type="text" name="full_name"
                                   class="intro-x  form-control py-3 px-4 border-gray-300 block @error('full_name') border-theme-24 @enderror"
                                   placeholder="Full name" value="{{ $errors->has('full_name') ? old('full_name') : $specialUser->full_name ?? '' }}">
                            @error('full_name')
                            <span class="text-theme-24 mt-2">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <label for="" class="form-label">Company Name <span class="text-theme-24">*</span></label>
                            <input type="text" name="company_name"
                                   class="intro-x  form-control py-3 px-4 border-gray-300 block @error('company_name') border-theme-24 @enderror"
                                   placeholder="Company name" value="{{ $errors->has('company_name') ? old('company_name') : $specialUser->company_name ?? '' }}">
                            @error('company_name')
                            <span class="text-theme-24 mt-2">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <label>Type <span class="text-theme-24">*</span></label>
                            <div class="mt-2">
                                <select id="type" type="text" name="type" data-placeholder="Select a country"
                                        class="tom-select w-full">
                                    <option value="">Select a type</option>
                                    @if($errors->has('type'))
                                        <option value="media" {{ old('type') === 'media' ? 'selected' : '' }}>Media</option>
                                        <option value="sponsor" {{ old('type') === 'sponsor' ? 'selected' : '' }}>Sponsor</option>
                                        <option value="usher" {{ old('type') === 'usher' ? 'selected' : '' }}>Usher</option>
                                    @else
                                        <option value="media" {{ $specialUser->type === 'media' ? 'selected' : '' }}>Media</option>
                                        <option value="sponsor" {{ $specialUser->type === 'sponsor' ? 'selected' : '' }}>Sponsor</option>
                                        <option value="usher" {{ $specialUser->type === 'usher' ? 'selected' : '' }}>Usher</option>
                                    @endif
                                </select>
                                @error('type')
                                <span class="text-theme-24 mt-2">
                                <strong>{{ $message }}</strong>
                            </span>
                                @enderror
                            </div>
                        </div>


                        <div class="mt-4">
                            <label for="" class="form-label">Mobile <span class="text-theme-24">*</span></label>
                            <input type="number" name="mobile"
                                   class="intro-x  form-control py-3 px-4 border-gray-300 block @error('mobile') border-theme-24 @enderror"
                                   placeholder="mobile" value="{{ $errors->has('mobile') ? old('mobile') : $specialUser->mobile ?? '' }}">
                            @error('mobile')
                            <span class="text-theme-24 mt-2">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="">
                            <label for="mt-4" class="form-label">Status</label>
                            <div class="">
                                @if(session()->has('special-user-status'))
                                    <input type="checkbox" name="status" class="form-check-switch" {{ session()->get('special-user-status') === true ? 'checked' : ''}} >
                                @else
                                    <input type="checkbox" name="status" class="form-check-switch" {{ $specialUser->status == true ? 'checked' : ''}} >
                                @endif
                            </div>
                            @error('status')
                            <span class="text-theme-24 mt-2">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>




                    </div>

                    <div class="grid grid-cols-1">
                        {{--<div>--}}
                            {{--<div class="intro-x ">--}}
                                {{--<label for="" class="form-label">Message</label>--}}
                                {{--<textarea name="message" class="editor">--}}
                                {{--{{ $errors->has('message') ? old('message') : $specialUser->message ?? '' }}--}}
                            {{--</textarea>--}}
                                {{--@error('description')--}}
                                {{--<span class="text-theme-24 mt-2">--}}
                                {{--<strong>{{ $message }}</strong>--}}
                            {{--</span>--}}
                                {{--@enderror--}}
                            {{--</div>--}}
                        {{--</div>--}}

                        <div class="">
                            <label for="" class="form-label">Email <span class="text-theme-24">*</span></label>
                            <input type="email" name="email"
                                   class="intro-x  form-control py-3 px-4 border-gray-300 block @error('email') border-theme-24 @enderror"
                                   placeholder="Email" value="{{ $errors->has('email') ? old('email') : $specialUser->email ?? '' }}">
                            @error('email')
                            <span class="text-theme-24 mt-2">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <label>Country <span class="text-theme-24">*</span></label>
                            <div class="mt-2">
                                <select id="country_id" type="text" name="country_id" data-placeholder="Select a country"
                                        class="tom-select w-full">
                                    <option value="">Select a country</option>
                                    @foreach($countries as $country)
                                        @if($errors->has('country_id'))
                                            <option value="{{ $country->id }}" {{ $country->id == old('country_id') ? 'selected' : '' }}>{{ $country->name }}</option>
                                        @else
                                            <option value="{{ $country->id }}" {{ $country->id == $specialUser->country_id ? 'selected' : '' }}>{{ $country->name }}</option>
                                        @endif

                                    @endforeach
                                </select>
                                @error('country_id')
                                <span class="text-theme-24 mt-2">
                                <strong>{{ $message }}</strong>
                            </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-4">
                            <label for="" class="form-label">City <span class="text-theme-24">*</span></label>
                            <input type="text" name="city"
                                   class="intro-x  form-control py-3 px-4 border-gray-300 block @error('city') border-theme-24 @enderror"
                                   placeholder="city" value="{{ $errors->has('city') ? old('city') : $specialUser->city ?? '' }}">
                            @error('city')
                            <span class="text-theme-24 mt-2">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <label for="" class="form-label">Address <span class="text-theme-24">*</span></label>
                            <input type="text" name="address"
                                   class="intro-x  form-control py-3 px-4 border-gray-300 block @error('address') border-theme-24 @enderror"
                                   placeholder="address" value="{{ $errors->has('address') ? old('address') : $specialUser->address ?? '' }}">
                            @error('address')
                            <span class="text-theme-24 mt-2">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror

                        </div>


                        <div class="mt-4" id="document">
                            <label for="" class="form-label">Document </label>
                            <input type="file" name="document"
                                   class="intro-x  form-control py-3 px-4 border-gray-300 block @error('document') border-theme-24 @enderror"
                                   value="{{ old('document') }}">
                            <input type="hidden" name="oldDocument" value="{{$specialUser->document}}">
                            @error('document')
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

@push('scripts')
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

@endpush
