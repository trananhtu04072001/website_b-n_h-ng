<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Models\AtrProduct;
use App\Models\Banner;
use App\Models\EventProducts;
use App\Models\Image;
use App\Models\Importdetail;
use App\Models\Infor;
use App\Models\Product;
use App\Models\Type;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function detail($id) {
        $data1 = Type::get();
        $data2 = Infor::get();
        $data3 = AtrProduct::with(['product:id,name,price,image,des','atr:id,id_atrgroup,value'])->where('id_product',$id)->get();
        $data6 = Importdetail::select(DB::raw('id_product, SUM(quantity) as sum'))->groupBy('id_product')->with('product:id,name')->get();
        $data = Product::where('id',$id)->get();
        $data4 = Image::where('id_product',$id)->get();
        $data5['count'] = Cart::getcontent()->count();
        // up-view product
        $product = Product::find($id);
        $product->view += 1;
        $product->save();
        return view('customer.product.detail',$data5,[
            'data1' => $data1,
            'data2' => $data2,
            'data' => $data,
            'data3' => $data3,
            'data4' => $data4,
            'data6' => $data6,
        ]);
    }

    public function eventproduct() {
        $data1 = Type::get();
        $data2 = Infor::get();
        $data3 = Banner::get();
        $data4['count'] = Cart::getcontent()->count();
        $data4['cart'] = Cart::getcontent();
        $data = EventProducts::with(['event:id,name','product:id,name,price,image'])->get();
        $view = Product::with('import')->orderBy('view')->where('view','>','0')->limit(10)->get();
        return view('customer.layout.home',$data4,[
            'data1' => $data1,
            'data2' => $data2,
            'data3' => $data3,
            'data'=>$data,
            'view' => $view,
        ]);
    }

    public function listproduct($id) {
        $data1 = Type::get();
        $data2 = Infor::get();
        $data3['count'] = Cart::getcontent()->count();
        $products = null;
        if($id==0){
            $products = Product::with('import')->where('status', '1')->simplePaginate(10);
           }
        else {
        $products = Product::with(['import'])->where('status','1')->where('id_type',$id)->simplepaginate(10);
        }
        return view('customer.product.list',$data3,[
            'data1' => $data1,
            'data2' => $data2,
            'products' => $products,
        ]);
    }
}
