<!--  Information about succesfull or unsuccesfull order goes here  -->
<section>
    <h1>Order from user with id  <?= esc($final_order['user_id']) ?></h1>
    <h1 class="main_h1" >Ordered by: <?= esc($final_order['last_name']) ?></h1>

    <h2>Selected delivery adress:</h2>
    <p><?= esc($final_order['first_name']) ?> <?= esc($final_order['last_name']) ?></p>
    <p>Street: <?= esc($final_order['delivery_street']) ?> </p>
    <p>State: <?= esc($final_order['delivery_state']) ?> </p>
    <p>City: <?= esc($final_order['delivery_city']) ?> </p>
    <p>ZIPcode: <?= esc($final_order['ZIPcode']) ?> </p>

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

    
    <h2>Order created succesfully.</h2>
    
</section>

<section>
<a href="<?php echo base_url('eshop'); ?>"><button type="button">Return to main eshop page</button></a> 
<!-- bas_url is a way how to generate url consisting of main hostin domain name part and appropriate url denotating controller/method part -->
</section>