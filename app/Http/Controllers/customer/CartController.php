<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Models\Atribute;
use App\Models\EventProducts;
use App\Models\Infor;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Ship;
use App\Models\Type;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use GrahamCampbell\ResultType\Success;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function addcartdetail(Request $req,$id) {
        $product = Product::find($id);
        $cart = Cart::getcontent();
        // dd($cart);
        for($i = 0 ; $i <= count($cart) ; $i++) {
        if(empty($cart[$id]) == true) {
                    Cart::add([
                        'id' => $id,
                        'name' => $product->name,
                        'price' => $product->price,
                        'quantity' => $req->quantity,
                        'attributes' => array(
                            'image' => $product->image,
                            'color' => $req->color,
                            'size' => $req->size,
                        )
                    ]);
                    break;
                }
                if(empty($cart[$id+1]) == true) {
                    Cart::add([
                        'id' => $id+1,
                        'name' => $product->name,
                        'price' => $product->price,
                        'quantity' => $req->quantity,
                        'attributes' => array(
                            'image' => $product->image,
                            'color' => $req->color,
                            'size' => $req->size,
                        )
                    ]);
                    break;
                }
        if($cart[$id+1]['attributes']['color'] != $req->color || $cart[$id+1]['attributes']['size'] != $req->size) {
            Cart::add([
                'id' => $id + 2,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $req->quantity,
                'attributes' => array(
                    'image' => $product->image,
                    'color' => $req->color,
                    'size' => $req->size,
                )
            ]);
            break;
        }
        if(empty($req->color) == false || empty($req->size) == false) {
            Cart::add([
                'id' => $id + 1,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $req->quantity,
                'attributes' => array(
                    'image' => $product->image,
                    'color' => $req->color,
                    'size' => $req->size,
                )
            ]);
            break;
        }
    }
    $carts = Session::get('carts');
    $arr = [];
    foreach($cart as $val) {
        $cat = [
            'id' => $id,
            'name' => $val['name'],
            'price' => $val['price'],
            'quantity' => $val['quantity'],
            'attributes' => array(
            'image' => $val['attributes']['image'],
            'color' => $val['attributes']['color'],
            'size' => $val['attributes']['size'],
                    )
        ];
        array_push($arr,$cat);
    }
        Session::put('carts',$arr);
        // dd($carts);
        return redirect('customer/cartlist')->with('success','Sản phẩm đã được thêm vào giỏ hàng');
    }


    public function addcart($id, Request $req) {
        $product = Product::find($id);
             Cart::add([
            'id' => $id,
            'name' => $product->name,
            'price' => $product->price,
            'quantity' => '1',
            'attributes' => array(
                'image' => $product->image,
                'color' => '0',
                'size' => '0',
            )
        ]);
        $carts = Session::get('carts');
        if(!$carts) {
            $carts = [
                $id => [
                    'id' => $id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'quantity' => '1',
                    'attributes' => array(
                    'image' => $product->image,
                    'color' => '0',
                    'size' => '0',
                 )
                ]
                ];
        Session::put('carts', $carts);
        return redirect('customer/cartlist')->with('success','Sản phẩm đã được thêm vào giỏ hàng');
    }
    if(isset($carts[$id])){
        $carts[$id]['quantity']++;
        Session::put('carts', $carts);
        return redirect('customer/cartlist')->with('success','Sản phẩm đã được thêm vào giỏ hàng');
    }

    $carts[$id] = [
        'id' => $id,
        'name' => $product->name,
        'price' => $product->price,
        'quantity' => 1,
        'attributes' => array(
            'image' => $product->image,
            'color' => '0',
            'size' => '0',
        )
    ];
     session()->put('carts', $carts);
    return redirect()->back()->with('success', 'Sản phẩm đã được thêm vào giỏ hàng');
}

    public function updatecart($id,Request $req) {
        $carts = Session::get('carts');
        // dd($id);
        // $pro = Product::find($id);
        // dd($req->$id);
        if(isset($carts[$id])) {
            $carts[$id]['quantity'] = $req->$id;
            Session::put('carts', $carts);
        }
        $cart = Cart::getcontent();
        Cart::update($id,array(
            'quantity' => ($req->$id)-($cart[$id]['quantity']),
        ));
        return redirect()->route('cart.list')->with('success','giỏ hàng đã được cập nhật');
    }

    public function removecart($id) {
        Cart::remove($id);
        $carts = Session::get('carts');
            if(isset($carts[$id])) {
                unset($carts[$id]);
                session()->put('carts', $carts);
            }
        return redirect()->route('cart.list')->with('Success','Sản phẩm đã được xoá khỏi giỏ hàng');
    }

    public function clearcart() {
        Cart::clear();
        // Session::flush();
        Session::forget('carts');
        return redirect()->route('cart.list');
    }

    public function addeventcart($id, Request $req) {
        $Eventproduct = EventProducts::with(['product:id,name,price,image'])->where('id_product',$id)->get();
        foreach($Eventproduct as $product) {
        }
             Cart::add([
            'id' => $id,
            'name' => $product->product->name,
            'price' => $product->product->price-($product->product->price*$product->discount)/100,
            'quantity' => '1',
            'attributes' => array(
                'image' => $product->product->image,
                'color' => '0',
                'size' => '0',
            )
        ]);
        $carts = Session::get('carts');
        if(!$carts) {
            $carts = [
                $id => [
                    'id' => $id,
                    'name' => $product->product->name,
                    'price' => $product->product->price-($product->product->price*$product->discount)/100,
                    'quantity' => '1',
                    'attributes' => array(
                    'image' => $product->product->image,
                    'color' => '0',
                    'size' => '0',
                 )
                ]
                ];
        Session::put('carts', $carts);
        return redirect('customer/cartlist')->with('success','Sản phẩm đã được thêm vào giỏ hàng');
    }
    if(isset($carts[$id])){
        $carts[$id]['quantity']++;
        Session::put('carts', $carts);
        return redirect('customer/cartlist')->with('success','Sản phẩm đã được thêm vào giỏ hàng');
    }

    $carts[$id] = [
        'id' => $id,
        'name' => $product->product->name,
        'price' => $product->product->price-($product->product->price*$product->discount)/100,
        'quantity' => 1,
        'attributes' => array(
            'image' => $product->product->image,
            'color' => '0',
            'size' => '0',
        )
    ];
     session()->put('carts', $carts);
    return redirect()->back()->with('success', 'Sản phẩm đã được thêm vào giỏ hàng');
}
}
