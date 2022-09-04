@extends('visitors.layout.master')
@section('css')
    <link rel="stylesheet" href="{{asset('dist/css/custom-dataTable.css')}}">
@endsection
@section('content')
    <div class="flex items-center p-5 border-b border-gray-200 dark:border-dark-5">
        <h2 class="font-medium text-base mr-auto">
            Purchases
        </h2>
    </div>
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
                    <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Order Id</th>
                    <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Status</th>
                    <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Packages</th>
                    <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($orders as $key => $order)
                    <tr class="intro-x">
                        <td class="">{{ $loop->iteration }}</td>
                        <td class="">{{ $order->cart_id }}</td>
                        <td class="">{{ $order->status }}</td>
                        <td class="">
                            @foreach($order->orderDetails as $orderDetail)

                                    @if($orderDetail->price != 0)
                                        <span class="ml-0.5">
                                            {{ $orderDetail->name }}
                                            @if(!$loop->last), @endif
                                        </span>
                                    @endif

                            @endforeach
                        </td>


                        <td>
                            <div class="flex lg:justify-center items-center">
                                <a class="show flex items-center mr-3 text-theme-17"
                                   href="{{ route('visitor.orders.show', $order->id) }}">
                                    <i data-feather="eye" class="w-4 h-4 mr-1"></i> Details
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection

@section('script')
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
@endsection
