@extends('admin.layouts.master')

@section('css')
    <link rel="stylesheet" href="{{asset('dist/css/custom-dataTable.css')}}">
@endsection

@section('content')
    <!-- BEGIN: Content -->
    <div class="content">
        <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
            <h2 class="text-lg font-medium mr-auto">
                Logs
            </h2>
        </div>

        <div class="intro-y box p-5 mt-5">
            <div class="flex flex-col sm:flex-row sm:items-end xl:items-start">
                <div class="sm:flex items-center sm:mr-4 mt-2 xl:mt-0">
                    <input id="filter-search" type="text" class="form-control sm:w-40 2xl:w-full mt-2 sm:mt-0"
                           placeholder="Search...">
                </div>
            </div>
            <div class="main-dataTable mt-5 ">
                <table class="table cust-datatable datatable no_footer" id="filter-table" width="100%">
                    <thead>
                    <tr>
                        <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">#</th>
                        <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Type</th>
                        <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Name</th>
                        <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Package name</th>
                        <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Action performed</th>
                        <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Details</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($activity_logs as $key => $activity_log)
                        <tr class="">
                            <td class="">{{ $loop->iteration }}</td>
                            <td class="">{{ $activity_log->log_type }}</td>
                            <td class="">{{ $activity_log->log_name }}</td>
                            <td class="">{{ $activity_log->description }}</td>
                            <td class="">{{ $activity_log->admin->name }}</td>
                            <td class="">
                                <a class="show flex items-center mr-3 text-theme-17"
                                   href="{{ route('admin.log.package.show',$activity_log->id) }}">
                                    <i data-feather="eye" class="w-4 h-4 mr-1"></i> Show
                                </a>

                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>


        <!-- END: Content -->
    </div>

@endsection

@push('scripts')
    <script src="//cdn.datatables.net/1.11.0/js/jquery.dataTables.min.js"></script>

    <script>
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
