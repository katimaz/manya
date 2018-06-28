<?php

namespace App;

class Cart
{
    public $items = null;
    public $totalQty = 0;
    public $totalPrice = 0;

    public function __construct($oldCart){
        if($oldCart){
            $this->items = $oldCart->items;
            $this->totalQty = $oldCart->totalQty;
            $this->totalPrice = $oldCart->totalPrice;
        }
    }

    public function add($items,$id,$qty){
        $storedItem = ['qty'=>0,'items'=>$items];

        if($this->items){
            if(array_key_exists($id,$this->items)){
                $storedItem = $this->items[$id];
            }
        }
        $storedItem['qty'] = $storedItem['qty']+$qty;
        $this->items[$id]=$storedItem;
        $this->totalQty = $this->totalQty+$qty;
    }

    public function changeQty($id,$qty){
        if($this->items){
            if(array_key_exists($id,$this->items)){
                $storedItem = $this->items[$id];
                $temp = $storedItem['qty'];
                $storedItem['qty'] = $qty;
                $this->items[$id]=$storedItem;
                $this->totalQty = $this->totalQty+$qty-$temp;
            }
        }
    }

    public function remove($id){
        if($this->items){
            if(array_key_exists($id,$this->items)){
                $this->totalQty = $this->totalQty - $this->items[$id]['qty'];
                $this->items = array_except($this->items,[$id]);
            }
        }
    }
}
