<section>
    <p><?= esc($news['slug']) ?></p>
    <h1 class="main_h1" >News item: <?= esc($news['title']) ?></h1>
    <h2><?= esc($news['body']) ?></h2>
    <h2>Provided picture info:</h2>
    <h3><?= esc($news['picture_name']) ?></h3>
    <h3><?= esc($news['picture_type']) ?></h3>
    <img src="<?=base_url()?>/images/<?= esc($news['picture_name']) ?>" alt="Currently uploaded image" width="250px" >

    <p>created successfully.</p>
    
</section>

<section>
<a href="<?php echo base_url('news'); ?>"><button type="button">Return to main news page</button></a> 
<!-- bas_url is a way how to generate url consisting of main hostin domain name part and appropriate url denotating controller/method part -->
</section>
