<?php

namespace App\Http\Controllers;

use App\Menu;
use App\MenuProduct;
use App\Order;
use App\OrderFood;
use App\PrintCode;
use App\Printer as Printers;
use App\PrinterType;
use App\Product;
use App\Traits\Printer;
use Auth;
use DataTables;
use DB;
use Illuminate\Http\Request;
use Image;
use Session;

class AdminController extends Controller
{
    use Printer;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('admin.index');
    }

    public function printCode()
    {
        $printCodes = PrintCode::all();

        return view('admin.printcode.index',compact('printCodes'));
    }
    public function product()
    {
        $products = MenuProduct::join('menus', 'menus.id', '=', 'menu_products.menu_id')
            ->join('printers','printers.id','=','menu_products.printer_id')
            ->where('restaurant_id',Auth::user()->restaurant_id)
            ->select('*','menu_products.name as products_name','menu_products.id as products_id','menu_products.image_url as products_image_url','printers.name as printer_name')
            ->get();

        return view('admin.product.index',compact('products'));
    }

    public function addProduct()
    {
        $menus = Menu::where('restaurant_id',Auth::user()->restaurant_id)->get();

        $printers = Printers::all();

        return view('admin.product.add',compact('menus','printers'));
    }

    public function createProduct(Request $request)
    {
        $product = new MenuProduct();

        $product->name = $request->name;
        $product->description = $request->description;
        $product->menu_id = $request->menu_id;
        $product->printer_id = $request->printer_id;

        if($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(300, 200)->save(public_path('uploads/products/' . $filename));
            $product->image_url = "uploads/products/" . $filename;
        }

        $product->save();

        return redirect('admin/product');
    }

    public function modifyProduct($id)
    {
        $product = MenuProduct::find($id);

        $menus = Menu::all();

        $printers = Printers::all();

        return view('admin.product.modify',compact('product','menus','printers'));
    }

    public function deleteProduct($id)
    {
        Product::destroy($id);

        return redirect('admin/product');
    }

    public function updateProduct(Request $request , $id)
    {
        $product = MenuProduct::find($id);

        $product->name = $request->name;
        $product->description = $request->description;
        $product->menu_id = $request->menu_id;
        $product->printer_id = $request->printer_id;
        $product->active = $request->active;
        $product->take_away = $request->takeAway;

        if($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(300, 200)->save(public_path('uploads/products/' . $filename));
            $product->image_url = "uploads/products/" . $filename;
        }

        $product->save();

        session(['success' => '資料已修改.']);
        return redirect()->back();
    }

    public function addMenu()
    {
        return view('admin.menu.add');
    }

    public function menu()
    {
        $menus = Menu::where('restaurant_id',Auth::user()->restaurant_id)->get();

        return view('admin.menu.index',compact('menus'));
    }

    public function modifyMenu($id)
    {
        $menu = Menu::find($id);

        return view('admin.menu.modify',compact('menu'));
    }

    public function deleteMenu($id)
    {
        Menu::destroy($id);

        return redirect('admin/menu');
    }

    public function updateMenu(Request $request , $id)
    {
        $menu = Menu::find($id);

        $menu->name = $request->name;

        if($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(620, 542)->save(public_path('uploads/menus/' . $filename));
            $menu->image_url = "uploads/menus/" . $filename;
        }

        if($request->hasFile('image_menu')) {
            $image_menu = $request->file('image_menu');
            $filename = time() . '.' . $image_menu->getClientOriginalExtension();
            Image::make($image_menu)->resize(900, 337)->save(public_path('uploads/menus/' . $filename));
            $menu->image_menu_url = "uploads/menus/" . $filename;
        }

        $menu->save();
        session(['success' => '資料已修改.']);
        return redirect()->back();
    }

    public function createMenu(Request $request)
    {
        $menu = new Menu;

        $menu->name = $request->name;

        if($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(620, 542)->save(public_path('uploads/menus/' . $filename));
            $menu->image_url = "uploads/menus/" . $filename;
        }

        if($request->hasFile('image_menu')) {
            $image_menu = $request->file('image_menu');
            $filename = time() . '.' . $image_menu->getClientOriginalExtension();
            Image::make($image_menu)->resize(900, 337)->save(public_path('uploads/menus/' . $filename));
            $menu->image_menu_url = "uploads/menus/" . $filename;
        }

        $menu->restaurant_id = Auth::user()->restaurant_id;

        $menu->save();

        return redirect('admin/menu');
    }


    public function order()
    {
        $orders = Order::where('paid',0)->get();

        return view('admin.order.index',compact('orders'));
    }

    public function table()
    {


        return view('admin.table.info');
    }

    public function detailOrder($id){

        $orderFoods  = DB::select('SELECT orders.id,order_foods.product_id,sum(order_foods.quantity) as sum_quantity,menu_products.name,menu_products.description,menu_products.image_url,orders.paid FROM `orders`,`order_foods`,menu_products 
                   WHERE orders.id = order_foods.order_id 
                   and order_foods.product_id = menu_products.id
                   and orders.restaurant_id = :restaurant_id
                   and orders.id = :id
                   group by orders.id,order_foods.product_id', ['id' => $id,'restaurant_id' => Auth::user()->restaurant_id]);

        $order = Order::where('id',$id)->first();

        return view('admin.order.detail',compact('order','orderFoods'));
    }

    public function updateOrder(Request $request, $id){

        $order = Order::find($id);
        $order->paid = $request->paid;
        $order->save();

        $printerCode = PrintCode::find($order->print_codes_id);
        $printerCode->done = 1;
        $printerCode->save();

        return "SUCCESS";
    }

    public function paidOrder(Request $request){

        Order::where('table_id',$request->table_id)->update(['paid' => 1]);

        return "SUCCESS";
    }

    public function showKey(){
        return view('admin.printcode.print');
    }

    public function printer()
    {
        $printers = Printers::join('printer_types','printer_types.id','printers.printer_type_id')->select('*','printers.id as printer_id','printers.name as printer_name')->get();

        return view('admin.printer.index',compact('printers'));
    }

    public function deletePrinter($id)
    {
        Printers::destroy($id);

        return redirect('admin/printer');
    }

    public function updatePrinter(Request $request , $id)
    {
        $printer = Printers::find($id);;

        $printer->name = $request->name;
        $printer->account = $request->account;
        $printer->account_key = $request->account_key;
        $printer->printer_key = $request->printer_key;
        $printer->printer_sn = $request->printer_sn;
        $printer->printer_type_id = $request->printer_type_id;
        $printer->save();

        session(['success' => '資料已修改.']);
        return redirect()->back();
    }

    public function modifyPrinter($id)
    {
        $printer = Printers::find($id);

        $printTypes = PrinterType::all();

        return view('admin.printer.modify',compact('printer','printTypes'));
    }

    public function createPrinter(Request $request)
    {
        $printer = new Printers;

        $printer->name = $request->name;
        $printer->account = $request->account;
        $printer->account_key = $request->account_key;
        $printer->printer_sn = $request->printer_sn;
        $printer->printer_key = $request->printer_key;
        $printer->printer_type_id = $request->printer_type_id;
        $printer->save();

        //$snlist = $printer->account_sn.$printer->account_key."#remark1#carnum1\nsn2#key2#remark2#carnum2";

        $this->setPrinter($request->account, $request->account_key, $request->printer_sn);
        $snlist = $request->printer_sn.'#'.$request->printer_key;
        $this->add_printer($snlist);

        return redirect('admin/printer');
    }

    public function addPrinter()
    {
        $printTypes = PrinterType::all();

        return view('admin.printer.add',compact('printTypes'));
    }

    public function setting()
    {
        return view('admin.setting.index');
    }

    public function reset()
    {
        PrintCode::truncate();
        Order::truncate();
        OrderFood::truncate();

        session(['success' => '資料已清除.']);

        return "Success";
    }
}
