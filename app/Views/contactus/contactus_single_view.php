<!-- GUESTBOOK_SINGLE_Viwe page display only appropriate news article after click on the View Article hyperling on overview page -->

<section>
    <h2 class="news_singleview_h2_title"><?= esc($contactus['name']) ?></h2>
    <p class="news_singleview_p_body"><?= esc($news['message_text']) ?></p>
    
</section>
<section>
<a href="<?php echo base_url('public/contactus'); ?>"><button type="button">Return to main Contact us page</button></a> 
<!-- bas_url is a way how to generate url consisting of main hostin domain name part and appropriate url denotating controller/method part -->
</section>