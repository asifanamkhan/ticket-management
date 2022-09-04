@extends('admin.layouts.master')
@section('content')

    <div class="intro-y flex items-center mt-8">
        <div class="breadcrumb mr-auto custom-breadcrumb">
            <a href="#" class="breadcrumb-link">Log</a>
            <i data-feather="chevron-right" class="breadcrumb__icon"></i>
            <a href="{{route('admin.log.add-on.index')}}" class="breadcrumb-link">Add ons</a>
            <i data-feather="chevron-right" class="breadcrumb__icon"></i>
            <span class="breadcrumb--active">Show - {{ $activity_log->description }}</span>
        </div>
    </div>

    <div class="content">
        <!-- BEGIN: Wizard layout -->
        <div class="intro-y box py-10 sm:py-20 mt-5">
            <div class="intro-x">
                <table class="table ">
                    <tbody>
                    <tr class="border-b dark:border-dark-5 hover:bg-gray-200">
                        <th width="20%">Type:</th>
                        <td class="">{{$activity_log->log_type}}</td>
                    </tr>
                    <tr class="border-b dark:border-dark-5 hover:bg-gray-200">
                        <th class="">Name:</th>
                        <td class="">{{$activity_log->log_name}}</td>
                    </tr>
                    <tr class="border-b dark:border-dark-5 hover:bg-gray-200">
                        <th>Add on name</th>
                        <td class="">{{ $activity_log->description }}</td>
                    </tr>

                    <tr class="border-b dark:border-dark-5 hover:bg-gray-200">
                        <th>Action performed</th>
                        <td class="">{{ $activity_log->admin->name }}</td>
                    </tr>

                    <tr class="border-b dark:border-dark-5 hover:bg-gray-200">
                        <th>Details</th>
                        <td class="">
                            @if($activity_log->log_type === 'Created')

                                <div class="py-2 ">
                                    <strong>Name:</strong> {{$activity_log->to['name']}}
                                </div>
                                <div class="py-2 ">
                                    <strong>Arabic name:</strong> {{$activity_log->to['arabic_name']}}
                                </div>
                                <div class="py-2 ">
                                    <strong>Price:</strong> {!! $activity_log->to['price'] !!}
                                </div>
                                <div class="py-2 ">
                                    <strong>Highlight:</strong> {{$activity_log->to['highlight'] == 1 ? 'on': 'off'}}
                                </div>
                                <div class="py-2 ">
                                    <strong>Concert:</strong> {{$activity_log->to['concert'] == 1 ? 'on': 'off'}}
                                </div>
                                <div class="py-2 ">
                                    <strong>Status:</strong> {{$activity_log->to['status'] == 1 ? 'on': 'off'}}
                                </div>
                                <div class="py-2 ">
                                    <strong>Description:</strong> {!! $activity_log->to['description'] ?? '' !!}
                                </div>
                                <div class="py-2 ">
                                    <strong>Arabic
                                        description:</strong> {!! $activity_log->to['arabic_description'] ?? '' !!}
                                </div>

                            @elseif($activity_log->log_type === 'Updated')

                                <div class="grid grid-cols-2 gap-4">
                                    <div>

                                        <strong class="my-4 mx-4 py-5 px-5 text-xl">Updated data</strong>

                                        @if( $activity_log->to['name'] != $activity_log->from['name'] )

                                            <div class="py-2 ">
                                                <strong>Name:</strong> {{$activity_log->to['name']}}
                                            </div>
                                        @endif
                                        @if( $activity_log->to['arabic_name'] != $activity_log->from['arabic_name'] )
                                            <div class="py-2 ">
                                                <strong>Arabic name:</strong> {{$activity_log->to['arabic_name']}}
                                            </div>
                                        @endif

                                        @if( $activity_log->to['price'] != $activity_log->from['price'] )
                                            <div class="py-2 ">
                                                <strong>Price:</strong> {!! $activity_log->to['price'] !!}
                                            </div>
                                        @endif
                                        @if( $activity_log->to['highlight'] != $activity_log->from['highlight'] )
                                            <div class="py-2 ">
                                                <strong>Highlight:</strong> {{$activity_log->to['highlight'] == 1 ? 'on': 'off'}}
                                            </div>
                                        @endif
                                        @if( $activity_log->to['concert'] != $activity_log->from['concert'] )
                                            <div class="py-2 ">
                                                <strong>Concert:</strong> {{$activity_log->to['concert'] == 1 ? 'on': 'off'}}
                                            </div>
                                        @endif
                                        @if( $activity_log->to['status'] != $activity_log->from['status'] )
                                            <div class="py-2 ">
                                                <strong>Status:</strong> {{$activity_log->to['status'] == 1 ? 'on': 'off'}}
                                            </div>
                                        @endif
                                        @if( $activity_log->to['description'] != $activity_log->from['description'] )
                                            <div class="py-2 ">
                                                <strong>Description:</strong> {!! $activity_log->to['description'] ?? '' !!}
                                            </div>
                                        @endif
                                        @if( $activity_log->to['arabic_description'] != $activity_log->from['arabic_description'] )
                                            <div class="py-2 ">
                                                <strong>Arabic description:</strong> {!! $activity_log->to['arabic_description'] ?? '' !!}
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <strong class="my-4 mx-4 py-5 px-5 text-xl"> Old data </strong>

                                        @if( $activity_log->to['name'] != $activity_log->from['name'] )

                                            <div class="py-2 ">
                                                <strong>Name:</strong> {{$activity_log->from['name']}}
                                            </div>
                                        @endif
                                        @if( $activity_log->to['arabic_name'] != $activity_log->from['arabic_name'] )
                                            <div class="py-2 ">
                                                <strong>Arabic name:</strong> {{$activity_log->from['arabic_name']}}
                                            </div>
                                        @endif

                                        @if( $activity_log->to['price'] != $activity_log->from['price'] )
                                            <div class="py-2 ">
                                                <strong>Price:</strong> {!! $activity_log->from['price'] !!}
                                            </div>
                                        @endif
                                        @if( $activity_log->to['highlight'] != $activity_log->from['highlight'] )
                                            <div class="py-2 ">
                                                <strong>Highlight:</strong> {{$activity_log->from['highlight'] == 1 ? 'on': 'off'}}
                                            </div>
                                        @endif
                                        @if( $activity_log->to['concert'] != $activity_log->from['concert'] )
                                            <div class="py-2 ">
                                                <strong>Concert:</strong> {{$activity_log->from['concert'] == 1 ? 'on': 'off'}}
                                            </div>
                                        @endif
                                        @if( $activity_log->to['status'] != $activity_log->from['status'] )
                                            <div class="py-2 ">
                                                <strong>Status:</strong> {{$activity_log->from['status'] == 1 ? 'on': 'off'}}
                                            </div>
                                        @endif
                                        @if( $activity_log->to['description'] != $activity_log->from['description'] )
                                            <div class="py-2 ">
                                                <strong>Description:</strong> {!! $activity_log->from['description'] ?? '' !!}
                                            </div>
                                        @endif
                                        @if( $activity_log->to['arabic_description'] != $activity_log->from['arabic_description'] )
                                            <div class="py-2 ">
                                                <strong>Arabic description:</strong> {!! $activity_log->from['arabic_description'] ?? '' !!}
                                            </div>
                                        @endif
                                    </div>
                                </div>

                            @endif
                        </td>
                    </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- END: Wizard layout -->

@endsection
