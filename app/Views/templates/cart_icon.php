<?php
/**
 * This code snipet calculate number of itmems in cart and calculate total price that is shown in upper part all pages 19.6.2021 
 */

   $_user_id = session()->get('id');
   $_number_of_items_in_cart ="0";
   $_total_price ="0";

   $db      = \Config\Database::connect();
   $builder = $db->table('eshop');

   //$builder->selectMax('id');
   $builder->where('user_cart', $_user_id );

   $cart = $builder->get()->getResultArray();


   // go through all returned records marked with user id as item in cart and calculate total number and price
   foreach ($cart as $cart_item) {
    $_total_price = $_total_price + $cart_item['product_price'];
    $_number_of_items_in_cart = $_number_of_items_in_cart + 1;
   }



echo '&nbsp;  &nbsp; &nbsp; &nbsp;  <span class="cart"> <a class="navbar-brand" href="/eshop/cart"> <img id="cart" src="/eshop_images/cart_icon.png" alt="cart small icon" width="35" height="35"><strong>(' .$_number_of_items_in_cart .')  ' .$_total_price .' €</strong></a> </span>';


?>


