<!-- OVERVIEW is responsible for display of all news articles with buttons for desired operations -->
<section>
    

    <a href="news/create"><button type="button">Add new news post</button></a>
    <br /> <br /> <br />

    <h1 class="main_h1"><?= esc($title) ?></h1>

    <?php if (! empty($news) && is_array($news)) : ?>

        <?php foreach ($news as $news_item): ?>
        <div class="article_header">
            <h3><?= esc($news_item['title']) ?></h3>
        </div>
        <div class="article_body">
            <table>
                <tr>
                   <?php if (!empty($news_item['picture_name'])): ?>  <!-- if picture is provided it mean we will display in two table column -->
                        <td>
                            <div id="article_image" class="article_image">
                                <img src="<?=base_url()?>/public/images/<?= esc($news_item['picture_name']) ?>" alt="Article image - <?= esc($news_item['title']) ?> " width="250px" >
                            </div>
                        </td>
                    <?php endif ?>  
                    <td id="left_news_article"> 
                        <div id="body_text" class="main">
                            <?= esc($news_item['body']) ?>
                        </div>
                    </td>
                </tr>
            </table>
            <!-- old version <p><a href="/news/<?= esc($news_item['slug'], 'url') ?>">View article</a></p>  without base url -->
            <div id="article_hyperlink" class="article_hyperlink">
                <p><a class="news_article_hyperlink" href="<?php echo base_url('public/news') ; ?><?php echo "/" ; ?><?= esc($news_item['slug'], 'url') ?>">View article 
                <br /> &nbsp; &nbsp; &nbsp;
                <?php echo base_url('public/news'); ?><?php echo "/" ; ?><?= esc($news_item['slug'], 'url') ?> </a></p>
            </div>
        </div>   
            
             <br />
            <a  href="<?php echo base_url('public/news/delete_news_article/'.$news_item['id']);?> "><button id="input_button_delete"> Delete</button></a> 
            <a  href="<?php echo base_url('public/news/update_news_article/'.$news_item['id']);?> "><button id="input_button_update"> Update</button></a> 
             <!-- now we pass id of news article for deletion to controler news and them method  delete_news_article -->
             <br />
             <hr> <br />
        <?php endforeach; ?>

    <?php else : ?>

        <h3>No News</h3>

        <p>Unable to find any news for you.</p>

    <?php endif ?>
</section>