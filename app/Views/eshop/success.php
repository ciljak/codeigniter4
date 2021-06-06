<section>
    <p><?= esc($eshop['slug']) ?></p>
    <h1 class="main_h1" >News item: <?= esc($eshop['product_name']) ?></h1>
    <h2><?= esc($eshop['description']) ?></h2>
    <h2>Provided picture info:</h2>
    <h3><?= esc($eshop['picture_name_1']) ?></h3>
    <h3><?= esc($eshop['picture_type_1']) ?></h3>
    <img src="<?=base_url()?>/eshop_images/<?= esc($eshop['picture_name_1']) ?>" alt="Currently uploaded product image nr. 1" width="250px" >

    <p>Product created successfully.</p>
    
</section>

<section>
<a href="<?php echo base_url('eshop'); ?>"><button type="button">Return to main eshop page</button></a> 
<!-- bas_url is a way how to generate url consisting of main hostin domain name part and appropriate url denotating controller/method part -->
</section>
