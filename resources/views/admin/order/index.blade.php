@extends('adminlte::page')

@section('title', '御滿屋')

@section('css')

@stop

@section('content_header')
    <h1>@lang('admin.order')</h1>
@stop

@section('content')
    <table class="table table-striped table-bordered" id="order-table">
        <thead>
        <tr>
            <th>訂號號碼</th>
            <th>桌號</th>
            <th>數量</th>
            <th>已付款</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($orders as $order)
            <tr>
                <td>{{$order->id.$order->table_id}}</td>
                <td>{{$order->table_id}}</td>
                <td>{{$order->quantity}}</td>
                @if($order->paid)
                    <td>Paid</td>
                @else
                    <td>Not Paid</td>
                @endif

                <td>
                    <a href="{{url('admin/order/detail/'.$order->id)}}" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> @lang('admin.detail')</a>
                    {{--<a href="{{url('admin/order/delete/'.$order->id)}}" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-edit"></i> Delete</a>--}}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            $('#order-table').DataTable({
                "searching":     false,
                "language": {
                    "processing":   "處理中...",
                    "loadingRecords": "載入中...",
                    "lengthMenu":   "顯示 _MENU_ 項結果",
                    "zeroRecords":  "沒有符合的結果",
                    "info":         "顯示第 _START_ 至 _END_ 項結果，共 _TOTAL_ 項",
                    "infoEmpty":    "顯示第 0 至 0 項結果，共 0 項",
                    "infoFiltered": "(從 _MAX_ 項結果中過濾)",
                    "infoPostFix":  "",
                    "search":       "搜尋:",
                    "paginate": {
                        "first":    "第一頁",
                        "previous": "上一頁",
                        "next":     "下一頁",
                        "last":     "最後一頁"
                    },
                    "aria": {
                        "sortAscending":  ": 升冪排列",
                        "sortDescending": ": 降冪排列"
                    }
                }
            });
        } );
    </script>
@stop
