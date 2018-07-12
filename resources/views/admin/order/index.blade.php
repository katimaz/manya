@extends('adminlte::page')

@section('title', '御滿屋')

@section('css')

@stop

@section('content_header')
    <h1>@lang('admin.order')</h1>
@stop

@section('content')
    <div class="container corners">
        <div class="row">
            <div class="col-sm-4">
                <input type="text" style="height: 53px;font-size: 30px;" class="form-control" id="table_id" placeholder="桌號" name="table_id">
            </div>
            <div class="col-sm-4">
                <input type="text" style="height: 53px;font-size: 30px;" class="form-control" id="people" placeholder="人數" name="people">
            </div>
            <div class="col-sm-4"><button class="btn btn-primary" id="print"><h4>影印密碼</h4></button></div>
        </div>
    </div>
    <br/>
    <table class="table table-striped table-bordered" id="order-table">
        <thead>
        <tr>
            <th>@lang('admin.order.createdtime')</th>
            <th>@lang('admin.order.tableid')</th>
            <th>@lang('admin.order.quantity')</th>
            <th>@lang('admin.order.paidstatus')</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($orders as $order)
            <tr>
                <td>{{$order->created_at}}</td>
                <td>{{$order->table_id}}</td>
                <td>{{$order->quantity}}</td>
                @if($order->paid)
                    <td>@lang('admin.order.paid')</td>
                @else
                    <td>@lang('admin.order.unpaid')</td>
                @endif

                <td>
                    <a href="{{url('admin/order/detail/'.$order->id)}}" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> @lang('admin.detail')</a>
                    <a href="#" id="{{$order->id}}" class="btn btn-xs btn-info payment"><i class="glyphicon glyphicon-edit"></i> 付款</a>
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

            $('.payment').click(function () {
                var id = this.id;
                paid = 1;
                $.ajax({
                    type: 'post',
                    data: {paid : paid, _token: '{{csrf_token()}}'},
                    url: '/admin/order/detail/'+id,
                    success: function(data) {
                        location.reload();
                    },
                });
            })



            $('#print').click(function () {
                var table_id = $( "#table_id" ).val();
                var poeple = $( "#people" ).val();
                if(table_id && poeple){
                    $('#print').prop('disabled', true);
                    $.ajax({
                        data: {table_id : table_id,people : people},
                        url: '/printKey',
                        success: function(data) {
                            console.log(data);
                            if(data =="SUCCESS"){
                                location.reload();
                            }
                        },
                    });
                }else{
                    alert("請輸入桌號/人數");
                }
            });
        } );
    </script>
@stop
