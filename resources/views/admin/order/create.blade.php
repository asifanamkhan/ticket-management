@extends('admin.layouts.master')

@section('content')

    <!-- BEGIN: Content -->

    <div class="content">

        <div class="intro-y flex items-center mt-8">
            <div class="breadcrumb mr-auto custom-breadcrumb">
                <a href="{{ route('admin.orders.index') }}" class="breadcrumb-link">Orders</a>
                <i data-feather="chevron-right" class="breadcrumb__icon"></i>
                <span class="breadcrumb--active">Create order</span>
            </div>
        </div>

        <!-- BEGIN: HTML Table Data -->

        <div class="intro-y box p-5 mt-5">
            @if (session()->has('order-create'))
                <div class="alert alert-success-soft show flex items-center mb-2" role="alert">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-triangle w-6 h-6 mr-2">
                        <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                        <line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line>
                    </svg> {{ session('order-create') }} </div>
            @endif
            <form action="{{route('admin.orders.store')}}" method="post">
                @csrf
                <div class="w-full">
                    <select class="package-type form-control @error('user') border-theme-24 @enderror" name="user">
                        <option value="">Select user</option>
                        @foreach($users as $user )
                            <option value="{{$user->id}}">{{ $user->first_name }} {{$user->last_name}}</option>
                        @endforeach
                    </select>
                    @error('user')
                    <span class="text-theme-24 mt-2">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div id="order-items" class=""></div>

                <div class="order-item ">
                    <div class="flex flex-nowrap gap-2 mt-4">
                        <div class="w-full">
                            <select class="package-type form-control @error('types') border-theme-24 @enderror" name="types[]">
                                <option value="">Select type</option>
                                @foreach($packageTypes as $typeKey => $type)
                                    <option value="{{$type->id}}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                            @error('types')
                            <span class="text-theme-24 mt-2">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="w-full">
                            <select class="days form-control @error('days') border-theme-24 @enderror" name="days[]">
                                <option value="">Select Day</option>
                            </select>
                            @error('days')
                            <span class="text-theme-24 mt-2">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="w-full">
                            <select class="packages form-control @error('packages') border-theme-24 @enderror" name="packages[]">
                                <option value="">Select Package</option>
                            </select>
                            @error('packages')
                            <span class="text-theme-24 mt-2">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="w-full action">
                            <button class="btn btn-primary add-new">Add new</button>
                        </div>
                    </div>
                    <div class="w-full activity-container"></div>


                </div>

                <div class="w-full mt-4 text-right">
                    <button class="btn btn-primary ">Submit</button>
                </div>
            </form>

        </div>
    </div>


        <!-- END: Content -->

@endsection

@push('scripts')
        <script>

            $(document).on('change', '.package-type', function () {
                let package_type_id = $(this).val();
                let parent = $(this).closest('.order-item');

                $.ajax({
                    type: 'get',
                    url: `/dashboard/ajax/days/${package_type_id}`,
                    responseType: 'json',
                    success: function (data) {
                        console.log(data);
                        for (let day of data.days) {
                            parent.find('.days').append('<option value="' + day.day_id + '">' + day.day_name + '</option>')
                        }
                    },
                    error: function (err) {
                        console.log(err)
                    }
                })
            });

            $(document).on('change', '.days', function () {
                let day_id = $(this).val();
                let parent = $(this).closest('.order-item');

                $.ajax({
                    type: 'get',
                    url: `/dashboard/ajax/packages/${day_id}`,
                    responseType: 'json',
                    success: function (data) {
                        console.log(data);
                        for (let package of data.packages) {
                            parent.find('.packages').append('<option value="' + package.id + '">' + package.name + '</option>')
                        }
                    },
                    error: function (err) {
                        console.log(err)
                    }
                })
            });

            $(document).on('change', '.packages', function () {
                let package_id = $(this).val()
                let parent = $(this).closest('.order-item');

                $.ajax({
                    type: 'get',
                    url: `/dashboard/ajax/activities/${package_id}`,
                    responseType: 'json',
                    success: function (data) {
                        console.log(data);

                        if (data.success == true) {
                            parent.find('.activity-container').html(data.html)
                        }

                    },
                    error: function (err) {
                        console.log(err)
                    }
                })
            });

            $(document).on('click', '.add-new', function (e) {
                e.preventDefault();

                let item = $(this).closest('.order-item');
                //console.log(item);
                let items = $(this).closest('.order-items');
                //console.log(items);
                let newItem = item.clone().appendTo('#order-items');
                newItem.find('.package-type').val(item.find('.package-type').val());
                newItem.find('.days').val(item.find('.days').val());
                newItem.find('.packages').val(item.find('.packages').val());

                item.find('.package-type').val('');
                item.find('.days').html('<option value="">Select Day</option>');
                item.find('.packages').html('<option value="">Select Package</option>');
                item.find('.activity-container').html('');
                newItem.find('.action').html('<div class="action"><label for="" class="form-label"></label><button class="btn btn-danger" id="minusAddOn">-</button></div>')

            });

            $(document).on("click", "#minusAddOn", function (e) {
                e.preventDefault();
                $(this).closest('.order-item').remove();

            });
        </script>

@endpush
