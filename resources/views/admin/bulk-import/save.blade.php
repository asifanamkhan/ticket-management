@extends('admin.layouts.master')

@section('css')
    <link rel="stylesheet" href="{{asset('dist/css/custom-dataTable.css')}}">
@endsection

@section('content')
    <div class="intro-y flex items-center mt-8">
        <div class="breadcrumb mr-auto custom-breadcrumb">
            <a href="{{ route('admin.bulk-imports.index') }}" class="breadcrumb-link">Bulk imports</a>
            <i data-feather="chevron-right" class="breadcrumb__icon"></i>
            <span class="breadcrumb--active">Save</span>
        </div>
    </div>

    <div class="intro-y box mt-8">
        <div class="p-8" id="input">
            @if (session()->has('bulk-import-mapping'))
                <div class="alert alert-success-soft show flex items-center mb-2" role="alert">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                         class="feather feather-alert-triangle w-6 h-6 mr-2">
                        <path
                            d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                        <line x1="12" y1="9" x2="12" y2="13"></line>
                        <line x1="12" y1="17" x2="12.01" y2="17"></line>
                    </svg> {{ session('bulk-import-mapping') }} </div>
            @endif
            <form action="{{ route('admin.bulk-imports.store') }}" method="post">
                @csrf

                <div class="text-right mt-4">
                    <button class="btn btn-primary w-24">Save</button>
                </div>

                <div class="main-dataTable mt-5 ">
                    <table class="table cust-datatable datatable no_footer" id="filter-table" width="100%">
                        <thead>
                        <tr>
                            <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">
                                <input type="checkbox" class='checkAll' id='checkAll'>
                            </th>
                            <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Name</th>
                            <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Email</th>
                            <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Add on</th>
                            <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Gate access</th>
                            <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">
                                <a href="" class="btn btn-primary">Send all</a>
                            </th>


                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>
                                <input type='checkbox' class='delete_check'  onclick='checkcheckbox();' value='1'>
                            </td>
                            <td>Lorem ipsum</td>
                            <td>Lorem ipsum</td>
                            <td>Lorem ipsum</td>
                            <td>Lorem ipsum</td>
                            <td>
                                <a href="" class="btn btn-primary">Send</a>
                            </td>

                        </tr>
                        <tr>
                            <td>
                                <input type='checkbox' class='delete_check'  onclick='checkcheckbox();' value='2'>
                            </td>
                            <td>Lorem ipsum</td>
                            <td>Lorem ipsum</td>
                            <td>Lorem ipsum</td>
                            <td>Lorem ipsum</td>
                            <td>
                                <a href="" class="btn btn-primary">Send</a>
                            </td>


                        </tr>
                        <tr>
                            <td>
                                <input type='checkbox' class='delete_check' onclick='checkcheckbox();' value='3'>
                            </td>
                            <td>Lorem ipsum</td>
                            <td>Lorem ipsum</td>
                            <td>Lorem ipsum</td>
                            <td>Lorem ipsum</td>
                            <td>
                                <a href="" class="btn btn-primary">Send</a>
                            </td>


                        </tr>
                        <tr>
                            <td>
                                <input type='checkbox' class='delete_check' onclick='checkcheckbox();' value='4'>
                            </td>
                            <td>Lorem ipsum</td>
                            <td>Lorem ipsum</td>
                            <td>Lorem ipsum</td>
                            <td>Lorem ipsum</td>
                            <td>
                                <a href="" class="btn btn-primary">Send</a>
                            </td>


                        </tr>
                        </tbody>
                    </table>
                </div>

            </form>
        </div>
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

        $('#checkAll').click(function(){
            if($(this).is(':checked')){
                $('.delete_check').prop('checked', true);
            }else{
                $('.delete_check').prop('checked', false);
            }
        });

        function checkcheckbox(){
            // Total checkboxes
            var length = $('.delete_check').length;

            // Total checked checkboxes
            var totalchecked = 0;
            $('.delete_check').each(function(){
                if($(this).is(':checked')){
                    totalchecked+=1;
                }
            });

            // Checked unchecked checkbox
            if(totalchecked == length){
                $("#checkAll").prop('checked', true);
            }else{
                $('#checkAll').prop('checked', false);
            }
        }
    </script>
@endpush

