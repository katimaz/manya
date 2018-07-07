@extends('layouts.main')

@section('style')
@endsection

@section('content')
    <section class="section bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 push-lg-4">
                    <span class="icon icon-xl icon-success"><i class="ti ti-check-box"></i></span>
                    <h1 class="mb-2">我們正在準備您的食物!</h1>
                    <h4 class="text-muted mb-5">您的食物將會盡快送到您的桌上.</h4>
                    <a href="{{url('/')}}" class="btn btn-outline-secondary"><span>回到菜單</span></a>
                </div>
            </div>
        </div>
    </section>
@endsection