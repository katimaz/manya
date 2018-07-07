@extends('layouts.main')

@section('style')
    {{--<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" />--}}
    {{--<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">--}}
    <style>
        .accordion {
            background-color: #eee;
            color: #444;
            cursor: pointer;
            padding: 18px;
            width: 100%;
            border: none;
            text-align: left;
            outline: none;
            font-size: 15px;
            transition: 0.4s;
        }

        .active, .accordion:hover {
            background-color: #ccc;
        }

        .accordion:after {
            content: '\002B';
            color: #777;
            font-weight: bold;
            float: right;
            margin-left: 5px;
        }

        .active:after {
            content: "\2212";
        }

        .panel {
            padding: 0 18px;
            background-color: white;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.2s ease-out;
        }
    </style>
@endsection
@section('content')
    <div class="page-title bg-light">
        <div class="bg-image bg-parallax"><img src="/assets/img/photos/bg-desk.jpg" alt=""></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 push-lg-4">
                    <h1 class="mb-0">我的清單</h1>
                </div>
            </div>
        </div>
    </div>

    <!-- Section -->
    <section class="section">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <!-- Side Navigation -->
                    <nav id="side-navigation" class="stick-to-content pt-4" data-local-scroll>
                        <h5 class="mb-3"><i class="ti ti-align-justify mr-3 text-muted"></i>我的清單</h5>
                    </nav>
                </div>
                <div class="col-md-8 push-md-1">
                    <div class="row">
                        <div class="col-md-6">
                            <h3><strong>食物</strong></h3>
                        </div>
                        <div class="col-md-6">
                            <h3 style="text-align: right"><strong>數量</strong></h3>
                        </div>
                    </div>
                    <hr style="margin-top: 0px;">
                    @if(count($data)>0)
                        @foreach($data as $key => $d)
                            @php ($i = "")
                            @foreach($d as $r)
                                @if($i != $r->time)
                                    <button class="accordion">{{$r->time}}</button>
                                    <div class="panel">
                                    @php ($i = $r->time)
                                @endif
                                    <br/>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h4>{{$r->name}}</h4>
                                        </div>
                                        <div class="col-md-6">
                                            <h4 style="text-align: right">{{$r->quantity}}</h4>
                                        </div>
                                    </div>
                            @endforeach
                            </div>
                        @endforeach
                    @endif
                    <hr style="margin-top: 0px;">
                    <div class="row">
                        <div class="col-md-6">
                            <h3><strong>總數</strong></h3>
                        </div>
                        <div class="col-md-6">
                            @if(count($orderFoods)>0)
                                <h3 style="text-align: right">
                                    <strong>{{$orderFoods[0]->total_quantity}}</strong></h3>
                            @else
                                <h3 style="text-align: right"><strong>0</strong></h3>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection

@section('script')
    <script>
        var acc = document.getElementsByClassName("accordion");
        var i;

        for (i = 0; i < acc.length; i++) {
            acc[i].addEventListener("click", function () {
                this.classList.toggle("active");
                var panel = this.nextElementSibling;
                if (panel.style.maxHeight) {
                    panel.style.maxHeight = null;
                } else {
                    panel.style.maxHeight = panel.scrollHeight + "px";
                }
            });
        }
    </script>
@endsection