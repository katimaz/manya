@extends('adminlte::page')

@section('title', '御滿屋')

@section('css')

@stop

@section('content_header')
    <h1>@lang('admin.order')</h1>
@stop

@section('content')

    @if(session('success'))
        <div class="alert alert-success alert-block" id="success-alert">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{session('success')}}</strong>
        </div>
        {{session()->forget('success')}}
    @endif

    <div class="container corners">
        <div class="row">
            <div class="col-sm-12"><a class="btn btn-primary" id="reset"><h4>重設</h4></a></div>
        </div>
    </div>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            $('#reset').click(function() {
                var r = confirm("確定是否清除資料?? 注意: 資料一被清除無法還完!!!");
                if(r == true){
                    $.ajax({
                        type: 'get',
                        url: "reset",
                        success: function(result){
                            location.reload();
                        }
                    });
                }
            });

            setTimeout(function() {
                $("#success-alert").alert('close');
            }, 2000);
        });
    </script>
@stop
