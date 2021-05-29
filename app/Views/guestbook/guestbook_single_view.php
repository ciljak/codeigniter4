<!-- GUESTBOOK_SINGLE_Viwe page display only appropriate news article after click on the View Article hyperling on overview page -->

<section>
    <h2 class="news_singleview_h2_title"><?= esc($guestbook['name_of_writer']) ?></h2>
    <p class="news_singleview_p_body"><?= esc($guestbook['message_text']) ?></p>
    <?php if (!empty($guestbook['picture_name'])): ?>  <!-- if picture is provided it mean we will display in two table column -->
                        <td>
                            <div id="article_image" class="article_image">
                                <img src="<?=base_url()?>/images/<?= esc($guestbook['picture_name']) ?>" alt="Guestbook entry from - <?= esc($guestbook['name_of_writer']) ?> " width="250px" >
                            </div>
                        </td>
    <?php endif ?>  
</section>
<section>
<a href="<?php echo base_url('guestbook'); ?>"><button type="button">Return to main news page</button></a> 
<!-- bas_url is a way how to generate url consisting of main hostin domain name part and appropriate url denotating controller/method part -->
</section>