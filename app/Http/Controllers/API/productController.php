<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Resources\ProductResource;
use App\Models\product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class productController extends BaseController
{

    function index(): JsonResponse
    {
        $products = product::all();

        return $this->sendResponse(ProductResource::collection($products), 'Products retrieved successfully.');
    }
    
    function store (Request $request){
       $validator = Validator::make($request->all(),[
                "title"=>"required",
                "body" =>"required"
        ]);
        if($validator->fails()){
            return $this->sendError("error",$validator->errors());
        }
        $user=$request->all();

       $product = product::create($user);
       
       return $this->sendResponse(new ProductResource($product), 'Product created successfully.');

    }

    function show($id){
       $product = product::find($id);
       
       
       if (is_null($product)) {

        return $this->sendError('Product not found.');
    }

    return $this->sendResponse(new ProductResource($product), 'Product retrieved successfully.');
}



function update( Request $request , product $product){
    
   $validator= validator::make($request->all(),[
        "title"=>"required",
        "body"=>"required"
    ]);
    
    if($validator->fails()){
        return $this->sendError('Validation Error.', $validator->errors());       
    }
    $input=$request->all();

    $product->title = $input['title'];
    $product->body = $input['body'];
    $product->save();

    return$this->sendResponse(new ProductResource($product), 'Product updated successfully.');
    }


 function destroy(product $product){
    
 
    $product->delete();

    return $this->sendResponse([], 'Product deleted successfully.');

   
    



}}