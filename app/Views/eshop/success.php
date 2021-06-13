<section>
    <p><?= esc($eshop['slug']) ?></p>
    <h1 class="main_h1" >Updated product: <?= esc($eshop['product_name']) ?></h1>
    <h2><?= esc($eshop['description']) ?></h2>
    <h2>Provided pictures info:</h2>
    <h2><?= esc($eshop['picture_name_1']) ?> - <?= esc($eshop['picture_type_1']) ?></h2>
    <h2><?= esc($eshop['picture_name_2']) ?> - <?= esc($eshop['picture_type_2']) ?></h2>
    <h2><?= esc($eshop['picture_name_3']) ?> - <?= esc($eshop['picture_type_3']) ?></h2>
    
    <img src="<?=base_url()?>/eshop_images/<?= esc($eshop['picture_name_1']) ?>" alt="Currently uploaded product image nr. 1" width="250px" >
    <img src="<?=base_url()?>/eshop_images/<?= esc($eshop['picture_name_2']) ?>" alt="Currently uploaded product image nr. 2" width="250px" >
    <img src="<?=base_url()?>/eshop_images/<?= esc($eshop['picture_name_3']) ?>" alt="Currently uploaded product image nr. 3" width="250px" >
    <hr>
    <h2>Product updated successfully.</h2>
    
</section>

<section>
<a href="<?php echo base_url('eshop'); ?>"><button type="button">Return to main eshop page</button></a> 
<!-- bas_url is a way how to generate url consisting of main hostin domain name part and appropriate url denotating controller/method part -->
</section>
