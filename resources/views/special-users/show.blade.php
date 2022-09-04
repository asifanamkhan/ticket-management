@extends('special-users.layout.master')
@section('content')
    <div class="flex items-center p-5 border-b border-gray-200 dark:border-dark-5">
        <h2 class="font-medium text-base mr-auto">
            Show Personal Information
        </h2>
        @if($specialUser->status == 0)
            <div>
                <a class="flex items-center mt-5  btn btn-primary" href="{{route('special-user.user.edit', Auth::guard('specialUser')->user()->id)}}">  Edit Information </a>
            </div>
        @endif
    </div>
    <div class="p-5">



            <div class="intro-y box ">
                <div class="intro-x">
                    <table class="table " >
                        <tbody >
                        <tr class="border-b dark:border-dark-5 hover:bg-gray-200">
                            <th>Status: </th>
                            <td>
                                <div class="w-16 py-1 px-2 rounded-full text-xs text-center text-white font-medium {{$specialUser->status == 1 ? 'bg-theme-10': 'bg-theme-24'}}">
                                    {{ $specialUser->status == 1 ? 'Accepted' : 'Pending' }}
                                </div>
                            </td>
                        </tr>
                        <tr class="border-b dark:border-dark-5 hover:bg-gray-200">
                            <th width="20%">Name: </th>
                            <td class="">{{$specialUser->full_name}}</td>
                        </tr>
                        <tr class="border-b dark:border-dark-5 hover:bg-gray-200">
                            <th class="">Company Name: </th>
                            <td class="">{{$specialUser->company_name}}</td>
                        </tr >
                        <tr class="border-b dark:border-dark-5 hover:bg-gray-200">
                            <th class="">Email: </th>
                            <td class="">{{$specialUser->email}}</td>
                        </tr >
                        <tr class="border-b dark:border-dark-5 hover:bg-gray-200">
                            <th class="">Mobile: </th>
                            <td class="">{{$specialUser->mobile}}</td>
                        </tr >

                        <tr class="border-b dark:border-dark-5 hover:bg-gray-200">
                            <th class="">Country: </th>
                            <td class="">{{$specialUser->country->name}}</td>
                        </tr >

                        <tr class="border-b dark:border-dark-5 hover:bg-gray-200">
                            <th class="">City: </th>
                            <td class="">{{$specialUser->city}}</td>
                        </tr >

                        <tr class="border-b dark:border-dark-5 hover:bg-gray-200">
                            <th>Type: </th>
                            <td>
                                @if($specialUser->type == 'media')
                                    Media
                                @elseif($specialUser->type == 'sponsor')
                                    Sponsor
                                @else
                                    Usher
                                @endif
                            </td>
                        </tr>


                        <tr class="border-b dark:border-dark-5 hover:bg-gray-200">
                            <th width="20%">Address:</th>
                            <td>{{ $specialUser->address }}</td>
                        </tr>

                        <tr class="border-b dark:border-dark-5 hover:bg-gray-200">
                            <th width="20%">Download Document:</th>
                            <td>
                                @if($specialUser->document)
                                    <a class="btn btn-success" href="{{asset('special-users/document/'.$specialUser->document)}}">
                                        Click here
                                    </a>
                                @else
                                    No document attached
                                @endif
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
    </div>

    </div>
@endsection
