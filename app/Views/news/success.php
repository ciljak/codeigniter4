<section>
    <p><?= esc($news['slug']) ?></p>
    <h1 class="main_h1" >News item: <?= esc($news['title']) ?></h1>
    <h2><?= esc($news['body']) ?></h2>
    <p>created successfully.</p>
    
</section>

<section>
<a href="<?php echo base_url('public/news'); ?>"><button type="button">Return to main news page</button></a> 
<!-- bas_url is a way how to generate url consisting of main hostin domain name part and appropriate url denotating controller/method part -->
</section>
