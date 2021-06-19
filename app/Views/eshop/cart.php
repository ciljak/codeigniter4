<!-- cart.php is responsible for display of items selected by appropriate visitor of webpage -->
<section>
    <img src="/eshop_images/main_cart_image.png" alt="main_eshop_logo" height="150px"> <br><br>
  		

    

    <h1 class="main_h1"><?= esc($title) ?></h1>

    <?php if (! empty($eshop) && is_array($eshop)) : ?>
       <table class="cart_table">
           <tr>
             <th>Product name</th>
             <th>Product category/subcategory</th>
             <th>Photo</th>
             <th>DPH %</th>
             <th>Price</th>
             <th>Action</th>
          </tr>
            <?php 
            $total_price = 0;
            $calculated_price_with_DPH = 0;
            foreach ($eshop as $eshop_item): ?>
                <tr>
                    <td><?php echo $eshop_item['product_name'] ?></td>
                    <td><?php echo $eshop_item['product_category']."/". $eshop_item['product_subcategory'] ?></td>
                    <td><img src="/eshop_images/<?php echo $eshop_item['picture_name_1'] ?>" alt="<?php echo $eshop_item['product_name'] ?>" height="80px"></td>
                    <td><?php echo $eshop_item['dph'] ?>%</td>
                    <td><?php echo $eshop_item['product_price'] ?>€</td>
                    <td><a href="<?php echo base_url('eshop/remove_from_cart_return_to_cart/'.$eshop_item['id']);?>"><img src="/eshop_images/remove_icon.png" alt="remove_icon" height="15px"></a> / 
                        <a href="/eshop/add_item/"><img src="/eshop_images/add_icon.png" alt="remove_icon" height="17px"></a>
                    </td>
               </tr>
               <?php $total_price = $total_price + $eshop_item['product_price'];
                     $calculated_price_with_DPH = $calculated_price_with_DPH + $eshop_item['product_price']*(1+ $eshop_item['dph']/100); ?>

            <?php endforeach; ?>

               <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>Total price: </td>
                    <td><?php echo $total_price ?>€</td>
               </tr>
               <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>Total price with DPH: </td>
                    <td><?php echo $calculated_price_with_DPH ?>€</td>
               </tr>
        </table>
        <br>
        <?= $pager->links() 
        // CodeIgniter 4 pagination https://www.bookstack.cn/read/codeigniter4-en/2bd0095ae8b900bb.md ,
                       //how to style links https://stackoverflow.com/questions/30096942/how-to-style-pagination-links-without-config-codeigniter, 23.5.21
        ?> 

    <?php else : ?>

        <h3>No cart items yet</h3>

        <p>Unable to find any cart content for you.</p>

    <?php endif ?>
</section>