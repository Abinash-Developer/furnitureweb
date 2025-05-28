<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\AddToCart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductControllerWeb extends Controller
{
    public function fetch(){
        try {
            $products = Products::orderBy('created_at','DESC')->limit(3)->get();
            return view('home',compact('products'));
        } catch (\Throwable $th) {
            return response()->json(['success'=>true,'message'=>$th->getMessage()]);
        }
    }
    public function addToCart(Request $request){
        try {
            AddToCart::create([
                'user_id'=>Auth::user()->id,
                'product_id'=>$request->product_id,
            ]);
            return response()->json(['success'=>true,'message'=>"added product to cart successfully"]);
        } catch (\Throwable $th) {
            return response()->json(["success"=>false,"message"=>$th->getMessage()]);
        }
    }
    public function fetchCartProducts(Request $request){
        try {
             $cartDetails = DB::table('carts')
            ->join('products', 'carts.product_id', '=', 'products.id')
            ->select(
                'products.id as product_id',
                'products.name',
                'products.price',
                'products.image',
                'carts.user_id',
                'carts.product_id',
                DB::raw('COUNT(carts.product_id) as total_product'),
                DB::raw('SUM(products.price) as total_product_price')
            )
            ->where('carts.user_id', Auth::id())
            ->groupBy(
                'products.id',
                'products.name',
                'products.price',
                'products.image',
                'carts.user_id',
                'carts.product_id'
            )
            ->get();
           $totalProduct_price = Products::join('carts','products.id','=','carts.product_id')->where('user_id','=',Auth::id())->select(DB::raw('SUM(products.price) as total_price'))->value('total_price');
        return view('cart',compact('cartDetails','totalProduct_price'));
        } catch (\Throwable $th) {
            return response()->json(["success"=>false,"message"=>$th->getMessage()]);
        }
    }
    public function removeCartProduct(Request $request){
        try {
            $deletRecord = AddToCart::where('product_id',$request->product_id)->delete();
            if($deletRecord){
                return response()->json(["success"=>true,"message"=>"product deleted successfully"]);
            }
           return response()->json(["success"=>false,"message"=>"product deleted failed"]);
        } catch (\Throwable $th) {
           return response()->json(["success"=>false,"message"=>$th->getMessage()]);
        }
    }
}
