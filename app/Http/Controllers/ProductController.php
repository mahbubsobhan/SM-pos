<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    function ProductPage(){
        return view('pages.dashboard.product-page');
    }

    function CreateProduct(Request $request)
    {
        $user_id=$request->header('id');
 
        $img=$request->file('img');
        $t=time();
        $file_name=$img->getClientOriginalName();
        $img_name="{$user_id}-{$t}-{$file_name}";
        $img_url="uploads/{$img_name}";
      
        $img->move(public_path('uploads'),$img_name);

        return Product::create([
            'name'=>$request->input('name'),
            
            'price'=>$request->input('price'),
            'unite'=>$request->input('unite'),
            'img_url'=>$img_url,
            'category_id'=>$request->input('category_id'),
            'user_id'=>$user_id
        ]);
    }

        function DeleteProduct(Request $request)
        {
            $user_id=$request->header('id');
            $product_id=$request->input('id');
            $filePath=$request->input('file_path');
            File::delete($filePath);
            return Product::where('id',$product_id)->where('user_id',$user_id)->delete();
        }
        function ProductID(Request $request){
            $user_id = $request->header('id');
            $product_id = $request->input('id');
            return Product::where('id', $product_id)
                          ->where('user_id', $user_id)
                          ->first();
        }
        function ProductList(Request $request){
          $user_id = $request->header('id');
          return Product::where('user_id',$user_id)->get();

        }


        function ProductUpdate(Request $request){
            $user_id = $request->header('id');
            $product_id = $request->input('id');

            if ($request->hasFile('img')) {
                $img = $request->file('img');
                $t = time();
                $file_name = $img->getClientOriginalName();
                $img_name = "{$t}-{$file_name}";
                $img_url = "uploads/{$img_name}"; 
                //for uploads
                $img->move(public_path('uploads'),$img_name);
                //old img delete
                $filePath = $request->input('file_path') ;
                File::delete($filePath);
                //updateProduct
                return Product::where('id',$product_id)->where('user_id',$user_id)->update([
                    'name'=>$request->input('name'),
                    'price'=>$request->input('price'),
                    'unite'=>$request->input('unite'),
                    'img_url'=> $img_url,
                    'category_id' => $request->input('category_id')
                ]);
            } else{
                return Product::where('id',$product_id)->where('user_id',$user_id)->update([
                    'name'=>$request->input('name'),
                    'price'=>$request->input('price'),
                    'unite'=>$request->input('unite'),

                    'category_id' => $request->input('category_id')
                ]);  
            }
            

        } 
        


}
