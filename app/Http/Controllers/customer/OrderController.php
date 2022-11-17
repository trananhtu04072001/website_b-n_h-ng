<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Models\Infor;
use App\Models\Order;
use App\Models\Orderdetail;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Reorder;
use App\Models\Ship;
use App\Models\Type;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    public function index($id) {
        $data1 = Type::get();
        $data2 = Infor::get();
        $data5['count'] = Cart::getcontent()->count();
        $order = Order::with('users:id,name')->where('id_user',$id)->where('status','!=',6)->where('status','!=',7)->Where('status','!=',0)->orderBy('id','desc')->get();
        return view('customer.order.list',$data5,
        [
            'order' => $order,
            'data1' => $data1,
            'data2' => $data2,
        ]);
    }

    public function history($id) {
        $data1 = Type::get();
        $data2 = Infor::get();
        $data5['count'] = Cart::getcontent()->count();
        $order = Order::with('users:id,name')->where('id_user',$id)->where('status',6)->orwhere('status',0)->get();
        return view('customer.order.history',$data5,[
            'order' => $order,
            'data1' => $data1,
            'data2' => $data2,
        ]);
    }

    public function detail($id) {
        $detail = Orderdetail::with(['order:id,quantity','receiver:id,name,email,phone,address','product:id,name,price,image','payment:id,method','ship:id,name,price'])
        ->where('order_id',$id)->get();
        return response()->json($detail, 200);
    }

    public function status($id) {
        $order = Order::find($id);
        for($i = 0 ; $i < 4 ; $i++){
            if($order->status == 1) {
                $order->status = 0;
                break;
            }
            if($order->status == 5) {
                $order->status = 6;
                break;
            }
            if($order->status == 0) {
                $order->status = 1;
                break;
            }
        }
        $order->save();
        return redirect()->route('order.index',Auth::guard('web')->user()->id);
    }

    public function rebuy($id) {
        $order = Order::find($id);
        $order_detail = Orderdetail::with('product:id,name,price,image')->where('order_id',$id)->get();
        // dd($order_detail);
        foreach($order_detail as $product){
            Cart::add([
                'id' => $product->product->id,
                'name' => $product->product->name,
                'price' => $product->product->price,
                'quantity' => $product->single_quantity,
                'attributes' => array(
                    'image' => $product->product->image,
                    'color' => $product->color,
                    'size' => $product->size,
                )
            ]);
        }
        // $cart = Cart::getcontent();
        // dd($cart);
        $data4['count'] = Cart::getcontent()->count();
        $data4['total'] = Cart::gettotal(0,"",'.');
        $reorder = new Order();
        $reorder->id_user = $order->id_user;
        $reorder->quantity = $order->quantity;
        $reorder->total = $order->total;
        $reorder->status = 1;
        $reorder->des = '';
        $reorder->save();
        return redirect()->route('checkout.getinform',$id);
    }

    public function reorder($id) {
        $detail = Orderdetail::with(['order:id,quantity','receiver:id,name,email,phone,address','product:id,name,price,image','payment:id,method','ship:id,name,price'])
            ->where('order_id',$id)->get();
        return response()->json($detail, 200);
    }

    public function reorderpush(Request $req ,$id) {
        $reorde = new Reorder();
        $reorde->product_id = $req->product;
        $reorde->des = $req->des;
        $reorde->user_id = Auth::guard('web')->user()->id;
        $reorde->ship_id = $req->ship_id;
        $reorde->order_id = $id;
        $reorde->save();
        $order = Order::find($id);
        $order->status = 7;
        $order->save();
        return redirect()->route('order.index',Auth::guard('web')->user()->id)->with('success','Đã tạo đơn hoàn trả hàng');
    }

    public function listreorder($id) {
        $data1 = Type::get();
        $data2 = Infor::get();
        $data3 = Ship::get();
        $data4['count'] = Cart::getcontent()->count();
        $data4['total'] = Cart::gettotal(0,"",'.');
        $reorder = Reorder::where('user_id',$id)->get();
        return view('customer.order.reorder',$data4,[
            'data1' => $data1,
            'data2' => $data2,
            'data3' => $data3,
            'reorder' => $reorder
        ]);
    }

    public function reorderstatus($id) {
        $reorder = Reorder::find($id);
        // Đã giao cho shipper
        if($reorder->status == 2) {
            $reorder->status = 3;
        }
        $reorder->save();
        return redirect()->route('order.reorder.list',Auth::guard('web')->user()->id)->with('success','Đã cập nhật trạng thái thành công');
    }

    public function reorderdetail($id) {
        $data = Orderdetail::with(['order:id,quantity,total', 'receiver:id,name,email,phone,address', 'product:id,name,price,image', 'payment:id,method', 'ship:id,name,price'])
        ->where('order_id', $id)->get();
        return response()->json($data, 200);
    }
}
