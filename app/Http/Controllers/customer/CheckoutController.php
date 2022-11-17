<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReceiverRequest;
use App\Models\Infor;
use App\Models\Order;
use App\Models\Orderdetail;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Receiver;
use App\Models\Ship;
use App\Models\Type;
use Darryldecode\Cart\Cart as CartCart;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    public function infor(Request $req) {
        // dd(Session::get('carts'));
        if(Auth::guard('web')->user() != null){
        $data1 = Type::get();
        $data2 = Infor::get();
        $data4['count'] = Cart::getcontent()->count();
        $data['cart'] = Cart::getcontent();
        $order = new Order();
        $order->id_user = Auth::guard('web')->user()->id;
        if(isset($req->checkbuy) == true && isset($req->selectall) == false) {
            $check = $req->checkbuy;
            // $carts = Session::get('carts');

            $oldCart = Session::has('carts') ? Session::get('carts') : null;
            $carts = new Cart($oldCart);
            // dd($oldCart);

            for($i = 0 ; $i < count($check) ; $i++) {
                $id = $check[$i];
                // dd($id);
            $cart = Cart::getcontent()->whereIn('id',$id);
                $carts = Session::get('carts');
                if(isset($carts[$id])) {
                    $carts[$id]['id'] = $id;
                    $carts[$id]['name'] = $cart[$id]->name;
                    $carts[$id]['price'] = $cart[$id]->price;
                    $carts[$id]['quantity'] = $cart[$id]->quantity;
                }
                $arr = [];
                foreach($oldCart as $val) {
                        array_push($arr,$val['id']);
                }

        for($k = 0 ; $k < count($arr) ; $k++) {
                if(in_array($arr[$k],$check) == false) {
                    $ed = $arr[$k];
                    unset($carts[$ed]);
                }
            }
            Session::put('carts', $carts);
        }
        $order->quantity += $req->quantity;
        $order->total += $req->totaltwo;
        }

        if(isset($req->checkbuy) == true && isset($req->selectall) == true) {
        foreach(Cart::getcontent() as $val) {
        $order->quantity += $val->quantity;
        $order->total = $req->total;
        }
        }
        if($req->des != ''){
        $order->des = $req->des;
        }
        else {
            $order->des = '';
        }
        $order->save();
        return redirect()->route('checkout.getinform',[$order->id]);
    }
    else {
        return redirect()->route('customer.login')->with('error','Bạn cần đăng nhập để thanh toán');
    }
    }

    public function buypro($id) {
        if(Auth::guard('web')->user() != null){
            $data4['count'] = Cart::getcontent()->count();
            $data4['total'] = Cart::gettotal(0,"",'.');
            $data['cart'] = Cart::getcontent();
            $product = Product::find($id);
            // Cart::add([
            //     'id' => $id,
            //     'name' => $product->name,
            //     'price' => $product->price,
            //     'quantity' => '1',
            //     'weight' => 0,
            //     'options' => array(
            //         'image' => $product->image,
            //     )
            // ]);
            $carts = Session::get('carts');
            $carts = [
                $id => [
                    'name' => $product->name,
                    'price' => $product->price,
                    'quantity' => '1',
                    'options' => array(
                    'image' => $product->image,
                 )
                ]
                ];
            Session::put('carts', $carts);
            $order = new Order();
            $order->id_user = Auth::guard('web')->user()->id;
            $order->quantity = 1;
            $order->total = $product->price;
            $order->des = '';
            $order->save();
            return redirect()->route('checkout.getinform',[$order->id]);
        }
        else {
            return redirect()->route('customer.login')->with('error','Bạn cần đăng nhập để thanh toán');
        }
    }

    public function getinform($id) {
        $data1 = Type::get();
        $data2 = Infor::get();
        $data3 = Ship::get();
        $data4['count'] = Cart::getcontent()->count();
        $data4['total'] = Cart::gettotal(0,"",'.');
        $data5 = Payment::get();
        $order = Order::where('id',$id)->get();
        return view('customer.checkout.infor',$data4,[
            'data1' => $data1,
            'data2' => $data2,
            'data3' => $data3,
            'data5' => $data5,
            'order' => $order,          
        ]);
    }
    public function postinform(ReceiverRequest $req) {
    if(Auth::guard('web')->user() != null){
        $receiver = new Receiver();
        $receiver->name = $req->name;
        $receiver->email = $req->email;
        $receiver->phone = $req->phone;
        $receiver->address = $req->address;
        $receiver->id_user = Auth::guard('web')->user()->id;
        $receiver->save();

        $id = Auth::guard('web')->user()->id;
        $order = Order::where('id_user',$id)->get();
        if(Session::get('carts') != null){
            $ses = Session::get('carts');
            // dd($ses);
            $arr = [];
            foreach($ses as $id => $val) {
                $order_detail = new Orderdetail();
                foreach($order as $item){
                $order_detail->order_id = $item->id;
                }
                $order_detail->receiver_id = $receiver->id;
                $order_detail->product_id = $val['id'];
                $order_detail->payment_id = $req->payment_id;
                $order_detail->ship_id = $req->ship_id;
                $order_detail->color = $val['attributes']['color'];
                $order_detail->size = $val['attributes']['size'];
                $order_detail->single_quantity = $val['quantity'];
                $order_detail->total = $req->total;
                $order_detail->save();
                array_push($arr,$val['id']);
    }
    for ($i = 0 ; $i < count($ses) ; $i++) {
        Cart::remove($arr[$i]);
        $carts = Session::get('carts');
                unset($carts[$i]);
                session()->put('carts', $carts);
    }
    }
}
        return redirect()->route('product.event')->with('success','Đặt hàng thành công,vui lòng chờ xét duyệt đơn hàng');
}
}
