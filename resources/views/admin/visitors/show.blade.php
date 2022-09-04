@extends('admin.layouts.master')
@section('content')

    <div class="intro-y flex items-center mt-8">
        <div class="breadcrumb mr-auto custom-breadcrumb">
            <a href="{{ route('admin.visitors.index') }}" class="breadcrumb-link">Visitor</a>
            <i data-feather="chevron-right" class="breadcrumb__icon"></i>
            <span class="breadcrumb--active">Show - {{ $visitor->first_name }} {{ $visitor->last_name }}</span>
        </div>
    </div>

    <div class="content">
        <!-- BEGIN: Wizard layout -->
        <div class="intro-y box py-10 px-10 sm:py-20 mt-5">

                <table class="table ">
                    <tbody>
                    <tr class="border-b dark:border-dark-5 hover:bg-gray-200">
                        <th width="20%">First Name:</th>
                        <td class="">{{$visitor->first_name ?? '-'}}</td>
                    </tr>
                    <tr class="border-b dark:border-dark-5 hover:bg-gray-200">
                        <th width="20%">Last Name:</th>
                        <td class="">{{$visitor->last_name ?? '-'}}</td>
                    </tr>
                    <tr class="border-b dark:border-dark-5 hover:bg-gray-200">
                        <th class="">Email:</th>
                        <td class="">{{$visitor->email ?? '-'}}</td>
                    </tr>
                    <tr class="border-b dark:border-dark-5 hover:bg-gray-200">
                        <th>Mobile:</th>
                        <td>{{$visitor->mobile ?? '-'}}</td>
                    </tr>

                    <tr class="border-b dark:border-dark-5 hover:bg-gray-200">
                        <th>Country:</th>
                        <td>{{$visitor->country->name ?? '-'}}</td>
                    </tr>

                    <tr class="border-b dark:border-dark-5 hover:bg-gray-200">
                        <th>City:</th>
                        <td>{{$visitor->city ?? '-'}}</td>
                    </tr>

                    <tr class="border-b dark:border-dark-5 hover:bg-gray-200">
                        <th>State:</th>
                        <td>{{$visitor->state ?? '-'}}</td>
                    </tr>

                    <tr class="border-b dark:border-dark-5 hover:bg-gray-200">
                        <th>Zip:</th>
                        <td>{{$visitor->zip ?? '-'}}</td>
                    </tr>

                    <tr class="border-b dark:border-dark-5 hover:bg-gray-200">
                        <th>Provider:</th>
                        <td>{{$visitor->provider ?? '-'}}</td>
                    </tr>

                    <tr class="border-b dark:border-dark-5 hover:bg-gray-200">
                        <th width="20%">Address:</th>
                        <td>{{ $visitor->address ?? '-' }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

    <!-- END: Wizard layout -->

@endsection
