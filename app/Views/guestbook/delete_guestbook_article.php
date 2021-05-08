<section>
    
    <p> Article with id <?= esc($guestbook['id'])  ?> contains:</p>
    <div class="article_header">
            <h3><?= esc($guestbook['name_of_writer']) ?></h3>
        </div>
        <div class="article_body">
            <div class="main">
                <?= esc($guestbook['message_text']) ?>
            </div>
            
            <div class="article_hyperlink">
                has been deleted successfully!
            </div>
        </div>   
</section>

<section>
<a href="<?php echo base_url('public/guestbook'); ?>"><button type="button">Return to main news page</button></a> 
<!-- bas_url is a way how to generate url consisting of main hostin domain name part and appropriate url denotating controller/method part -->
</section>