<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        try {
             $validator = Validator::make($request->all(),[
                'name'           => 'required|string|max:255',
                'price'=>'required|digits_between:1,9999',
                'image'=>'required|image|mimes:jpeg,png,jpg,gif|max:2048',
             ]);
             if($validator->fails()){
                    return response().json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors'  => $validator->errors()
                  ]);
                }

              $uploadPath = public_path('uploads');
              $imageName='';
              if ($request->file('image')) {
                    $imageName = time() . '.' . $request->image->extension();
                    $request->image->move($uploadPath, $imageName);
              }
              $products = Products::create([
                "name"=>$request->name,
                "price"=>$request->price,
                "image"=>'uploads/'.$imageName
              ]);
              return response()->json([
                "success"=>true,
                "messgae"=>"Product created successfully",
                'user'         => $products,
            ]);

        } catch (\Throwable $th) {
             return response()->json([
                "success"=>true,
                "messgae"=>$th->getMessage(),
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function show(Products $products)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function edit(Products $products)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Products $products)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function destroy(Products $products)
    {
        //
    }
    public function craftedProducts(Request $request){
        try {
            $craftedProducts = Products::take('3')->get();
            return response()->json(['success'=>true,'message'=>"products fetched successfully",'results'=>$craftedProducts]);
        } catch (Exception  $exception) {
            return response()->json(['success'=>false,'message'=>$exception->getMessage()]);
        }
    }
    public function addToCart(Request $request){
      dd("fdfdfdf");
    }
}
