<!-- OVERVIEW is responsible for display of all news articles with buttons for desired operations -->
<section>
    

    <a href="news/create"><button type="button">Add new news post</button></a>
    <br /> <br /> <br />

    <h1 class="main_h1"><?= esc($title) ?></h1>

    <?php if (! empty($news) && is_array($news)) : ?>

        <?php foreach ($news as $news_item): ?>
            <?php if (($news_item['is_published']==1) || (session()->get('role') == 'admin')) : // this is only a security chec, if this select visible article then pagination 
            // will result in different number of displayed pages, must by implemented in query - but site admin can see all post and news controller suply them with unfiltered data
                ?> 

                <div class="article_header">
                    <h3><?= esc($news_item['title']) ?></h3>
                </div>
                <div class="article_body">
                    <table>
                        <tr>
                        <?php if (!empty($news_item['picture_name'])): ?>  <!-- if picture is provided it mean we will display in two table column -->
                                <td>
                                    <div id="article_image" class="article_image">
                                        <img src="<?=base_url()?>/images/<?= esc($news_item['picture_name']) ?>" alt="Article image - <?= esc($news_item['title']) ?> " width="250px" >
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
                        <p><a class="news_article_hyperlink" href="<?php echo base_url('news') ; ?><?php echo "/" ; ?><?= esc($news_item['slug'], 'url') ?>">View article 
                        <br /> &nbsp; &nbsp; &nbsp;
                        <?php echo base_url('news'); ?><?php echo "/" ; ?><?= esc($news_item['slug'], 'url') ?> </a></p>
                    </div>
                </div>   
                <?php  // debug - for testing purpouses
                            //echo "article users id: ". $news_item['user_id'];
                            //echo "session users id: ". session()->get('id');
                ?>
                
                <?php if ((session()->get('isLoggedIn')) && ( (session()->get('id'))==$news_item['user_id']) || (session()->get('role')=="admin")): 
                    //loged in and is owner or admin ?>
                    <br />
                    
                    <a  href="<?php echo base_url('news/delete_news_article/'.$news_item['id']);?> "><button id="input_button_delete"> Delete</button></a> 
                    <a  href="<?php echo base_url('news/update_news_article/'.$news_item['id']);?> "><button id="input_button_update"> Update</button></a> 
                        <?php if ((session()->get('isLoggedIn')) && session()->get('role')=="admin"): 
                        //if is loged admin - he can publis article to be visible ?>
                             <?php if ($news_item['is_published']==0): ?>
                                <a  href="<?php echo base_url('news/publish_news_article/'.$news_item['id']);?> "><button id="input_button_update"> Publish</button></a> 
                             <?php else :   ?>
                                <a  href="<?php echo base_url('news/unpublish_news_article/'.$news_item['id']);?> "><button id="input_button_update"> Unpublish</button></a> 
                            <?php endif ?>

                         <?php endif ?>

                    <!-- now we pass id of news article for deletion to controler news and them method  delete_news_article -->
                    <br />
                    <?php elseif ((session()->get('isLoggedIn')) && ( (session()->get('id'))!=$news_item['user_id']) ): 
                        // loged in but not owner of article and also not admin?>
                    <p>Only owner user or administrator can edit this article - please logout and login with appropriate user rights here:  <a  href="<?php echo base_url('users/logout/');?> "> logout</a></p>
                    
                    <?php else : 
                        // coomon unloged user?>
                    <p>Only loged in owner users or administrators can edit articles -  <a  href="<?php echo base_url('users/');?> "> login</a> </p>
                    
                    <?php endif ?>
                    <hr> <br />
            <?php endif ?>
        <?php endforeach; ?>
        <?= $pager->links() 
        // CodeIgniter 4 pagination https://www.bookstack.cn/read/codeigniter4-en/2bd0095ae8b900bb.md ,
                       //how to style links https://stackoverflow.com/questions/30096942/how-to-style-pagination-links-without-config-codeigniter, 23.5.21
        ?> 

    <?php else : ?>

        <h3>No News</h3>

        <p>Unable to find any news for you.</p>

    <?php endif ?>
</section>