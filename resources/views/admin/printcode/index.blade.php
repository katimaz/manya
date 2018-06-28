@extends('adminlte::page')

@section('title', 'QuickOrder')

@section('css')

@stop

@section('content_header')
    <h1>密碼</h1>
@stop

@section('content')
    <table class="table table-striped table-bordered" id="order-table">
        <thead>
        <tr>
            <th>密碼</th>
            <th>使用桌號</th>
            <th>有效時間</th>
        </tr>
        </thead>
        <tbody>
        @foreach($printCodes as $printCode)
            <tr>
                <td>{{$printCode->code}}</td>
                <td>{{$printCode->table_id}}</td>
                <td>{{$printCode->used_time}}</td>
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
