<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Invoice;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\InvoiceProduct;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Barryvdh\DomPDF\Facade\Pdf;

use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Facades\Redis;

class InvoiceController extends Controller
{
    public function InvoicePage(): View
    {
        return view('pages.dashboard.invoice-page');
    }

    public function SalePage(): View
    {
        return view('pages.dashboard.sale-page');
    }

    function invoiceCreate(Request $request){

        DB::beginTransaction();

        try {

        $user_id=$request->header('id');
        $total=$request->input('total');
        $discount=$request->input('discount');
        $vat=$request->input('vat');
        $payable=$request->input('payable');

        $customer_id=$request->input('customer_id');

        $invoice= Invoice::create([
            'total'=>$total,
            'discount'=>$discount,
            'vat'=>$vat,
            'payable'=>$payable,
            'user_id'=>$user_id,
            'customer_id'=>$customer_id,
        ]);


       $invoiceID=$invoice->id;

       $products= $request->input('products');

       foreach ($products as $EachProduct) {
            InvoiceProduct::create([
                'invoice_id' => $invoiceID,
                'user_id'=>$user_id,
                'product_id' => $EachProduct['product_id'],
                'qty' =>  $EachProduct['qty'],
                'sale_price'=>  $EachProduct['sale_price'],
            ]);
        }

       DB::commit();

       return 1;

        }
        catch (Exception $e) {
            DB::rollBack();
            return 0;
        }

    }

    function invoiceSelect(Request $request){
       $user_id = $request->header('id');
       return Invoice::where('user_id',$user_id)->with('customer')->get();
    }

    
    function InvoiceDetails(Request $request){
        
        $user_id = $request->header('id');

        $customerDetails = Customer::where('user_id',$user_id)
                                     ->where('id',$request->input('cus_id'))
                                    ->first();

        $invoiceTotal = Invoice::where('user_id','=',$user_id)
                                       ->where('id',$request->input('inv_id'))
                                       ->first();
        $invoiceProduct = InvoiceProduct::where('invoice_id',$request->input('inv_id'))
                                      ->where('user_id',$user_id)->with('product')
                                      ->get();

        return array(
            'customer'=>$customerDetails,
            'invoice'=>$invoiceTotal,
            'product'=>$invoiceProduct,
        );
    }

   
    public function invoiceDelete(Request $request) {
        DB::beginTransaction();
        
        try {
            // লগইন করা ইউজারের তথ্য আনছি
            $user_id = $request->header('id');
            $password = $request->input('password');
    
            // ইউজারের তথ্য ডাটাবেজ থেকে বের করা
            $user = User::find($user_id);
    
            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'User not found!'
                ]);
            }
    
            // পাসওয়ার্ড যাচাই করা (hash ছাড়া সরাসরি চেক করা)
            if ($password !== $user->password) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Incorrect password!'
                ]);
            }
    
            // ইনভয়েস খুঁজে বের করা
            $invoice = Invoice::where('id', $request->input('inv_id'))
                              ->where('user_id', $user_id)
                              ->first();
    
            if (!$invoice) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invoice not found!'
                ]);
            }
    
            // InvoiceProduct ডিলিট করা
            InvoiceProduct::where('invoice_id', $invoice->id)
                ->where('user_id', $user_id)
                ->delete();
    
            // Invoice ডিলিট করা
            $invoice->delete();
    
            DB::commit();
    
            return response()->json([
                'status' => 'success',
                'message' => 'Invoice deleted successfully!'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong!',
                'error' => $e->getMessage()
            ]);
        }
    }
    

    public function generatePDF(Request $request)
{
    $cus_id = $request->input('cus_id');
    $inv_id = $request->input('inv_id');

    // Invoice ডাটা বের করা
    $invoice = Invoice::with('customer', 'products')->where('id', $inv_id)->first();

    if (!$invoice) {
        return response()->json(['error' => 'Invoice not found'], 404);
    }

    // PDF বানানোর জন্য view ব্যবহার করা
    $pdf = Pdf::loadView('invoice-pdf', compact('invoice'));

    // PDF ফাইল সেভ করা
    $fileName = 'invoice_' . $inv_id . '.pdf';
    $pdfPath = public_path('pdfs/' . $fileName);
    $pdf->save($pdfPath);

    return response()->json([
        'pdf_url' => asset('pdfs/' . $fileName),
        'customer_email' => $invoice->customer->email,
        'customer_phone' => $invoice->customer->phone
    ]);
}


    public function sendEmailWithPDF(Request $request)
    {
        $email = $request->input('email');
        $pdfPath = $request->input('pdf_url');

        Mail::raw('Please find attached your invoice.', function ($message) use ($email, $pdfPath) {
            $message->to($email)
                    ->subject('Your Invoice')
                    ->attach($pdfPath);
        });

        return response()->json(['message' => 'Email sent successfully']);
    }
    
}

