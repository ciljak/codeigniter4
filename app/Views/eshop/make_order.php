<!-- cart.php is responsible for display of items selected by appropriate visitor of webpage -->
<section>
    <img src="/eshop_images/main_cart_image.png" alt="main_eshop_logo" height="150px"> <br><br>
  	
    <h1 class="main_h1"><?= esc($title) ?></h1>

    <h2>In next part we are going through all necessary steps needed to fullfil your order.</h2>

    <br>
   
    <fieldset>
        <legend>I. List of ordered items</legend>
    <?php if (! empty($eshop) && is_array($eshop)) : ?>
       <table class="cart_table">
           <tr class="cart_table">
             <th>Product name</th>
             <th>Product category/subcategory</th>
             <th>Photo</th>
             <th>VAT %</th>
             <th>Price per item</th>
             <th>Nr. of items</th>
             <th>Item price</th>
             <th>Options to do</th>
          </tr>
            <?php 
            $total_price = 0;
            $calculated_price_with_DPH = 0;
            foreach ($eshop as $eshop_item): ?>
                <tr class="cart_table">
                    <td><?php echo $eshop_item['product_name'] ?></td>
                    <td><?php echo $eshop_item['product_category']."/". $eshop_item['product_subcategory'] ?></td>
                    <td><img src="/eshop_images/<?php echo $eshop_item['picture_name_1'] ?>" alt="<?php echo $eshop_item['product_name'] ?>" height="80px"></td>
                    <td><?php echo $eshop_item['dph'] ?>%</td>
                    <td><?php echo number_format($eshop_item['product_price'], 2, ',', ' ') ?>€</td> 
                    <td><?php echo $eshop_item['number_of_ordered_items'] ?></td>
                    <td><?php echo number_format($eshop_item['product_price']*$eshop_item['number_of_ordered_items'], 2, ',', ' ') ?>€</td>

                    <td><a href="<?php echo base_url('eshop/remove_from_cart_return_to_cart/'.$eshop_item['order_id']);?>"><img src="/eshop_images/remove_icon.png" alt="remove_icon" height="13px"></a> / 
                        <a href="<?php echo base_url('eshop/add_item/'.$eshop_item['order_id']);?>"><img src="/eshop_images/add_icon.png" alt="add_icon" height="15px"></a> /
                        <a href="<?php echo base_url('eshop/sub_item/'.$eshop_item['order_id']);?>"><img src="/eshop_images/sub_icon.png" alt="sub_icon" height="15px"></a>
                    </td>
               </tr>
               <?php $total_price = $total_price + $eshop_item['product_price']*$eshop_item['number_of_ordered_items'];
                     $calculated_price_with_DPH = $calculated_price_with_DPH + $eshop_item['product_price']*$eshop_item['number_of_ordered_items']*(1+ $eshop_item['dph']/100); ?>

            <?php endforeach; ?>
            <tr class="cart_table">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>Total price: </td>
                    <td><?php echo number_format($total_price, 2, ',', ' ') ?>€</td>
               </tr>
               <tr class="cart_table">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>Total price with VAT: </td>
                    <td><?php echo number_format($calculated_price_with_DPH, 2, ',', ' ') ?>€</td>
               </tr>
        </table>
        <br>
    <?php endif ?>  
    </fieldset>      

    <br>
    
    <form enctype="multipart/form-data" action="<?php echo base_url('/eshop/make_order'); ?>" method="post"> <!-- contactus_add_post $_SERVER['PHP_SELF'] -->
        <?= csrf_field() ?>
        <!-- There are probably only two things here that look unfamiliar. 
        The \Config\Services::validation()->listErrors() function is used to report errors related to form validation. 
        The csrf_field() function creates a hidden input with a CSRF token that helps protect against some common attacks. -->
      <fieldset>
        <legend>II. Delivery address</legend>
        <label for="first_name">Firstname</label>
        <input type="input" name="first_name" value="<?php echo session()->get('firstname'); ?>"/><br />

        <label for="last_name">Lastname</label>
        <input type="input" name="last_name" value="<?php echo session()->get('lastname'); ?>"/><br />

		<label for="e-mail">E-mail</label>
        <input type="input" name="email" value="<?php echo session()->get('email'); ?>"/><br />

        <label for="delivery_street">Street (Delivery address)</label>
        <input type="input" name="delivery_street" value="<?php echo session()->get('delivery_street'); ?>"/><br />

        <label for="delivery_state">State</label>
        <input type="input" name="delivery_state" value="<?php echo session()->get('delivery_state'); ?>"/><br />

        <label for="delivery_city">City</label>
        <input type="input" name="delivery_city" value="<?php echo session()->get('delivery_city'); ?>"/><br />

        
        <label for="ZIPcode">Postal ZIP code</label>
        <input type="input" name="ZIPcode" value="<?php echo session()->get('ZIPcode'); ?>"/><br />

        

        

        
      </fieldset>
    

    <br>
    
    <fieldset>
        <legend>III. Selection of way of delivery</legend>
        <p>Please select your favorite delivery method:</p>
          <input type="radio" id="via_post" name="delivery_type" value="post">
          <label for="via_post">Via post 2.50€</label><br>
          <input type="radio" id="ups" name="delivery_type" value="ups">
          <label for="ups">UPS 4.50€</label><br>
          <input type="radio" id="direct_pickup" name="delivery_type" value="direct">
          <label for="direct_pickup">Direct pickup at shop 0€</label>

      </fieldset>

    <br>
    
      <fieldset>
        <legend>IV. Order fullfilment</legend>
        <input type="checkbox" id="gdpr" name="GDPRaccept" value="gdpr">
        <label for="GDPRaccept"> GDPR acceptance</label><br>

        <input type="checkbox" id="service" name="ShopServiceLawAccept" value="shoplaw">
        <label for="ShopServiceLawAccept"> I accept a shop law agreement</label><br>

        

        <center><input id="input_button_create" type="submit" name="submit" value="I definitely confirm the order" /></center>
      </fieldset>

       
       
    </form>

    
</section>