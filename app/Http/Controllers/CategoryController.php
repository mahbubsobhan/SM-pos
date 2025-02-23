<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
   function CategoryPage(){
    return view('pages.dashboard.category-page');
   }

   function CategoryList(Request $request){
      $user_id = $request->header('id');
      return Category::where('user_id',$user_id)->get();
} 
   function CategoryCreate(Request $request){
    $user_id = $request->header('id'); 
    return Category::create([
      'name'=>$request->input('name'),
      'user_id'=> $user_id
    ]) ;
   }

   function CategoryDelete(Request $request) {
      $user_id = $request->header('id');   // ব্যবহারকারীর আইডি সংগ্রহ
      $category_id = $request->input('id'); // ক্যাটাগরি আইডি সংগ্রহ
     
      // শর্ত অনুযায়ী ক্যাটাগরি মুছে ফেলা
      return Category::where('id', $category_id) // ক্যাটাগরি টেবিল থেকে 'id' এবং 'user_id' এর শর্ত মিলিয়ে
                     ->where('user_id', $user_id) // নির্দিষ্ট রেকর্ডটি নির্বাচন করা হবে
                     ->delete(); // নির্বাচিত রেকর্ডটি মুছে ফেলা হবে এবং অপারেশনের সফলতা বা ব্যর্থতা রিটার্ন করবে
  }
   function CategoryById(Request $request) {
      $category_id = $request->input('id'); // ক্যাটাগরি আইডি সংগ্রহ
      $user_id = $request->header('id');   // ব্যবহারকারীর আইডি সংগ্রহ
  
      // শর্ত অনুযায়ী ক্যাটাগরি মুছে ফেলা
      return Category::where('id', $category_id) // ক্যাটাগরি টেবিল থেকে 'id' এবং 'user_id' এর শর্ত মিলিয়ে
                     ->where('user_id', $user_id) // নির্দিষ্ট রেকর্ডটি নির্বাচন করা হবে
                     ->first(); // নির্বাচিত রেকর্ডটি মুছে ফেলা হবে এবং অপারেশনের সফলতা বা ব্যর্থতা রিটার্ন করবে
  }
  
   function CategoryUpdate(Request $request) {
    $category_id = $request->input('id'); // ক্যাটাগরি আইডি সংগ্রহ
    $user_id = $request->header('id');   // ব্যবহারকারীর আইডি সংগ্রহ

    return Category::where('id', $category_id) // ক্যাটাগরি টেবিলে 'id' এর মান খুঁজে বের করা
                   ->where('user_id', $user_id) // এবং 'user_id' এর মান মেলানো
                   ->update([
                       'name' => $request->input('name') // 'name' ফিল্ডটি নতুন মান দিয়ে আপডেট করা
                   ]);
                                    }
   }
