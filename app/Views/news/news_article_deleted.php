<section>
    
    <p> Article with id <?= esc($news['id'])  ?> contains:</p>
    <div class="article_header">
            <h3><?= esc($news['title']) ?></h3>
        </div>
        <div class="article_body">
            <div class="main">
                <?= esc($news['body']) ?>
            </div>
            
            <div class="article_hyperlink">
                has been deleted successfully!
            </div>
        </div>   
</section>

<section>
<a href="<?php echo base_url('news'); ?>"><button type="button">Return to main news page</button></a> 
<!-- bas_url is a way how to generate url consisting of main hostin domain name part and appropriate url denotating controller/method part -->
</section>