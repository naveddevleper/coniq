<?php

namespace App\Http\Controllers;

use App\Discount;
use App\Helpers\Shopify;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Session;

class DiscountController extends Controller
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Discount::updateOrCreate($request->all());
        return "Success";
        //return $request->customer_id;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {

        // $users = DB::table('discounts')->select('id','customer_id')->get();
        // $array = json_decode(json_encode($users), true);
        // foreach($array as $arrays){
        // $customer_id =  $arrays['customer_id'];

        // }
        $request_body = file_get_contents('php://input');
        $data = json_decode($request_body);
        $customer_id = $data->customer_id;
        $product_ids = $data->product_id;
        $price = $data->price;
        $api_key = '6aaebd044fe0ac5aa15a5680df68096d';
        $access_token = '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';
       $url = 'https://'.$api_key.':'.$access_token.'@maison7.com/admin/customers.json';

    //    $customers = json_decode(file_get_contents('https://6aaebd044fe0ac5aa15a5680df68096d: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@apartment-51-me.myshopify.com/admin/api/2021-10/customers/'.$customer_id.'.json'),true);
    // //    $custome_length = count($customers['customers']);
    // //    for($i=0;$i<$custome_length;$i++){
    // //     $customer_admin_id = $customers['customers'][$i]['id'];
    // //     $customer_admin_email = $customers['customers'][$i]['email'];
    // // // echo "<pre>";   print_r($customer_admin_id);
    // //    }

    //    $orders = json_decode(file_get_contents('https://6aaebd044fe0ac5aa15a5680df68096d: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@apartment-51-me.myshopify.com/admin/api/2021-10/draft_orders.json'),true);
        $data = array();
    //    $data[] = $orders;

    //    $length = count($data[0]['draft_orders']);
    //   // $id = $data[0]['draft_orders'][0]['id'];
    //    $id = 888094130359;
    // //    for($i=0;$i<$length;$i++) {
    // //     $product_id = $data[0]['draft_orders'][$i]['line_items'][0]['product_id'];
    // //     if($product_ids == $product_id){
    // //      $id = $data[0]['draft_orders'][$i]['id'];
    // //     }
    // // }
    // $draft_orders = json_decode(file_get_contents('https://6aaebd044fe0ac5aa15a5680df68096d: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@apartment-51-me.myshopify.com/admin/api/2021-10/draft_orders/'.$id.'.json'),true);
    // $data[] = $draft_orders;
    // //$price = $data[1]['draft_orders'][0]['line_items'][0]['price'];
    // $price = $data[1]['draft_order']['line_items'][0]['price'];
    //     //    $amount = floor($price * $quantity * $value) / 100;

    $shopify = new Shopify();
    $customerData =  $shopify->apikey('https://api-stage.coniq.com/subscription?customer_email=Test501%40test.com&offer_id=45038')->json();
      // https://api-stage.coniq.com/subscription?customer_email=Test501%40test.com&offer_id=45038
    $data[] = $customerData;
    $customerBarcode =  $shopify->apikey('https://api-stage.coniq.com/barcode?customer_email=Test501%40test.com')->json();
    $data[] = $customerBarcode;
    $barcode = $data[1][0]['barcode_number'];
    $offer_id = $data[1][0]['offer_id'];

    $headers = [
        // 'Authorization' => 'ApiKey key="256cf8a09ffccb2fc7b88fc9689b52df1d377c42"',
        'Authorization' => 'ApiKey key="222a4fb9733e434ed9e2199ef5ce2160dba8f860"',
        'Content-type'=> 'application/json',
        'x-api-version' =>'2.0'
    ];
    $availblity_rule =  Http::withHeaders($headers)->post('https://api-stage.coniq.com/transaction/availableRules',
    [
     'barcode'=>$barcode,
     'location_id' => '89677',
     'offer_id' => $offer_id,
    'amount' => $price
    ])->json();
    $data[] = $availblity_rule;

      // $price = $data[0]['draft_orders'][0]['line_items'][0]['price'];
       $length = count($data[2]['spend_voucher_rules']);
       $value = $data[2]['spend_voucher_rules'];
       $sort = array();
       foreach($value as $k=>$v) {
          $sort['points_required'][$k] = $v['points_required'];
          $sort['rule_id'][$k] = $v['rule_id'];
       }
       # It is sorted by event_type in descending order and the title is sorted in ascending order.
       array_multisort($sort['rule_id'], SORT_ASC, $sort['points_required'], SORT_ASC,$value);
       $data[] = $value;

        return $data;

    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function edit(Discount $discount)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Discount $discount)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //return $_REQUEST;

        $item = Discount::where('customer_id', $request['customer_id'])->first();

        return Discount::destroy($item->id);

    }

    public function check(Request $request) {

        $item = Discount::where('customer_id', $request['customer_id'])->first();
        if($item){
            return 1;
        }else{
            return 0;
        }
    }

    public function transaction(Request $request) {
        $request_body = file_get_contents('php://input');
        $data = json_decode($request_body);
        $ruleid = $data->ruleid;
        $product_id = $data->product_id;
        $quantity = $data->quantity;
        $price = $data->price;
        $barcode = $data->barcode;
        $offer_id = $data->offer_id;

        $redeem_date = date('Y-m-d\TH:m:s+ZZZZ');
        //print_r($data);
        $data = array();
        // $orders = json_decode(file_get_contents('https://74102073861389c9073c42f88521e4ae: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@coniq-app.myshopify.com/admin/api/2021-10/draft_orders.json'),true);
        // $data = array();
        // $data[] = $orders;
        // $length = count($data[0]['draft_orders']);

        // //amount = floor(price * quantity * value) / 100
        // for($i=0; $i < $length;$i++){
        //     $id = $data[0]['draft_orders'][$i]['id'];
        //    // $amount =  $data[0]['draft_orders'][$i]['applied_discount']['value'];
        //     $price = $data[0]['draft_orders'][$i]['line_items'][0]['price'];
        //     $quantity = $data[0]['draft_orders'][$i]['line_items'][0]['quantity'];
        //     $value =  $data[0]['draft_orders'][$i]['applied_discount']['value'];
        //     $amount = floor($price * $quantity * $value) / 100;
        //    // $quantity =
        // }
        // $orders = json_decode(file_get_contents('https://74102073861389c9073c42f88521e4ae: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@coniq-app.myshopify.com/admin/api/2021-10/draft_orders.json'),true);

       //print_r($amount);exit;
        // if($customer_admin_id == $customer_id){
             $headers = [
                 // 'Authorization' => 'ApiKey key="256cf8a09ffccb2fc7b88fc9689b52df1d377c42"',
                 'Authorization' => 'ApiKey key="222a4fb9733e434ed9e2199ef5ce2160dba8f860"',
                 'Content-type'=> 'application/json',
                 'x-api-version' =>'2.0'
             ];


          $verify_trasaction =  Http::withHeaders($headers)->post('https://api-stage.coniq.com/verify-transaction',
                [
                 'barcode'=>$barcode,
                'location_id' => '89677',
                'amount' => $price,
                'offer_id' =>$offer_id,
                'type' =>'spend',
                 "rule" => $ruleid,
                 "date_redeemed"=>$redeem_date
                ])->json();
        $data[] = $verify_trasaction;
        $create_transaction =  Http::withHeaders($headers)->post('https://api-stage.coniq.com/create-transaction',
             [
              'barcode'=>$barcode,
             'location_id' => '89677',
             'amount' => $price,
             'offer_id' =>$offer_id,
             'type' =>'spend',
             "rule" => $ruleid,
             "date_redeemed"=> $redeem_date
             ])->json();




        $data[] = $create_transaction;
      // echo "<pre>";  print_r($data);exit;

         return $data;

    }
    public function subtotal(Request $request) {
        $request_body = file_get_contents('php://input');
        $data = json_decode($request_body);

        $store_price =$data->ruleid;
        $product_id = $data->product_id;
        $quantity = $data->quantity;
        $title = $data->title;
        $discount = $data->discount;
        $varient = $data->varient;
        $price = $data->price;
       // print_r($data);
        $api_key = '74102073861389c9073c42f88521e4ae';
        $access_token = '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';
       // $data = array();
    //     $ids = 888094130359;
    //     $orders = json_decode(file_get_contents('https://6aaebd044fe0ac5aa15a5680df68096d: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@apartment-51-me.myshopify.com/admin/api/2021-10/draft_orders/'.$ids.'.json'),true);
    //     $data = array();
    //     $data[] = $orders;

    //     // $length = count($data[0]['draft_orders']);
    //     // for($i=0;$i<$length;$i++) {

    //     //     $product_id = $data[0]['draft_orders'][$i]['line_items'][0]['product_id'];
    //     //     if($product_ids == $product_id){
    //           echo  $id = $data[0]['draft_order']['line_items'][0]['id'];
    //           $varient_id = $data[0]['draft_order']['line_items'][0]['variant_id'];
    //           $product_id = $data[0]['draft_order']['line_items'][0]['product_id'];
    //                  $title = $data[0]['draft_order']['line_items'][0]['title'];
    // //     //     }else{
    // //     //         echo "NOt Matched Product Id";
    // //     //     }
    // //     // }


    //   //  echo "<pre>";print_r($data);exit;

         $body = [

                 "draft_order" => array(
                    "applied_discount" =>array (
                        "value_type"=>"fixed_amount",
                        "value" => $discount

                    ),
                         "line_items" => [array(
                            //  "id"=> $id,
                             "variant_id"=> $varient,
                             "product_id"=> $product_id,
                             "title"=>$title,
                             "price" =>$price,
                             "quantity"=>$quantity

                 )])

                         ];
                         $key = [
                            $api_key => '6aaebd044fe0ac5aa15a5680df68096d',
                            $access_token=> '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'

                        ];
                        //  print_r($body);
          $discount_order = Http::withHeaders($key)->post('https://6aaebd044fe0ac5aa15a5680df68096d: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@apartment-51-me.myshopify.com/admin/api/2021-10/draft_orders.json',
          $body,true);
          $data = new Discount();
          $data->draft_id = $discount_order['draft_order']['id'];
          $data->email = $discount_order['draft_order']['email'];
          $data->save();
          $id = $data->draft_id;
          $orders_data = json_decode(file_get_contents('https://6aaebd044fe0ac5aa15a5680df68096d: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@apartment-51-me.myshopify.com/admin/api/2021-10/draft_orders/'.$id.'.json'),true);

            //  $data[] = $discount_order;
          return $orders_data;
   // return $data;
}
public function verify_webhook($data, $hmac_header)
    {
        $shopify_app_secret = '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';
        $calculated_hmac = base64_encode(hash_hmac('sha256', $data, $shopify_app_secret, true));
        return ($hmac_header == $calculated_hmac);
    }

public function customerUpdate(Request $request) {
    $request_body = file_get_contents('php://input');
    $data = json_decode($request_body,true);
   // print_r($data);
    //$email = $data->reg_email;
    $fname = $data['fname'];
    $lname = $data['lname'];
    $reg_email = $data['reg_email'];
    $pass = $data['password'];
    $flag_email = $data['flag_email'];
    $flag_sms = $data['flag_sms'];
    $flag = $data['checkbox'];
    $pass_length = strlen($pass);
    //echo $pass_length;

    $data = array();

    $api_key = '6aaebd044fe0ac5aa15a5680df68096d';
    $access_token = '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';
    $url = 'https://'.$api_key.':'.$access_token.'@apartment-51-me.myshopify.com/admin/customers.json';

    $customers = json_decode(file_get_contents($url),true);
    $data[] = $customers;

    //print_r($data);
    $length = count($data[0]['customers']);
    for($i=0;$i<$length;$i++){
         $email[] = $data[0]['customers'][$i]['email'];

    }
if($fname!='' || $lname!='' || $reg_email!='' || $pass!=''){

    if($pass_length < 6){
        echo "passsword length sould be atleast 6 character";
    }
    else if (in_array($reg_email, $email))
    {
    echo "Match found";
    }
    else
    {
        $headers = [
            // 'Authorization' => 'ApiKey key="256cf8a09ffccb2fc7b88fc9689b52df1d377c42"',
            'Authorization' => 'ApiKey key="222a4fb9733e434ed9e2199ef5ce2160dba8f860"',
            'Content-type'=> 'application/json',
            'x-api-version' =>'2.0'
        ];


     $signup_data =  Http::withHeaders($headers)->post('https://poweredby-stage.coniq.com/signup/0e5gc1s.json',
           [
            "fields"=> array(
            'email' => $reg_email,
            'first_name'=>$fname,
            'last_name'=>$lname,
            "marketing_agreement"=>$flag,
                "marketing_channels" =>array(
                    "email" =>$flag_email,
                    "sms" => $flag_sms
                )
            )
           ])->json();

          print_r($signup_data);

        }
    }
    else{
        echo "All field required";
    }
   // print_r($length);

    return $data;


   }

   public function guestLogin() {
    $request_body = file_get_contents('php://input');
    $data = json_decode($request_body,true);
    $email = $data['email'];
    Session::put('hello', "hello");
    //print_r($data);

    return $data;
   }


}
