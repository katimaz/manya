<?php

namespace App\Http\Controllers;

use App\Menu;
use App\MenuProduct;
use App\OrderFood;
use App\Printer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Cart;
use DB;
use App\Order;
use Response;
use Carbon\Carbon;
use App\PrintCode;
use App\Traits\Printer;

class HomeController extends Controller
{
    use Printer;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public $cart;
    public function __construct(Request $request)
    {
        $oldCart = Session::has('cart')?Session::get('cart'):null;
        $this->cart = new Cart($oldCart);
//        $this->middleware('auth');
    }

    public function home(){

        return view('home.index_cn');
    }

    public function enghome(){

        return view('home.index');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Session::has('tableId')?Session::get('tableId'):Session::put('tableId',$request->tableId);

        $menus = Menu::all();
        $promotions = DB::table('restaurant_promotions')
            ->join('menu_products', 'menu_products.id', '=', 'restaurant_promotions.product_id')
            ->select('menu_products.*', 'restaurant_promotions.*')
            ->get();

        return view('index',compact('menus','promotions'));
    }

    public function validCode(Request $request){

        $printCode = PrintCode::where('code',$request->print_code)->first();

        if(count($printCode)){

            if($request->tableId){
                Session::put('tableId',$request->tableId);
            }

            if(!$printCode->used_time){
                $printCode->table_id = Session::get('tableId');
                $printCode->used_time = Carbon::now()->timezone('Asia/Taipei')->addHours('2')->addMinutes('30')->toDateTimeString();
                $printCode->save();
                Session::put('printCode',$request->print_code);
            }else{
                if(Carbon::now()->timezone('Asia/Taipei')->toDateTimeString() < $printCode->used_time){
                    if(Session::get('tableId') == $printCode->table_id){
                        Session::put('printCode',$request->print_code);
                    }
                }
            }
        }
        return redirect()->back();
    }

    public function menu()
    {
        $menus = Menu::all();

        $productMenus = DB::table('menus')
            ->join('menu_products', 'menus.id', '=', 'menu_products.menu_id')
            ->select('menu_products.*', 'menus.*','menu_products.id as product_id','menu_products.name as product_name','menu_products.image_url as product_image_url')
            ->where('active','1')
            ->orderBy('menu_id', 'desc')
            ->orderBy('product_name', 'asc')
            ->get();

        return view('menu',compact('menus','productMenus'));
    }
    

    public function getAddToList(Request $request){
        $product = MenuProduct::find($request->id);
        $this->cart->add($product,$product->id,$request->qty);
        $request->session()->put('cart',$this->cart);

        $result = json_encode($this->cart);
        return $result;
    }

    public function changeQty(Request $request){

        $this->cart->changeQty($request->id,$request->qty);
        $request->session()->put('cart',$this->cart);

        $jsonBody = json_encode(
            [
                'totalQty'=>$this->cart->totalQty,
                'totalPrice' => $this->cart->totalPrice
            ]
        );

        return $jsonBody;

    }

    public function remove(Request $request){
        $this->cart->remove($request->id);
        $request->session()->put('cart',$this->cart);
        return "Success";

    }

    public function orderList(Request $request){

        $orderFoods = DB::table('orders')
            ->join('order_foods', 'order_foods.order_id', '=', 'orders.id')
            ->join('menu_products', 'menu_products.id', '=', 'order_foods.product_id')
            ->select('orders.*', 'order_foods.*','menu_products.*','orders.quantity as total_quantity')
            ->where('table_id',Session::get('tableId'))
            ->where('paid','0')
            ->get();

        return view('orderList',compact('orderFoods'));
    }

    public function confirm(Request $request){
        if(Session::has('tableId') && Session::has('printCode')){

            $printCode = PrintCode::where('code',Session::get('printCode'))->first();

            if($printCode->table_id == Session::get('tableId') && (Carbon::now()->timezone('Asia/Taipei')->toDateTimeString() < $printCode->used_time)){
                if($this->cart->items !=null){
                    $temp = '<CB>御滿屋</CB><BR><BR>';
                    $temp .= '名稱　　　　　 桌號  數量 <BR>';
                    $temp .= '--------------------------------<BR>';

                    $order = Order::where('table_id', Session::get('tableId'))
                            ->where('paid',0)
                            ->first();

                    if($order === null){
                        $order = new Order;
                        $order->table_id = Session::get('tableId');
                        $order->restaurant_id = $request->restaurantId;
                        $order->order_type_id = $request->orderTypeId;
                    }
                    $order->quantity += $this->cart->totalQty;
                    $order->save();

                    $printerFood = $temp;
                    $printerSushi = $temp;
                    $printerDessert = $temp;
                    foreach($this->cart->items as $item){
                        $orderFood = new OrderFood;
                        $orderFood->order_id = $order->id;
                        $orderFood->product_id = $item['items']->id;
                        $orderFood->quantity = $item['qty'];
                        $orderFood->save();

                        $product = MenuProduct::find($item['items']->id);
                        $printer = Printer::find($product->printer_id);

                        if($printer->printer_type_id == 1){
                            //熟食
                            $printerFood .= $product->name . '　　　　 　' . Session::get('tableId') . '   ' . $item['qty'] . '<BR>';
        
                        }elseif($printer->printer_type_id == 2){
                            //壽司
                            $printerFood .= $product->name . '　　　　 　' . Session::get('tableId') . '   ' . $item['qty'] . '<BR>';

                        }elseif($printer->printer_type_id == 3){
                            //甜品
                            $printerFood .= $product->name . '　　　　 　' . Session::get('tableId') . '   ' . $item['qty'] . '<BR>';
                        }else{

                        }
                    }

                    $printerFood .= '--------------------------------<BR>';
                    $printerSushi .= '--------------------------------<BR>';
                    $printerDessert .= '--------------------------------<BR>';
                    $printers = Printer::all();

                    foreach($printers as $printer){
                        if($printer->printer_type_id == 1){
                            //熟食
                            $this->setPrinter($printer->account, $printer->account_key, $printer->printer_sn);
                            $this->getPrint($printerFood);
        
                        }elseif($printer->printer_type_id == 2){
                            //壽司
                            $this->setPrinter($printer->account, $printer->account_key, $printer->printer_sn);
                            $this->getPrint($printerFood);

                        }elseif($printer->printer_type_id == 3){
                            //甜品
                            $this->setPrinter($printer->account, $printer->account_key, $printer->printer_sn);
                            $this->getPrint($printerFood);
                        }
                    }
                    
                    $request->session()->put('cart',$this->cart);
                    $request->session()->forget('cart');
                    return view('confirmation');
                }
            }else{
                $request->session()->forget('tableId');
                $request->session()->forget('printCode');
            }
        }
        return  redirect('order/menu');
    }

    public function kitchen(){

        $orderFoods = DB::table('orders')
            ->join('order_foods', 'order_foods.order_id', '=', 'orders.id')
            ->join('menu_products', 'menu_products.id', '=', 'order_foods.product_id')
            ->select('orders.table_id','orders.id as order_id','order_foods.quantity','menu_products.name','menu_products.description','order_foods.id as id')
            ->where('printed','0')
            ->where('order_type_id','1')
            ->where('paid','0')
            ->get();

        return view('kitchen',compact('orderFoods'));
    }


}
