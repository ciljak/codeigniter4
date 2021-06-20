<!-- cart.php is responsible for display of items selected by appropriate visitor of webpage -->
<section>
    <img src="/eshop_images/main_cart_image.png" alt="main_eshop_logo" height="150px"> <br><br>
  		

    

    <h1 class="main_h1"><?= esc($title) ?></h1>

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

        <div class="center">
            <a  href="<?php echo base_url('eshop/');?> "><button id="button_gray"> Return to e-shop</button></a>
            <a  href="<?php echo base_url('eshop/make_order/'.$eshop_item['main_order_number']);?> "><button id="button_green"> Progress with order -></button></a> 
        </div>

       

    <?php else : ?>

        <h3>No cart items yet</h3>

        <p>Unable to find any cart content for you.</p>

    <?php endif ?>
</section>