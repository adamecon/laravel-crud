<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Models\User;

use App\Models\Product;

use App\Models\Cart2;

use App\Models\Order;

use Session;

use Stripe;

class HomeController extends Controller
{
    public function index() {

        $product=Product::paginate(9);
        return view('home.userpage', compact('product'));
    }
    public function redirect() {
        $usertype = Auth::user()->usertype;

        if($usertype=='1'){
            return view('admin.home');
        }
        else{
            $product=Product::paginate(9);
            return view('home.userpage', compact('product'));
        
        }
    }

    public function product_details($id){

        $product=product::find($id);
        return view('home.product_details', compact('product'));
    }

    public function add_cart(Request $request, $id){

        if(Auth::id()){
            
            $user=Auth::user();

            $product=product::find($id);

            $cart=new cart2;
            
            $cart->name=$user->name;
            $cart->email=$user->email;
            $cart->phone=$user->phone;
            $cart->address=$user->address;
            $cart->user_id=$user->id;

            $cart->product_title=$product->title;

            $cart->quantity=$product->quantity;


            if($product->discount_price!=null)
            {
                $cart->price=$product->discount_price * $request->quantity;
            }
            else{
                $cart->price=$product->price * $request->quantity;
            }
            
            $cart->product_id=$product->id;
            $cart->image=$product->image;

            $cart->save();

            return redirect()->back();
            




        }
        else{
            return redirect('login');
        }

    }
    public function show_cart(){

        if(Auth::id())
        {
        $id=Auth::user()->id;

        $cart=cart2::where('user_id','=',$id)->get();


        return view('home.show_cart', compact('cart'));
        }

        else{
            return redirect('login');
        }

        
    }

    public function remove_cart($id) {
        $cart=cart2::find($id);

        $cart->delete();

        return redirect()->back();
    }

    public function cash_order(){
        $user=Auth::user();

        $userid=$user->id;

        $data=cart2::where('user_id', '=', $userid)->get();

        foreach($data as $data)
        {
            $order = new order;

            $order->product_title=$data->product_title;
            $order->email=$data->email;
            $order->address=$data->address;
            $order->user_id=$data->user_id;
            $order->product_details=$data->product_title;
            $order->price=$data->price;
            $order->quantity=$data->quantity;
            $order->image=$data->image;
            $order->product_id=$data->product_id;

            $order->payment_status='cash on delivery';
            $order->delivery_status='processing';

            $order->save();


            $cart_id=$data->id;
            $cart=cart2::find($cart_id);





        }

        return redirect()->back()->with('message', 'Your Order Was Placed Successfully');
    }

    public function stripe($totalprice) {
        return view('home.stripe', compact('totalprice'));
    }

    public function stripePost($totalprice,Request $request )
    {
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
    
        Stripe\Charge::create ([
                "amount" => $totalprice * 100,
                "currency" => "usd",
                "source" => $request->stripeToken,
                "description" => "Test payment from itsolutionstuff.com." 
        ]);

        $user=Auth::user();

        $userid=$user->id;

        $data=cart2::where('user_id', '=', $userid)->get();

        foreach($data as $data)
        {
            $order = new order;

            $order->product_title=$data->product_title;
            $order->email=$data->email;
            $order->address=$data->address;
            $order->user_id=$data->user_id;
            $order->product_details=$data->product_title;
            $order->price=$data->price;
            $order->quantity=$data->quantity;
            $order->image=$data->image;
            $order->product_id=$data->product_id;

            $order->payment_status='Paid';
            $order->delivery_status='processing';

            $order->save();


            $cart_id=$data->id;
            $cart=cart2::find($cart_id);





        }
      
        return redirect()->back()->with('message', 'Payment Successful');
    }
}