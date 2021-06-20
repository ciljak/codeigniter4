<?php
/**
 * This code snipet calculate number of itmems in cart and calculate total price that is shown in upper part all pages 19.6.2021 
 */

   $_user_id = session()->get('id');
   $_number_of_items_in_cart ="0";
   $_total_price ="0";

   $db      = \Config\Database::connect();
   

   $builder = $db->table('order');
   $builder->select('*');
   $builder->join('eshop', 'eshop.id = order.product_id'); // join order and eshop table interconcet them by same product_id 'eshop.id = order.product_id'
   $builder->where(array('user_id', session()->get('id'))); //->orderBy('product_id', 'DESC');
   

   $cart = $builder->get()->getResultArray();


   // go through all returned records marked with user id as item in cart and calculate total number and price
   foreach ($cart as $cart_item) {
    $_total_price = $_total_price + $cart_item['total_price']*$cart_item['number_of_ordered_items']*(1+$cart_item['dph']/100);
    $_number_of_items_in_cart = $_number_of_items_in_cart + $cart_item['number_of_ordered_items'];
   }



echo '&nbsp;  &nbsp; &nbsp; &nbsp;  <span class="cart"> <a class="navbar-brand" href="/eshop/cart"> <img id="cart" src="/eshop_images/cart_icon.png" alt="cart small icon" width="35" height="35"><strong>(' .$_number_of_items_in_cart .')  ' .$_total_price .' € with VAT</strong></a> </span>';


?>


