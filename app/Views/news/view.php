<!-- VIEW page display only appropriate news article after click on the View Article hyperling on overview page -->

<section>
    <h2 class="news_singleview_h2_title"><?= esc($news['title']) ?></h2>
    <p class="news_singleview_p_body"><?= esc($news['body']) ?></p>
    <?php if (!empty($news['picture_name'])): ?>  <!-- if picture is provided it mean we will display in two table column -->
                        <td>
                            <div id="article_image" class="article_image">
                                <img src="<?=base_url()?>/images/<?= esc($news['picture_name']) ?>" alt="Article image - <?= esc($news['title']) ?> " width="250px" >
                            </div>
                        </td>
    <?php endif ?>  
</section>
<section>
<a href="<?php echo base_url('news'); ?>"><button type="button">Return to main news page</button></a> 
<!-- bas_url is a way how to generate url consisting of main hostin domain name part and appropriate url denotating controller/method part -->
</section>