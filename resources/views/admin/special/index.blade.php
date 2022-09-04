@extends('admin.layouts.master')
@section('css')
    <link rel="stylesheet" href="{{asset('dist/css/custom-dataTable.css')}}">
@endsection
@section('content')
    <!-- BEGIN: Content -->
    <div class="content">
        <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
            <h2 class="text-lg font-medium mr-auto">
                Special Users
            </h2>
            <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
                <a href="{{ route('admin.specials.create') }}" class="btn btn-primary shadow-md mr-2">Add New Special User</a>
            </div>
        </div>
        <!-- BEGIN: HTML Table Data -->
        <div class="intro-y box p-5 mt-5">
            <div class="flex flex-col sm:flex-row sm:items-end xl:items-start">
                <div class="sm:flex items-center sm:mr-4 mt-2 xl:mt-0">
                    <input id="filter-search" type="text" class="form-control sm:w-40 2xl:w-full mt-2 sm:mt-0" placeholder="Search...">
                </div>
            </div>
            <div class="main-dataTable mt-5 ">
                <table class="table cust-datatable datatable no_footer" id="filter-table" width="100%">
                    <thead>
                    <tr>
                        <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">#</th>
                        <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Name</th>
                        <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Email</th>
                        <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Mobile</th>
                        <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Status</th>
                        <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($specialUsers as $key => $specialUser)
                        <tr class="">
                            <td class="">{{ $loop->iteration }}</td>
                            <td class="">{{$specialUser->full_name}}</td>
                            <td class="">{{ $specialUser->email }}</td>
                            <td class="">{{ $specialUser->mobile}}</td>
                            <td class="">
                                {{ $specialUser->status === 1 ? 'Accepted': 'Pending'}}
                            </td>

                            <td>
                                <div class="flex lg:justify-center items-center">
                                    <a class="show flex items-center mr-3 text-theme-17"
                                       href="{{ route('admin.specials.show', $specialUser->id) }}">
                                        <i data-feather="eye" class="w-4 h-4 mr-1"></i> Show
                                    </a>
                                    <a class="edit flex items-center mr-3 "
                                       href="{{ route('admin.specials.edit', $specialUser->id) }}">
                                        <i data-feather="edit" class="w-4 h-4 mr-1"></i> Edit
                                    </a>
                                    <a class="edit flex items-center mr-3 text-theme-21"
                                       href="{{ route('admin.special.password.change', $specialUser->id) }}">
                                        <i data-feather="edit" class="w-4 h-4 mr-1"></i> Change pass
                                    </a>
                                    <a style="cursor: pointer" data-toggle="modal" data-target="#delete-modal-preview" class="delete flex items-center text-theme-24" onclick="deleteItem('{{ route('admin.specials.destroy',$specialUser->id) }}')">
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
            $('#messageBeforeDelete').html(' Do you really want to delete these Special Users?');
        }

        function deleteConfirm () {
            $.ajax({
                type: 'DELETE',
                url: deleteUrl,
                responseType: 'json',
                success: function (data) {
                    if (data.status === 'success') {
                        $('#successMessage').html('The Special User deleted successfully');
                        $("#successAfterDelete")[0].click();
                    } else {
                        console.log(data);
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
                "dom": '<"top">ct<"top"p><"clear">'

            });

            $('#filter-search').on('keyup', function () {
                dataTable.search(this.value).draw();
            })
        });
    </script>
@endpush
