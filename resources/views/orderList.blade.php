@extends('layouts.main')

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
                        @if(count($orderFoods)>0)
                            @foreach($orderFoods as $orderFood)
                                <div class="row">
                                    <div class="col-md-6">
                                        <h3>{{$orderFood->name}}</h3>
                                    </div>
                                    <div class="col-md-6">
                                        <h3 style="text-align: right">{{$orderFood->quantity}}</h3>
                                    </div>
                                </div>
                                <hr style="margin-top: 0px;">
                            @endforeach
                        @endif
                        <div class="row">
                            <div class="col-md-6">
                                <h3><strong>總數</strong></h3>
                            </div>
                            <div class="col-md-6">
                                @if(count($orderFoods)>0)
                                    <h3 style="text-align: right"><strong>{{$orderFoods[0]->total_quantity}}</strong></h3>
                                @else
                                    <h3 style="text-align: right"><strong>0</strong></h3>
                                @endif
                            </div>
                        </div>
                        <hr style="margin-top: 0px;">
                    </div>
                </div>
            </div>

        </section>
@endsection
