@extends('adminlte::page')

@section('title', '御滿屋')

@section('css')

@stop

@section('content_header')
    <h1>Promotion</h1>
@stop

@section('content')
    <a style="margin-bottom: 10px" href="{{url('admin/promotion/add')}}" class="btn btn-xs btn-success"><i class="glyphicon glyphicon glyphicon-plus"></i> @lang('admin.add')</a>
    <br/>
    <table class="table table-striped table-bordered" id="product-table">
        <thead>
        <tr>
            <th>Name</th>
            <th>Type</th>
            <th>Description</th>
            <th>Sold Out</th>
            <th>Image</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($promotions as $promotion)
            <tr>
                <td>{{$promotion->products_name}}</td>
                <td>{{$promotion->name}}</td>
                <td>{{$promotion->description}}</td>
                <td><img style="height: 80px;width: 80px;" src="{{url('/').'/public/'.$promotion->image_url}}"/></td>
                <td>
                    <a href="{{url('admin/product/modify/'.$promotion->products_id)}}" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> @lang('admin.edit')</a>
                    <a href="{{url('admin/product/delete/'.$promotion->products_id)}}" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-edit"></i> @lang('admin.delete')</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            $('#product-table').DataTable({
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
