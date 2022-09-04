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
            @foreach($pacakageType as $typeKey => $type)
            <div id="faq-accordion-{{$typeKey}}" class="accordion">
                <div class="accordion-item">
                    <div id="faq-accordion-content-{{$typeKey}}" class="accordion-header">
                        <button style="background-color: #F0F4F8"  class="accordion-button py-4 px-4 rounded" type="button" data-bs-toggle="collapse" data-bs-target="#faq-accordion-collapse-{{$typeKey}}" aria-expanded="false" aria-controls="faq-accordion-collapse-{{$typeKey}}">
                            {{$type['name']}}
                        </button>
                    </div>
                    <div id="faq-accordion-collapse-{{$typeKey}}" class="accordion-collapse collapse  show" aria-labelledby="faq-accordion-content-{{$typeKey}}" data-bs-parent="#faq-accordion-{{$typeKey}}">
                        @foreach($type->days() as $day => $packages)
                                <div  class="accordion-body text-white-50 dark:text-gray-600 leading-relaxed">
                                    <div id="faq-accordion-{{$day}}" class="accordion">
                                        <div class="accordion-item">
                                            <div id="faq-accordion-content-{{$day}}" class="accordion-header">
                                                <button   style="width: 96%; background-color: #F0F4F8" class="accordion-button ml-4 py-4 px-4 rounded" type="button" data-bs-toggle="collapse" data-bs-target="#faq-accordion-collapse-{{$day}}" aria-expanded="false" aria-controls="faq-accordion-collapse-{{$day}}">
                                                    {{$day}}
                                                </button>
                                            </div>
                                            <div id="faq-accordion-collapse-{{$day}}" class="accordion-collapse collapse " aria-labelledby="faq-accordion-content-{{$day}}" data-bs-parent="#faq-accordion-{{$day}}">
                                                <div class="accordion-body text-gray-700 dark:text-gray-600 leading-relaxed">
                                                    @foreach($packages as $packageKey =>$package)
                                                    <div id="faq-accordion-{{$packageKey}}" class="accordion">
                                                        <div class="accordion-item">
                                                            <div id="faq-accordion-content-{{$packageKey}}" class="accordion-header">
                                                                <button style="width: 92%; background-color: #F0F4F8" class="accordion-button ml-8 py-4 px-4 rounded" type="button" data-bs-toggle="collapse" data-bs-target="#faq-accordion-collapse-{{$packageKey}}" aria-expanded="false" aria-controls="faq-accordion-collapse-{{$packageKey}}">
                                                                    {{$package->name}}
                                                                </button>
                                                            </div>
                                                            <div id="faq-accordion-collapse-{{$package}}" class="accordion-collapse collapse " aria-labelledby="faq-accordion-content-{{$packageKey}}" data-bs-parent="#faq-accordion-{{$packageKey}}">
                                                                <div class="accordion-body text-gray-700 dark:text-gray-600 leading-relaxed">
                                                                        <div style="width: 92%; background-color: #F0F4F8" class="box lg:ml-8 p-5 mt-2">
                                                                            @foreach($package->activities as $activityKey =>$activity)
                                                                                <div class="flex">
                                                                                    <div class="p-2 m-2 m-auto">

                                                                                        @if(is_array($activity->images) && sizeof($activity->images) > 0)
                                                                                                <img src="{{ asset('uploads/activity/' . $activity->images[0]) }}" class="rounded-md " data-action="zoom" alt="Activity image" style="width: 100px; height: 100px" />
                                                                                        @endif
                                                                                        <h4 class=" text-xl">{{$activity->name}}</h4>

                                                                                    </div>
                                                                                </div>

                                                                            @endforeach
                                                                        </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                        @endforeach
                    </div>
                </div>

            </div>
            @endforeach
        </div>
    </div>
    <!-- END: Content -->
@endsection

@push('scripts')

@endpush
