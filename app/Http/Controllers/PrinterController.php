<?php

namespace App\Http\Controllers;

use App\OrderFood;
use App\Traits\Printer;
use Carbon\Carbon;
use App\PrintCode;
use Illuminate\Http\Request;
use App\Printer as Printers;

class PrinterController extends Controller
{
    use Printer;

    public function printKey(Request $request)
    {

        $keyCode = $this->generateKey();
        while (!$keyCode) {
            $keyCode = $this->generateKey();
        }

        $qrcodeString = 'http://manya.hkqos.com?tableId='.$request->table_id.'&printCode='.$keyCode->code;
        $printData = '<CB>御滿屋</CB><BR><BR>';
        $printData .= '<CB>桌號 : ' .$request->table_id.'</CB><BR><BR>';
        $printData .= '<QR>'.$qrcodeString.'</QR><BR><BR>';
        $printData .= 'Step1 : 掃瞄QRCODE,打開網頁<BR>';
        $printData .= 'Step2 : 選擇食物,食物將會加入準備籃<BR>';
        $printData .= 'Step3 : 按右上準備籃,調整數量並按下確認<BR>';
        $printData .= 'Step4 : 您的食物將會在15到30分鐘送到您的桌上<BR><BR>';
        $printData .= 'http://www.hkqos.com<BR>';

        $printer = Printers::where('printer_type_id','=','4')->first();
        $this->setPrinter($printer->account, $printer->account_key, $printer->printer_sn);
        $this->getPrint($printData);

        return redirect('admin/showKey');
    }

//    public function printKey(Request $request,$count)
//    {
//        if ($count) {
//            for ($i = 1; $i <= $count; $i++) {
//
//                $keyCode = $this->generateKey();
//                while (!$keyCode) {
//                    $keyCode = $this->generateKey();
//                }
//
//                $printData = '密碼　　　　　        <BR>';
//                $printData .= '--------------------------------<BR>';
//                $printData .= $keyCode->code . '<BR>';
//                $printData .= '--------------------------------<BR>';
//                $printData .='<QR>http://manya.hkqos.com?tableId='.$request->table_id.'&printCode='.$keyCode.'</QR>';
//
//                $this->setPrinter("bjtuwangjia@gmail.com", "ebIRPMY3Zr5ISM2u", "918501940");
//                $this->getPrint($printData);
//            }
//        }
//
//        return redirect('admin/showKey');
//    }

    public function printOrder($id)
    {

        $orderFood = OrderFood::join('orders', 'orders.id', 'order_foods.order_id')
            ->join('menu_products', 'menu_products.id', 'order_foods.product_id')
            ->select('*', 'order_foods.quantity as order_food_quantity')
            ->where('order_foods.id', $id)
            ->first();

        $printData = '<CB>送餐單</CB><BR>';
        $printData .= '名稱　　　　　 桌號  數量 <BR>';
        $printData .= '--------------------------------<BR>';
        $printData .= $orderFood->name . '　　　　 　' . $orderFood->table_id . '   ' . $orderFood->order_food_quantity . '<BR>';
        $printData .= '--------------------------------<BR>';

        $this->setPrinter("bjtuwangjia@gmail.com", "ebIRPMY3Zr5ISM2u", "918501940");
        $this->getPrint($printData);

        $orderFood = OrderFood::find($id);
        $orderFood->printed = 1;
        $orderFood->save();

        return redirect('order/kitchen');
    }

    private function generateKey()
    {
        //$dt = Carbon::now();
        //$code = str_random(1) . substr(sha1($dt->timestamp), 8, 4) . str_random(1);
        $code = sprintf("%06d", mt_rand(1, 999999));
        $keyCode = PrintCode::where(['code' => $code])->get();

        if (!count($keyCode)) {
            return PrintCode::create(['code' => $code]);
        } else {
            return false;
        }
    }
}
