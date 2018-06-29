@extends('adminlte::page')

@section('title', '御滿屋')

@section('css')
<style>
    .a-button{
        height: 100px;
    }
    .corners {
        border-radius: 25px;
        border: 2px solid black;
        padding: 20px;
    }
</style>
@stop

@section('content_header')
    <h1>管理</h1>
@stop

@section('content')
    <div class="container corners">
        <div class="row">
            <div class="col-sm-4"><a class="btn btn-primary a-button" href="{{route('getPrint',['count' => '1'])}}"><h1>影印密碼1張</h1></a></div>
            <div class="col-sm-4"><a class="btn btn-success a-button" href="{{route('getPrint',['count' => '10'])}}"><h1>影印密碼10張</h1></a></div>
            <div class="col-sm-4"><a class="btn btn-danger a-button" href="{{route('getPrint',['count' => '20'])}}"><h1>影印密碼20張</h1></a></div>
        </div>
    </div>

    <div class="container corners" style="margin-top: 50px;">
        <div class="row">
            <div class="col-sm-4"><a id="1" class="btn btn-info a-button paidOrder" style="width: 133.74px;color:black" ><h1>桌號1</h1></a></div>
            <div class="col-sm-4"><a id="2" class="btn btn-info a-button paidOrder" style="width: 133.74px;color:black"><h1>桌號2</h1></a></div>
            <div class="col-sm-4"><a id="3" class="btn btn-info a-button paidOrder" style="width: 133.74px;color:black"><h1>桌號3</h1></a></div>
        </div>
        <br/>
        <div class="row">
            <div class="col-sm-4"><a id="4" class="btn btn-info a-button paidOrder" style="width: 133.74px;color:black"><h1>桌號4</h1></a></div>
            <div class="col-sm-4"><a id="5" class="btn btn-info a-button paidOrder" style="width: 133.74px;color:black"><h1>桌號5</h1></a></div>
            <div class="col-sm-4"><a id="6" class="btn btn-info a-button paidOrder" style="width: 133.74px;color:black"><h1>桌號6</h1></a></div>
        </div>
        <br/>
        <div class="row">
            <div class="col-sm-4"><a id="7" class="btn btn-info a-button paidOrder" style="width: 133.74px;color:black"><h1>桌號7</h1></a></div>
            <div class="col-sm-4"><a id="8" class="btn btn-info a-button paidOrder" style="width: 133.74px;color:black"><h1>桌號8</h1></a></div>
            <div class="col-sm-4"><a id="9" class="btn btn-info a-button paidOrder" style="width: 133.74px;color:black"><h1>桌號9</h1></a></div>
        </div>
        <br/>
        <div class="row">
            <div class="col-sm-4"><a id="10" class="btn btn-info a-button paidOrder" style="color:black"><h1>桌號10</h1></a></div>
            <div class="col-sm-4"><a id="11" class="btn btn-info a-button paidOrder" style="color:black"><h1>桌號11</h1></a></div>
            <div class="col-sm-4"><a id="12" class="btn btn-info a-button paidOrder" style="color:black"><h1>桌號12</h1></a></div>
        </div>
        <br/>

    </div>
@stop

@section('js')
<script>
    $('.paidOrder').click(function () {
        var table_id = $(this).attr("id");
        $.ajax({
            type: 'post',
            data: {table_id : table_id, _token: '{{csrf_token()}}'},
            url: '/admin/order/paidOrder',
            success: function(data) {
                if(data =="SUCCESS"){
                    alert("桌號"+table_id+"已結帳");
                }
            },
        });
    })
</script>
@stop
