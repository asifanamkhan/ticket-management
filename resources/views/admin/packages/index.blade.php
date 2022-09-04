@extends('admin.layouts.master')

@section('css')
    <link rel="stylesheet" href="{{asset('dist/css/custom-dataTable.css')}}">
@endsection

@section('content')
    <!-- BEGIN: Content -->
    <div class="content">
        <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
            <h2 class="text-lg font-medium mr-auto">
                packages
            </h2>
            <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
                <a href="{{ route('admin.packages.create') }}" class="btn btn-primary shadow-md mr-2">Add New package</a>
                <div class="dropdown ml-auto sm:ml-0">
                    <button class="dropdown-toggle btn px-2 box text-gray-700 dark:text-gray-300" aria-expanded="false">
                        <span class="w-5 h-5 flex items-center justify-center"> <i class="w-4 h-4" data-feather="plus"></i> </span>
                    </button>
                    <div class="dropdown-menu w-40">
                        <div class="dropdown-menu__content box dark:bg-dark-1 p-2">
                            <a href="{{ route('admin.activities.create') }}" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md"> <i data-feather="file-plus" class="w-4 h-4 mr-2"></i> New Add on </a>
                            <a href="{{ route('admin.days.create') }}" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md"> <i data-feather="file-plus" class="w-4 h-4 mr-2"></i> New Day </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- BEGIN: HTML Table Data -->
        <div class="intro-y box p-5 mt-5">

            <div class="flex flex-col sm:flex-row sm:items-end xl:items-start">
                <div class="sm:flex items-center sm:mr-4 mt-2 xl:mt-0">
                    <input id="filter-search" type="text" class="form-control sm:w-40 2xl:w-full mt-2 sm:mt-0" placeholder="Search...">
                </div>
            </div>

            <div class="main-dataTable mt-5">
                <table class="table cust-datatable datatable no_footer" id="filter-table" width="100%">
                    <thead>
                        <tr>
                            <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">#</th>
                            <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Name</th>
                            <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Arabic Name</th>
                            <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Day</th>
                            <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Package Type</th>
                            <!-- <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Description</th> -->
                            <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Price</th>
                            <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Status</th>
                            <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Quantity</th>
                            <!-- <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Fixed Quantity</th> -->
                            <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($packages as $key => $package)
                        <tr class="">
                            <td class="">{{ $loop->iteration }}</td>
                            <td class="">{{ $package->name }}</td>
                            <td class="">{{ $package->arabic_name }}</td>
                            <td class="">{{ $package->day->name }}</td>
                            <td class="">{{ $package->package_type->name }}</td>
                            {{--<td class="border">{!! $package->description !!}</td> --}}
                            <td class="">{{ $package->price}}</td>
                            <td class="">
                                <div class="py-1 px-2 rounded-full text-xs text-white cursor-pointer font-medium {{$package->status == true ? 'bg-theme-10': 'bg-theme-24'}}">
                                    {{ $package->status == true ? 'Active' : 'Inactive' }}
                                </div>
                            </td>
                            <td class="">{{ $package->quantity }}</td>
                            {{--<td class="border">{{ $package->fixed_quantity }}</td> --}}
                            <td class="">
                                <!-- <button class="btn btn-warning mr-1 mb-2"> <i data-feather="eye" class="w-5 h-5"></i> </button>  -->
                                <div class="flex lg:justify-center items-center">
                                    <a class="show flex items-center mr-3 text-theme-17"
                                       href="{{ route('admin.packages.show', ['package' => $package->id]) }}">
                                        <i data-feather="eye" class="w-4 h-4 mr-1"></i> Show
                                    </a>
                                    <a class="edit flex items-center mr-3 "
                                       href="{{ route('admin.packages.edit', ['package' => $package->id]) }}">
                                        <i data-feather="edit" class="w-4 h-4 mr-1"></i> Edit
                                    </a>
                                    <a style="cursor: pointer" data-toggle="modal" data-target="#delete-modal-preview" class="delete flex items-center text-theme-24" onclick="deleteItem('{{ route('admin.packages.destroy', ['package' => $package->id]) }}')">
                                        <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Delete
                                    </a>

                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!-- END: HTML Table Data -->

        <!-- BEGIN: Delete Modal -->

        @include('admin.partials.delete-modal')

        <!-- END: Delete Content -->

    </div>
    <!-- END: Content -->
@endsection

@push('scripts')
<script src="//cdn.datatables.net/1.11.0/js/jquery.dataTables.min.js"></script>

<script>
    let deleteUrl;

    function deleteItem(data) {
        deleteUrl = data;
        $('#messageBeforeDelete').html(' Do you really want to delete these Package?');
    }

    function deleteConfirm () {
        $.ajax({
            type: 'DELETE',
            url: deleteUrl,
            responseType: 'json',
            success: function (data) {
                if (data.status === 'success') {
                    $('#successMessage').html('The Package deleted successfully');
                    $("#successAfterDelete")[0].click();
                } else {
                    $('#errorMessage').html(data.data);
                    $("#errorAfterDelete")[0].click();
                }

            }
        });
    }

    function reloadAfterDelete(){
        window.location.reload();
    }

    //datatable

    $(document).ready(function () {
        var dataTable = $('#filter-table').DataTable({
            "pageLength": 15,
            "dom": '<"top">ct<"top"p><"clear">',
            responsive: true

        });

        $('#filter-search').on('keyup', function () {
            dataTable.search(this.value).draw();
        });

        $('#intro').addClass('intro-x');
    });
</script>
@endpush
