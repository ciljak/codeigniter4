<section>
    
    <p> Contact message with id <?= esc($contactus['id'])  ?> contains:</p>
    <div class="article_header">
            <h3><?= esc($contactus['name']) ?></h3>
        </div>
        <div class="article_body">
            <div class="main">
                <?= esc($contactus['message_text']) ?>
            </div>
            
            <div class="article_hyperlink">
                has been deleted successfully!
            </div>
        </div>   
</section>

<section>
<a href="<?php echo base_url('public/contactus'); ?>"><button type="button">Return to main Contact us page</button></a> 
<!-- bas_url is a way how to generate url consisting of main hostin domain name part and appropriate url denotating controller/method part -->
</section>