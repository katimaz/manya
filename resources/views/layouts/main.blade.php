<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>

    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Favicons -->
    <link rel="shortcut icon" href="/public/assets/img/favicon.png">
    <link rel="apple-touch-icon" href="/public/assets/img/favicon_60x60.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/public/assets/img/favicon_76x76.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/public/assets/img/favicon_120x120.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/public/assets/img/favicon_152x152.png">

    @include('layouts.style')
    <style>
        .input-number-group {
            display: -webkit-flex;
            display: -ms-flexbox;
            display: flex;
            -webkit-justify-content: center;
            -ms-flex-pack: center;
            justify-content: center;
        }

        .input-number-group input[type=number]::-webkit-inner-spin-button,
        .input-number-group input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            appearance: none;
        }

        .input-number-group .input-group-button {
            line-height: calc(80px/2 - 5px);
        }

        .input-number-group .input-number {
            width: 60px;
            padding: 0 12px;
            vertical-align: top;
            text-align: center;
            outline: none;
            display: block;
            margin: 0;
        }

        .input-number-group .input-number,
        .input-number-group .input-number-decrement,
        .input-number-group .input-number-increment,
        .input-number-group .cart-decrement,
        .input-number-group .cart-increment {
            border: 1px solid #cacaca;
            height: 40px;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            border-radius: 0;
        }

        .input-number-group .input-number-decrement,
        .input-number-group .input-number-increment,
        .input-number-group .cart-decrement,
        .input-number-group .cart-increment{
            display: inline-block;
            width: 30px;
            background: #e6e6e6;
            color: #0a0a0a;
            text-align: center;
            font-weight: bold;
            cursor: pointer;
            font-size: 2rem;
            font-weight: 400;
        }

        .input-number-group .input-number-decrement,
        .input-number-group .cart-decrement{
            margin-right: 0.3rem;
        }

        .input-number-group .input-number-increment,
        .input-number-group .cart-increment{
            margin-left: 0.3rem;
        }

        @media (min-width: 276px) {
            .well{
                width: 80%;
                min-height: 20px;
                padding: 19px;
                margin-bottom: 20px;
                background-color: #f5f5f5;
                border: 1px solid #e3e3e3;
                border-radius: 4px;
                -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.05);
                box-shadow: inset 0 1px 1px rgba(0,0,0,.05);
            }
            .blockMsg{
                width: 48% !important;
                left: 28% !important;
            }
        }

        @media (min-width: 576px) {
            .well{
                width: 70%;
                min-height: 20px;
                padding: 19px;
                margin-bottom: 20px;
                background-color: #f5f5f5;
                border: 1px solid #e3e3e3;
                border-radius: 4px;
                -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.05);
                box-shadow: inset 0 1px 1px rgba(0,0,0,.05);
            }
        }

        @media (min-width: 1200px) {
            .well{
                width: 30%;
                min-height: 20px;
                padding: 19px;
                margin-bottom: 20px;
                background-color: #f5f5f5;
                border: 1px solid #e3e3e3;
                border-radius: 4px;
                -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.05);
                box-shadow: inset 0 1px 1px rgba(0,0,0,.05);
            }
        }

        #top {
          display: none;
          position: fixed;
          bottom: 20px;
          right: 30px;
          z-index: 99;
          font-size: 18px;
          border: none;
          outline: none;
          background-color: grey;
          color: white;
          cursor: pointer;
          padding: 15px;
          border-radius: 4px;
        }

        #top:hover {
          background-color: #555;
        }

    </style>
</head>
<body>
<div id="body-wrapper" class="animsition">
    @include('layouts.header')
    <div id="content">
        @yield('content')
        @include('layouts.cart')

        <div id="body-overlay"></div>
    </div>

    {{--@include('layouts.footer')--}}
    {{--@include('layouts.model')--}}
    @if(!session()->has('printCode'))
        <div id="my_popup" class="well">
            <form action="{{url('order/validCode')}}" method="get">
                @csrf
                @if(!session()->has('tableId'))
                <div class="form-group">
                    <label>@lang('setting.tableId')</label>
                    <input type="text" class="form-control" id="tableId" name="tableId" placeholder="請輸入桌號">
                </div>
                @endif
                <div class="form-group">
                    <label>@lang('setting.password')</label>
                    <input type="text" class="form-control" id="printCode" name="printCode" placeholder="請輸入密碼">
                </div>
                <button type="submit" class="btn btn-primary">@lang('setting.confirm')</button>
            </form>
        </div>
    @endif

    <button onclick="topFunction()" id="top" title="Go to top">置頂</button>

    @include('layouts.script')
    <script src="https://cdn.rawgit.com/vast-engineering/jquery-popup-overlay/1.7.13/jquery.popupoverlay.js"></script>
    <script>
        $(document).ready(function() {

            // Initialize the plugin
            $('#my_popup').popup({
                autoopen:true,
                blur:false,
                escape:false,
            });

        });
    </script>
    <script>
        var isMobile = false; //initiate as false
        // device detection
        if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent)
            || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0,4))) {
            isMobile = true;
        }

        if(isMobile){
            $('#cart-item').on('touchstart','.cart-increment',function () {
//                console.log("cart-increment");
                var $totalPrice = $(this).parents().parents('#one-item').find('.price');
                var $input = $(this).parents('.input-number-group').find('.input-number');
                //var $price = $(this).parents('.input-number-group').find('.single-price');
                var val = parseInt($input.val(), 10);
                //var single_price = $price.val();

                if (val < 20 ){
                    $input.val(val + 1);
                    $.ajax({
                        type: 'get',
                        //url: "change?id="+$input.attr('id')+"&qty="+(val+1)+"&price="+single_price,
                        url: "change?id="+$input.attr('id')+"&qty="+(val+1),
                        success: function(result){
                            $json = JSON.parse(result);
                            $('#totalQty').text($json['totalQty']);
                            //$totalPrice.text("$"+$json['price'])
                        }
                    });
                }
            });

            $('#cart-item').on('touchstart','.cart-decrement',function () {
//                console.log("cart-decrement");
                var $totalPrice = $(this).parents().parents('#one-item').find('.price');
                var $input = $(this).parents('.input-number-group').find('.input-number');
                //var $price = $(this).parents('.input-number-group').find('.single-price');
                var val = parseInt($input.val(), 10);
                //var single_price = $price.val();

                if(val > 1){
                    $input.val(val - 1);
                    $.ajax({
                        type: 'get',
                        //url: "change?id="+$input.attr('id')+"&qty="+(val-1)+"&price="+single_price,
                        url: "change?id="+$input.attr('id')+"&qty="+(val-1),
                        success: function(result){
                            $json = JSON.parse(result);
                            $('#totalQty').text($json['totalQty']);
                            //$totalPrice.text("$"+$json['price'])
                        }
                    });
                }
            })

        }else{
            $('#cart-item').on('click','.cart-increment',function () {
//                console.log("cart-increment");
                var $totalPrice = $(this).parents().parents('#one-item').find('.price');
                var $input = $(this).parents('.input-number-group').find('.input-number');
                //var $price = $(this).parents('.input-number-group').find('.single-price');
                var val = parseInt($input.val(), 10);
                //var single_price = $price.val();

                if (val < 20 ){
                    $input.val(val + 1);
                    $.ajax({
                        type: 'get',
                        //url: "change?id="+$input.attr('id')+"&qty="+(val+1)+"&price="+single_price,
                        url: "change?id="+$input.attr('id')+"&qty="+(val+1),
                        success: function(result){
                            $json = JSON.parse(result);
                            $('#totalQty').text($json['totalQty']);
                            //$totalPrice.text("$"+$json['price'])
                        }
                    });
                }
            });

            $('#cart-item').on('click','.cart-decrement',function () {
//                console.log("cart-decrement");
                var $totalPrice = $(this).parents().parents('#one-item').find('.price');
                var $input = $(this).parents('.input-number-group').find('.input-number');
                //var $price = $(this).parents('.input-number-group').find('.single-price');
                var val = parseInt($input.val(), 10);
                //var single_price = $price.val();

                if(val > 1){
                    $input.val(val - 1);
                    $.ajax({
                        type: 'get',
                        //url: "change?id="+$input.attr('id')+"&qty="+(val-1)+"&price="+single_price,
                        url: "change?id="+$input.attr('id')+"&qty="+(val-1),
                        success: function(result){
                            $json = JSON.parse(result);
                            $('#totalQty').text($json['totalQty']);
                            //$totalPrice.text("$"+$json['price'])
                        }
                    });
                }
            })
        }
        $('#cart-item').on('click','.remove',function () {
            $.ajax({
                type: 'get',
                url: "remove?id="+$(this).attr('id'),
                success: function(result){
                    location.reload();
                }
            });
        });

        $('.add-to-list').click(function(){
            product_id = $(this).attr("product_id");
            qty = $(this).attr("qty");
            //price = $(this).attr("price");

            $.ajax({
                type: 'post',
                data: {qty : qty,id : product_id, _token: '{{csrf_token()}}'},
                url: '/addToList',
                success: function(result) {
                    $('#cart-item').empty();
                    $json = JSON.parse(result);
//                    console.log($json);
//                    console.log($json['totalPrice']);
//                    console.log($json['totalQty']);
                    html ='<tbody>';
                    for(var k in $json['items']) {
//                        console.log(k, $json['items'][k]);
//                        console.log(k, $json['items'][k]['items']['name']);
                        html +=
                            '<tr id="one-item">' +
                            '   <td class="title">' +
                            '       <span class="name"><a>'+$json['items'][k]['items']['name']+'</a></span>' +
                            '       <span class="caption text-muted">'+$json['items'][k]['items']['description']+'</span>' +
                            '   </td>' +
                            '   <td class="qty">' +
                            '       <div class="input-group input-number-group">' +
                            '           <div class="input-group-button">' +
                            '               <span class="cart-decrement">-</span>' +
                            '           </div>' +
                            '           <input id="'+$json['items'][k]['items']['id']+'" class="input-number" type="number" value="'+$json['items'][k]['qty']+'" min="1" max="20"' +
                            '                  readonly>' +
                            '           <div class="input-group-button">' +
                            '               <span class="cart-increment">+</span>' +
                            '           </div>' +
                            '       </div>' +
                            '   </td>' +
                            '   <td class="actions">' +
                            '       <a id="'+$json['items'][k]['items']['id']+'" href="#" class="action-icon remove"><i class="ti ti-close"></i></a>' +
                            '   </td>' +
                            '</tr>';
                    }
                    html+='</tbody>';

                    $('#cart-item').html(html);

                    $('#totalQty').text($json['totalQty']);
                    $('.notification').text(Object.keys(($json['items'])).length);

                    $.blockUI({
                        css: {
                            padding: '30px',
                        },
                        message: '<h5 style="margin: 0px"><img src="/public/image/busy.gif" /> 請稍候...</h5>'
                    });

                    setTimeout($.unblockUI, 500)

                },
            });
        });
    </script>
    <script>
        // When the user scrolls down 20px from the top of the document, show the button
        window.onscroll = function() {scrollFunction()};

        function scrollFunction() {
            if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                document.getElementById("top").style.display = "block";
            } else {
                document.getElementById("top").style.display = "none";
            }
        }

        // When the user clicks on the button, scroll to the top of the document
        function topFunction() {
            document.body.scrollTop = 0;
            document.documentElement.scrollTop = 0;
        }
    </script>
</div>
</body>
</html>
