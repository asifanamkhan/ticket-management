@extends('admin.layouts.master')
@section('content')

    <div class="intro-y flex items-center mt-8">
        <div class="breadcrumb mr-auto custom-breadcrumb">
            <a href="{{ route('admin.activities.index') }}" class="breadcrumb-link">Add ons</a>
            <i data-feather="chevron-right" class="breadcrumb__icon"></i>
            <span class="breadcrumb--active">Show - {{ $activity->name }}</span>
        </div>
    </div>

    <div class="content">
        <!-- BEGIN: Wizard layout -->
        <div class="intro-y box py-10 sm:py-20 mt-5">
            <div class="flex lg:justify-center">
                @if (is_array($activity->images) && count($activity->images) > 0)
                    @foreach($activity->images as $k => $image)
                        <div class="w-20 h-16 image-fit zoom-in @if($k > 0) ml-1 @endif">
                            <img src="{{ asset('uploads/activity/' . $image) }}" alt="Image activity" class="rounded-md " data-action="zoom">
                        </div>
                    @endforeach
                @endif
            </div>
            <div class="px-5 sm:px-20 mt-10 pt-10 border-t border-gray-200 dark:border-dark-5" style="overflow:scroll">
                <div class="intro-x">
                    <table class="table " >
                        <tbody >
                            <tr class="border-b dark:border-dark-5 hover:bg-gray-200">
                                <th width="20%">Name: </th>
                                <td class="">{{$activity->name}}</td>
                            </tr>
                            <tr class="border-b dark:border-dark-5 hover:bg-gray-200">
                                <th class="">Arabic Name: </th>
                                <td class="">{{$activity->arabic_name}}</td>
                            </tr >
                            <tr class="border-b dark:border-dark-5 hover:bg-gray-200">
                                <th>Price: </th>
                                <td>{{$activity->price}}</td>
                            </tr>
                            <tr class="border-b dark:border-dark-5 hover:bg-gray-200">
                                <th>Highlight: </th>
                                <td>
                                    <div class="w-12 text-center py-1 px-2 rounded-full text-xs text-white cursor-pointer font-medium {{$activity->highlight == true ? 'bg-theme-10': 'bg-theme-24'}}">
                                        {{ $activity->highlight == true ? 'Yes' : 'No' }}
                                    </div>
                                </td>
                            </tr>
                            <tr class="border-b dark:border-dark-5 hover:bg-gray-200">
                                <th>Status: </th>
                                <td>
                                    <div class="w-16 py-1 px-2 rounded-full text-xs text-center text-white font-medium {{$activity->status == true ? 'bg-theme-10': 'bg-theme-24'}}">
                                        {{ $activity->status == true ? 'Active' : 'Inactive' }}
                                    </div>
                                </td>
                            </tr>
                            <tr class="border-b dark:border-dark-5 hover:bg-gray-200">
                                <th width="20%">Description:</th>
                                <td>{!! $activity->description !!}</td>
                            </tr>
                            <tr class="border-b dark:border-dark-5 hover:bg-gray-200">
                                <th>Arabic description:</th>
                                <td>{!! $activity->arabic_description !!}</td>
                            </tr>
                        </tbody>
                    </table>
                    {{--<table class="table " style="background-color: white;  overflow:scroll">--}}
                        {{--<tbody>--}}
                        {{----}}
                        {{--</tbody>--}}
                    {{--</table>--}}
                </div>
            </div>
        </div>
        <!-- END: Wizard layout -->
    </div>
@endsection
