@extends('admin.layouts.master')
@section('content')

    <div class="intro-y flex items-center mt-8">
        <div class="breadcrumb mr-auto custom-breadcrumb">
            <a href="#" class="breadcrumb-link">Log</a>
            <i data-feather="chevron-right" class="breadcrumb__icon"></i>
            <a href="{{route('admin.log.visitor.index')}}" class="breadcrumb-link">Visitors</a>
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
                        <th>Visitor name</th>
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
                                    <strong>First Name:</strong> {{$activity_log->to['first_name']}}
                                </div>
                                <div class="py-2 ">
                                    <strong>Last name:</strong> {{$activity_log->to['last_name']}}
                                </div>
                                <div class="py-2 ">
                                    <strong>Email:</strong> {!! $activity_log->to['email'] !!}
                                </div>
                                <div class="py-2 ">
                                    <strong>Mobile:</strong> {!! $activity_log->to['mobile'] !!}
                                </div>
                                <div class="py-2 ">
                                    <strong>Address:</strong> {!! $activity_log->to['address'] !!}
                                </div>
                                <div class="py-2 ">
                                    <strong>Country:</strong> {!! $activity_log->to['country'] !!}
                                </div>
                                <div class="py-2 ">
                                    <strong>City:</strong> {!! $activity_log->to['city'] !!}
                                </div>
                                <div class="py-2 ">
                                    <strong>State:</strong> {!! $activity_log->to['state'] !!}
                                </div>
                                <div class="py-2 ">
                                    <strong>Zip:</strong> {!! $activity_log->to['zip'] !!}
                                </div>



                            @elseif($activity_log->log_type === 'Updated')

                                <div class="grid grid-cols-2 gap-4">
                                    <div>

                                        <strong class="my-4 mx-4 py-5 px-5 text-xl">Updated data</strong>
                                        @if( $activity_log->to['first_name'] != $activity_log->from['first_name'] )
                                            <div class="py-2 ">
                                                <strong>First Name:</strong> {{$activity_log->to['first_name']}}
                                            </div>
                                        @endif
                                        @if( $activity_log->to['last_name'] != $activity_log->from['last_name'] )
                                            <div class="py-2 ">
                                                <strong>Last name:</strong> {{$activity_log->to['last_name']}}
                                            </div>
                                        @endif
                                        @if( $activity_log->to['email'] != $activity_log->from['email'] )
                                            <div class="py-2 ">
                                                <strong>Email:</strong> {!! $activity_log->to['email'] !!}
                                            </div>
                                        @endif
                                        @if( $activity_log->to['mobile'] != $activity_log->from['mobile'] )
                                            <div class="py-2 ">
                                                <strong>Mobile:</strong> {!! $activity_log->to['mobile'] !!}
                                            </div>
                                        @endif
                                        @if( $activity_log->to['address'] != $activity_log->from['address'] )
                                            <div class="py-2 ">
                                                <strong>Address:</strong> {!! $activity_log->to['address'] !!}
                                            </div>
                                        @endif
                                        @if( $activity_log->to['country'] != $activity_log->from['country'] )
                                            <div class="py-2 ">
                                                <strong>Country:</strong> {!! $activity_log->to['country'] !!}
                                            </div>
                                        @endif
                                        @if( $activity_log->to['city'] != $activity_log->from['city'] )
                                            <div class="py-2 ">
                                                <strong>City:</strong> {!! $activity_log->to['city'] !!}
                                            </div>
                                        @endif
                                        @if( $activity_log->to['state'] != $activity_log->from['state'] )
                                            <div class="py-2 ">
                                                <strong>State:</strong> {!! $activity_log->to['state'] !!}
                                            </div>
                                        @endif
                                        @if( $activity_log->to['zip'] != $activity_log->from['zip'] )
                                            <div class="py-2 ">
                                                <strong>Zip:</strong> {!! $activity_log->to['zip'] !!}
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <strong class="my-4 mx-4 py-5 px-5 text-xl"> Old data </strong>

                                        @if( $activity_log->to['first_name'] != $activity_log->from['first_name'] )
                                            <div class="py-2 ">
                                                <strong>First Name:</strong> {{$activity_log->from['first_name']}}
                                            </div>
                                        @endif
                                        @if( $activity_log->to['last_name'] != $activity_log->from['last_name'] )
                                            <div class="py-2 ">
                                                <strong>Last name:</strong> {{$activity_log->from['last_name']}}
                                            </div>
                                        @endif
                                        @if( $activity_log->to['email'] != $activity_log->from['email'] )
                                            <div class="py-2 ">
                                                <strong>Email:</strong> {!! $activity_log->from['email'] !!}
                                            </div>
                                        @endif
                                        @if( $activity_log->to['mobile'] != $activity_log->from['mobile'] )
                                            <div class="py-2 ">
                                                <strong>Mobile:</strong> {!! $activity_log->from['mobile'] !!}
                                            </div>
                                        @endif
                                        @if( $activity_log->to['address'] != $activity_log->from['address'] )
                                            <div class="py-2 ">
                                                <strong>Address:</strong> {!! $activity_log->from['address'] !!}
                                            </div>
                                        @endif
                                        @if( $activity_log->to['country'] != $activity_log->from['country'] )
                                            <div class="py-2 ">
                                                <strong>Country:</strong> {!! $activity_log->from['country'] !!}
                                            </div>
                                        @endif
                                        @if( $activity_log->to['city'] != $activity_log->from['city'] )
                                            <div class="py-2 ">
                                                <strong>City:</strong> {!! $activity_log->from['city'] !!}
                                            </div>
                                        @endif
                                        @if( $activity_log->to['state'] != $activity_log->from['state'] )
                                            <div class="py-2 ">
                                                <strong>State:</strong> {!! $activity_log->from['state'] !!}
                                            </div>
                                        @endif
                                        @if( $activity_log->to['zip'] != $activity_log->from['zip'] )
                                            <div class="py-2 ">
                                                <strong>Zip:</strong> {!! $activity_log->from['zip'] !!}
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
