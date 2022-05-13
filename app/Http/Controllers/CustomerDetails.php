<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Shopify;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerDetails extends Controller
{

    function customer(Request $request)
    {
        $shop = Auth::user();
         $orders = json_decode(file_get_contents('https://74102073861389c9073c42f88521e4ae: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@coniq-app.myshopify.com/admin/api/2021-10/draft_orders.json'),true);
        foreach($orders as $order)
        {
             $price = $order[0]['line_items'][0]['price'];
             $qty = $order[0]['line_items'][0]['quantity'];
            $value = $order[0]['applied_discount']['value'];
         //echo "<pre>";   print_r($order);
        }
        $amount = floor($price * $qty * $value) / 100;
        echo $amount;
        $users = DB::table('discounts')->select('id','customer_id')->get();
        $array = json_decode(json_encode($users), true);
        foreach($array as $arrays){
        $customer_id =  $arrays['customer_id'];
        }
        $headers = [
            // 'Authorization' => 'ApiKey key="256cf8a09ffccb2fc7b88fc9689b52df1d377c42"',
            'Authorization' => 'ApiKey key="222a4fb9733e434ed9e2199ef5ce2160dba8f860"',
            'Content-type'=> 'application/json',
            'x-api-version' =>'2.0'
        ];


       // $current_email = $request->body->customer->email;
       // $data =  Shopify::apikey('https://api-stage.coniq.com/subscription?customer_email=madhu.giridharan%2Btest9707%40coniq.com&offer_id=41311')->json();
        $client = new Shopify();
    //    $get_script = $client->get('/admin/script_tags.json');
     //print_r($get_script);exit;
      //  $snippet = "https://boisterous-hamster-337d2c.netlify.app/js/main.js";
    //     $scripts_array = array(
    //                 'script_tag' => array(
    //                     'event' => 'onload',
    //                     'src' => $snippet
    //                 )
    //             );
    //    // $scripts_array = array('script_tag' => array('event' => 'onload', 'src' => $snippet));
    //     $scripts = $client->put('/admin/script_tags/186300498104.json', $scripts_array);

   $customerData =  Http::withHeaders($headers)->get('https://api-stage.coniq.com/subscription?customer_email=iain%2Enimmo%2Bcustomer%40coniq.com&offer_id=45038')->json();
      //  $customerData =  Shopify::apikey('https://api-stage.coniq.com/subscription?customer_email=iain%2Enimmo%2Bcustomer%40coniq.com&offer_id=45038')->json();
       // print_r($withHeaders);exit;
            //return view('profile',['data'=>$scripts]);
        $offer_id = $customerData[0]['offer_id'];
       echo "current balance ".$current_balance = $customerData[0]['current_balance']."<br/>";
       echo "lifetime balance ".$lifetime_balance = $customerData[0]['lifetime_balance']."<br/>";
        $tier = $customerData[0]['tier'];
       echo "tier label ".$tiear_lable = $tier['label']."<br/>";




      // amount = floor(price * quantity * value) / 100;
        //$customer_offer = array_column($customerData,'offer_id');
       // $offer_details =  Shopify::apikey('https://api-stage.coniq.com/offer/'.$offer_id)->json();
       //   echo "<pre>";  print_r($offer_details);

        // $customers = $client->get('/admin/customers.json');
        // echo "<pre>"; print_r($customers);
        // foreach($customers as $customer){
        //    $mail = array_column($customer,'email');

        //  //  $data =  Shopify::apikey('https://api-stage.coniq.com/subscription?customer_email='. $mail .'&offer_id=41311')->json();
        //  //  echo "<pre>"; print_r($mail);
        //    if(in_array('navedahamad2016@gmail.com',$mail)){
        //     //   echo "success";
        //    }
        //    else{
        //        echo "fail";
        //    }
        return $customerData;
        }

       // return view('profile',['data'=>$data]);
    }

    // function customerid()
    // {
    //     $client = new Shopify();
    //     $snippet = "public/js/script.js";
    //     $scripts_array = array('script_tag' => array('event' => 'onload', 'src' => $snippet));
    //     $scripts = $client->post('/admin/script_tags.json',$scripts_array);
    //     print_r($scripts);
    // }


