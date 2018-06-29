@extends('adminlte::page')

@section('title', '御滿屋')

@section('css')

@stop

@section('content_header')
    <h1>@lang('admin.product')</h1>
@stop

@section('content')
    {{--<div class="container">--}}
        <div class="row">

            <div class="col-md-12">
                <form class="form-horizontal" method="post" action="{{url('admin/product/create')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="name">Name:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="name" placeholder="Enter Name" name="name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="name">Description:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="name" placeholder="Enter Description" name="description">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">Type</label>
                        <div class="col-sm-8">
                            <select class="form-control" id="menu_id" name="menu_id">
                                @foreach($menus as $menu)
                                    <option value="{{$menu->id}}">{{$menu->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">Printer</label>
                        <div class="col-sm-8">
                            <select class="form-control" id="printer_id" name="printer_id">
                                @foreach($printers as $printer)
                                    <option value="{{$printer->id}}">{{$printer->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="image">Image:</label>
                        <div class="col-sm-8">
                            <input name="image" type="file" accept="image/*" onchange="readURL(this)">
                            <br/>
                            <img style="width:400" id="preview_image"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-default" >@lang('admin.add')</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
@stop

@section('js')
    <script type='text/javascript'>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#preview_image').attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@stop