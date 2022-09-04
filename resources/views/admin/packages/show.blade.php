@extends('admin.layouts.master')
@section('content')

    <div class="intro-y flex items-center mt-8">
        <div class="breadcrumb mr-auto custom-breadcrumb">
            <a href="{{ route('admin.packages.index') }}" class="breadcrumb-link">Package</a>
            <i data-feather="chevron-right" class="breadcrumb__icon"></i>
            <span class="breadcrumb--active">Show - {{ $package->name }}</span>
        </div>
    </div>

    <div class="content" >

        <div class="intro-y py-10 sm:py-20" >
            <div class=" box intro-x" style="overflow:scroll">
                <table class="table ">
                    <tbody>
                    <tr class="border-b dark:border-dark-5 hover:bg-gray-200">
                        <th width="15%">Name:</th>
                        <td width="35%">{{$package->name}}</td>

                        <th class="15%">Arabic Name:</th>
                        <td class="35%">{{$package->arabic_name}}</td>
                    </tr>
                    <tr class="border-b dark:border-dark-5 hover:bg-gray-200">
                        <th class="">Day:</th>
                        <td class="">{{$package->day->name}}</td>

                        <th>Price:</th>
                        <td>{{$package->price}}</td>

                    </tr>

                    <tr class="border-b dark:border-dark-5 hover:bg-gray-200">
                        <th class="">Package Type:</th>
                        <td class="">{{$package->package_type->name}}</td>

                        <th>Gate access:</th>
                        <td>{{$package->gate_access}}</td>

                    </tr>

                    <tr class="border-b dark:border-dark-5 hover:bg-gray-200">
                        <th class="">Quantity: </th>
                        <td class="">{{$package->quantity}}</td>

                        <th>Fixed Quantity: </th>
                        <td>{{$package->fixed_quantity}}</td>

                    </tr>
                    <tr class="border-b dark:border-dark-5 hover:bg-gray-200">

                        <th class="">Add ons:</th>
                        <td class="">
                            <div class="grid grid-cols-3 gap-2">
                                @foreach($package->activities as $activity)
                                    <div class="py-1 px-1 rounded-full text-xs text-center text-white font-medium bg-theme-23 ml-0.5">
                                        <a href="{{route('admin.activities.show',$activity->id)}}">{{$activity->name}}</a>
                                    </div>
                                @endforeach
                            </div>
                        </td>

                        <th>Status:</th>
                        <td>
                            <div class="w-16 py-1 px-2 rounded-full text-xs text-center text-white font-medium {{$package->status == true ? 'bg-theme-10': 'bg-theme-24'}}">
                                {{ $package->status == true ? 'Active' : 'Inactive' }}
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <table class="table " >
                    <tbody>
                        <tr class="border-b dark:border-dark-5 hover:bg-gray-200">
                            <th width="15%">Description:</th>
                            <td>{!! $package->description !!}</td>
                        </tr>
                        <tr class="border-b dark:border-dark-5 hover:bg-gray-200">
                            <th>Arabic description:</th>
                            <td>{!! $package->arabic_description !!}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


@endsection
