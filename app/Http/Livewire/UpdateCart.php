<?php

namespace App\Http\Livewire;

use App\Models\Infor;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Receiver;
use App\Models\Ship;
use App\Models\Type;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Request;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class UpdateCart extends Component
{
    public function render()
    {
        $data1 = Type::get();
        $data2 = Infor::get();
        $data3 = Ship::get();
        $data4 = Payment::get();
        $data['cart'] = Cart::getcontent();
        $data['total'] = Cart::gettotal(0,"",'.');
        $data['count'] = Cart::getcontent()->count();
        $product = Product::get();
        // dd(session::get('carts'));
        return view('livewire.update-cart',$data,[
            'data1' => $data1,
            'data2' => $data2,
            'data3' => $data3,
            'data4' => $data4,
            'product' => $product,
        ]);
    }
}
