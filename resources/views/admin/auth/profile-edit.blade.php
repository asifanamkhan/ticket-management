@extends('admin.layouts.master')

@section('content')
    <!-- BEGIN: Content -->

            <!-- BEGIN: Content -->
            <div class="content">

                    <div class="col-span-12 lg:col-span-12 2xl:col-span-9">
                        <!-- BEGIN: Personal Information -->
                        <div class="intro-y box lg:mt-5">
                            <div class="flex items-center p-5 border-b border-gray-200 dark:border-dark-5">
                                <h2 class="font-medium text-base mr-auto">
                                    Edit Admin Information
                                </h2>
                            </div>
                            <div class="p-5">
                                @if (session()->has('admin-profile-update'))
                                    <div class="alert alert-success-soft show flex items-center mb-2" role="alert">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-triangle w-6 h-6 mr-2">
                                            <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                                            <line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line>
                                        </svg> {{ session('admin-profile-update') }}
                                    </div>
                                @endif
                                <form method="post" action="{{ route('admin.profile.update', auth()->user()->id) }}">
                                    @method('PUT')
                                    @csrf
                                    <div class="flex flex-col-reverse xl:flex-row flex-col">
                                        <div class="flex-1 mt-6 xl:mt-0">
                                            <div class="grid grid-cols-12 gap-x-5">
                                                <div class="col-span-12 2xl:col-span-6">
                                                    <div>
                                                        <label for="update-profile-form-1" class="form-label">Name</label>
                                                        <input id="update-profile-form-1" type="text" name="name" class="form-control" placeholder="Name" value=" {{ $errors->has('name') ? old('name') : auth()->user()->name }}">
                                                        @error('name')
                                                        <span class="text-theme-24">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                    <div class="mt-3">
                                                        <label for="update-profile-form-1" class="form-label">Email</label>
                                                        <input id="update-profile-form-1" type="text" name="email" class="form-control" placeholder="Email" value="{{ $errors->has('email') ? old('email') : auth()->user()->email }}" >
                                                        @error('email')
                                                        <span class="text-theme-24">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-primary w-20 mt-3">Save</button>
                                        </div>
                                        {{--<div class="w-52 mx-auto xl:mr-0 xl:ml-6">--}}
                                            {{--<div class="border-2 border-dashed shadow-sm border-gray-200 dark:border-dark-5 rounded-md p-5">--}}
                                                {{--<div class="h-40 relative image-fit cursor-pointer zoom-in mx-auto">--}}
                                                    {{--{!! QrCode::size(150)->generate(route('scan.packages', ['id' => auth()->user()->id])) !!}--}}
                                                {{--</div>--}}
                                                {{--<div class="mx-auto cursor-pointer relative mt-5">--}}
                                                    {{--<a href="{{ route('visitor.qrcode.download') }}" type="button" class="btn btn-primary w-full">Download</a>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- END: Personal Information -->
                    </div>
                </div>

            <!-- END: Content -->
@endsection
