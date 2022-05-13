window.axios = require('axios');

const appDomain = "https://coniq.test";



let customer_id = document.querySelector('#point');
customer = customer_id.dataset.customer;

    let product_id = document.querySelector('#product_id');

    product_cart_id = parseInt(product_id.dataset.id);
                let total_point = document.getElementsByClassName("payment-due__currency")[0].innerText;


                let currency = document.getElementsByClassName("payment-due__price")[0].innerText;
                let new_price = currency.split(total_point);
                //console.log(new_price);
                 let price_change =    parseInt(new_price[1]);

                 let price = price_change.toFixed(2);

    axios.post(appDomain+'/api/showDiscount', {customer_id: customer,product_id:product_cart_id,price:price})
        .then(function (response){

                console.log(response);
                var curr_balance = response.data[0][0].current_balance;
                let rule_id = response.data[3][0].rule_id;
                let barcode = response.data[1][0].barcode_number;
                let offer_id = response.data[1][0].offer_id;
                if(curr_balance >=10000){
                    var point_value = 10000;
                }else if(curr_balance<=9999){
                    var point_value = 5000;
                }
                var voucher_worth = parseFloat(point_value)/100;
                let total_points = document.getElementById("total_points");
                let total_point = document.getElementsByClassName("payment-due__currency")[0].innerText;
                let qty = document.getElementsByClassName("product-thumbnail__quantity")[0].innerText;
                let quantity= parseInt(qty);

                let currency = document.getElementsByClassName("payment-due__price")[0].innerText;
                let new_price = currency.split(total_point);
                //console.log(new_price);
                 let price_change =    parseInt(new_price[1]);
                 console.log(typeof(price_change));
                 let price = price_change.toFixed(2);

                let test = document.getElementById("test");
                let metadata = document.getElementById('mydata')
                test.innerHTML = "<form><input type='hidden' id='barcode' name='barcode' value="+barcode+" /><input type='hidden' id='offer_id' name='offer_id' value="+offer_id+" /></form>";
                metadata.innerHTML += "<input id='rule' data-role="+rule_id+" type='checkbox' value="+point_value+" /><span> Redeem <b>"+point_value+ "</b> for a<span > <br/><span class='voucher'>voucher worth <b>"+voucher_worth.toFixed(2)+"</b></span";
                total_points.innerHTML = "You have "+curr_balance+" points";
                var checkbox = document.querySelector("#rule");

                checkbox.addEventListener("click", displayChecks);
                  function displayChecks(e) {
                    if (e.target.checked) {
                        console.log(response);
                        let rule_id_value = e.target.value;
                        let rule_id = response.data[3][0].rule_id;
                        let tier = response.data[0][0].tier.label;
                        console.log(tier);
                        // let cart_price = document.getElementById('end-price').innerText;
                        // let split = cart_price.split("Rs. ");
                        // var split_amont = parseFloat(split[1]);
                        // let cart_total_price = parseFloat(cart_price);


                        let total_points = document.getElementById("total_points");
                        let total_point = document.getElementsByClassName("payment-due__currency")[0].innerText;
                        let qty = document.getElementsByClassName("product-thumbnail__quantity")[0].innerText;
                        let quantity= parseInt(qty);

                        let currency = document.getElementsByClassName("payment-due__price")[0].innerText;
                        let new_price = currency.split(total_point);
                        //console.log(new_price);
                        let price_change =    parseInt(new_price[1]);
                        let varient_id = document.querySelector('.product');

                        varient = parseInt(varient_id.dataset.variantId);
                        console.log(varient);
                        let price = price_change.toFixed(2);
                        let product_title = document.getElementsByClassName("product__description__name")[0].innerText;
                        console.log(product_title);
                        const product_id = document.querySelector('#product_id');
                        product_cart_id = parseInt(product_id.dataset.id);

                        let offers = document.getElementById("offer_remain");
                        let tiers = document.getElementById("tier");
                        let point = document.getElementById("point").value;
                        let current_balance = document.getElementById("current_balance");
                         let new_balance = curr_balance-point_value;
                         var barcode = document.querySelector('#barcode').value;
                         var offer_id = document.querySelector('#offer_id').value;
                        //  let checkouturl =  response.data[1].draft_order.invoice_url;
                        //  let checkout_url = document.getElementById("checkout").setAttribute('href',checkouturl);
                        current_balance.innerHTML = "Current point balance :<b>"+curr_balance+"</b><br/>";
                        offers.innerHTML = "New point balance :<b>"+new_balance.toFixed(2)+"</b>";
                        tiers.innerHTML = "You are in <b>"+tier+"</b><br/>";
                        let discount = response.data[3][0]['discount_amount'];
                        axios.post(appDomain+'/api/subtotal', {ruleid:rule_id,quantity:quantity,product_id:product_cart_id,title:product_title,price:price_change,varient:varient,discount:discount})
                        .then(function (response){
                            let checkouturl = response.data.draft_order.invoice_url;
                            axios.post(appDomain+'/api/transactionData', {ruleid:rule_id,product_id:product_cart_id,quantity:quantity,price:price_change,barcode:barcode,offer_id:offer_id})
                            .then(function (response){
                                console.log(response);
                                window.location.href = checkouturl;
                               // price.innerHTML = split_amont;
                            });
                           // let checkout_url = document.getElementById("checkout").setAttribute('href',checkouturl);

                           // console.log(checkouturl);
                            //alert(checkouturl);
                            console.log(response.data.draft_order.invoice_url);
                           // price.innerHTML = split_amont;
                        });
                    }else{
                        console.log("Please check checkbox");
                        //let element1 = document.getElementById("rule1");
                        // let element0 = document.getElementById("rule0");
                        // element0.removeAttribute("disabled",'');
                        //var redeemvalue = document.getElementById("point").setAttribute('value',e.target.value);
                    }
                }


        })

        .catch( error => {
            console.log("ERROR: ", error);
        });
        var checkout = document.querySelector("#continue_button");


            checkout.addEventListener("click", function(){

                let total_point = document.getElementsByClassName("payment-due__currency")[0].innerText;
                let qty = document.getElementsByClassName("product-thumbnail__quantity")[0].innerText;
                let quantity= parseInt(qty);

                let currency = document.getElementsByClassName("payment-due__price")[0].innerText;
                let new_price = currency.split(total_point);

                 let price_change =    new_price[1];
                 //console.log(price_change);
                // var floatValue = +(price_change.replace(/,/,'.'));
                var price =  parseFloat(price_change.replace(/,/g, ''))
                //console.log(typeof(a));
                // let price = price_change.toFixed(2);



                // let end_price = document.getElementById("end-price").innerText;
                // var qty =  document.getElementById("cart_quantity").value;
                //console.log(end_price);

               // var parseqty = parseInt(qty);
               // let split = end_price.split("Rs. ");
              //  var split_amont = parseInt(split[1]);
                //let checkBox = document.getElementById("rule");
              //  let checkBox1 = document.getElementById("rule1");
                // if(checkBox.checked ==true){
                   // var ruleid = checkBox0.value;
                    var ruleid = document.querySelector('#rule');
                    var rule_id = ruleid.dataset.role;
                    var product_id = document.querySelector('#product_id');
                 product_cart_id = parseInt(product_id.dataset.id);
                 var barcode = document.querySelector('#barcode').value;
                 var offer_id = document.querySelector('#offer_id').value;
                    //console.log(offer_id);
               // }

                axios.post(appDomain+'/api/transactionData', {ruleid:rule_id,product_id:product_cart_id,quantity:quantity,price:price,barcode:barcode,offer_id:offer_id})
                .then(function (response){
                    console.log(response);
                   // price.innerHTML = split_amont;
                });

        });

// guest login
// var guest_login = document.querySelector("#guest_login");
// guest_login.addEventListener("click", guestChecks);
//                   function guestChecks(response) {
//                     let email = document.getElementById('email').value;
//                     axios.post(appDomain+'/api/guestlogin', {email: email})
//                     .then(response => {
//                         console.log("Response: ", response);
//                     })
//                     .catch( error => {
//                         console.log("ERROR: ", error);
//                     });
//                 }





// end guest login
//     axios.post(appDomain+'/api/addDiscount', {customer_id: customer})
//         .then(response => {
//             console.log("Response: ", response);
//         })
//         .catch( error => {
//             console.log("ERROR: ", error);
//         });

// function removeDiscount(customer) {

//     console.log("hiiiiiiiiiii");
//     axios.post(appDomain+'/api/removeDiscount', {customer_id: customer })
//     .then(response => {
//         console.log("Response: ", response);
//     })
//     .catch( error => {
//         console.log("ERROR: ", error);
//     });
//         }



//        getDiscount();


//         let logoutButton = document.querySelector('.logout');
//         console.log(logoutButton);
//         logoutButton.addEventListener('click', function(){
//             console.log("hiiii");
//             removeDiscount(customer);
//         });
//         if(discountButton) {
//             let customer = discountButton.dataset.customer;
//         }
// checkDiscount(customer);


        // cookie

