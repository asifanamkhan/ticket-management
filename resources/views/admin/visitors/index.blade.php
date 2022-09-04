@extends('admin.layouts.master')
@section('css')
    <link rel="stylesheet" href="{{asset('dist/css/custom-dataTable.css')}}">
@endsection
@section('content')
    <!-- BEGIN: Content -->
    <div class="content">
        <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
            <h2 class="text-lg font-medium mr-auto">
                Visitors
            </h2>
            <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
                <a href="{{ route('admin.visitors.create') }}" class="btn btn-primary shadow-md mr-2">Add New visitor</a>
            </div>
        </div>
        <!-- BEGIN: HTML Table Data -->
        <div class="intro-y box p-5 mt-5">
            @if (session()->has('visitor-email-send'))
                <div class="alert alert-success-soft show flex items-center mb-2" role="alert">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-triangle w-6 h-6 mr-2">
                        <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                        <line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line>
                    </svg> {{ session('visitor-email-send') }} </div>
            @endif
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
                        <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">First name</th>
                        <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Last name</th>
                        <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Email</th>
                        <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Mobile</th>
                        <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($visitors as $key => $visitor)
                        <tr class="">
                            <td class="">{{ $loop->iteration }}</td>
                            <td class="">{{$visitor->first_name}}</td>
                            <td class="">{{$visitor->last_name}}</td>
                            <td class="">{{ $visitor->email }}</td>
                            <td class="">{{ $visitor->mobile}}</td>

                            <td>
                                <div class="flex lg:justify-center items-center">
                                    <a class="show flex items-center mr-3 text-theme-17"
                                       href="{{ route('admin.visitors.show', ['visitor' => $visitor->id]) }}">
                                        <i data-feather="eye" class="w-4 h-4 mr-1"></i> Show
                                    </a>
                                    <a class="edit flex items-center mr-3 "
                                       href="{{ route('admin.visitors.edit', ['visitor' => $visitor->id]) }}">
                                        <i data-feather="edit" class="w-4 h-4 mr-1"></i> Edit
                                    </a>

                                    @if($visitor->provider == '' && $visitor->provider_id == '')
                                    <a class="edit flex items-center mr-3 text-theme-21"
                                       href="{{ route('admin.visitors.password.change', $visitor->id) }}">
                                        <i data-feather="edit" class="w-4 h-4 mr-1"></i> Change pass
                                    </a>
                                    @endif
                                    <a style="cursor: pointer" data-toggle="modal" data-target="#delete-modal-preview" class="mr-3 delete flex items-center text-theme-24" onclick="deleteItem('{{ route('admin.visitors.destroy', ['visitor' => $visitor->id]) }}')">
                                        <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Delete
                                    </a>

                                    <a class="edit flex items-center  "
                                       href="{{ route('admin.visitors.emailTicket', $visitor->id) }}">
                                        <i data-feather="mail" class="w-4 h-4 mr-1"></i> Email
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
            $('#messageBeforeDelete').html(' Do you really want to delete these Visitors?');
        }

        function deleteConfirm () {
            $.ajax({
                type: 'DELETE',
                url: deleteUrl,
                responseType: 'json',
                success: function (data) {
                    if (data.status === 'success') {
                        $('#successMessage').html('The visitor deleted successfully');
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
