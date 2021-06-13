<!-- VIEW page display only appropriate news article after click on the View Article hyperling on overview page -->

<section>
<?php if (($eshop['is_published']==1) || (session()->get('role') == 'admin')) : // this is only a security chec, if this select visible article then pagination 
            // will result in different number of displayed pages, must by implemented in query - but site admin can see all post and news controller suply them with unfiltered data
                ?> 
            <div class="whole_article <?php if ($eshop['is_published']==0) echo "whole_article_unpublished";  ?>" > <!-- if unpublished add marking whole_article_unpublished -->
            <?php if ($eshop['is_published']==0) echo "<p><b>Unpublished article</b> - please visit them and publish.<p>";  ?>  
            
                <div class="eshop_article_product">
                       <h1 class="inline_disp"><?= esc($eshop['product_name']) ?> </h1> <span class="tab"></span> <h2 class="inline_disp category tabular_underground"> Category: <?= esc($eshop['product_category']) ?> </h2> - <h2 class="inline_disp tabular_underground subcategory"><?= esc($eshop['product_subcategory']) ?> </h2>
                       <span class="tab"></span> <h2 class="inline_disp subcategory tabular_underground">Nr. of items on store: <?= esc($eshop['nr_of_items_on_store']) ?> </h2>
                </div>
                <div class="eshop_article_header">
                    
                       <h3>  
                           <br> <div id="eshop_product_price"> <?= esc(number_format($eshop['product_price'], 2, ',', ' ')) ?>€ </div>
                       </h3>
                </div>
                <div class="article_body">
                    <table>
                        <tr>
                        <?php if (!empty($eshop['picture_name_1'])): ?>  <!-- if picture is provided it mean we will display in two table column -->
                                <td>
                                    <div id="article_image" class="article_image">
                                        <img src="<?=base_url()?>/eshop_images/<?= esc($eshop['picture_name_1']) ?>" alt="Article image - <?= esc($eshop['product_name']) ?> " width="250px" >
                                    </div>
                                </td>
                            <?php endif ?>  
                            <td id="left_news_article"> 
                                <div id="body_text" class="main">
                                    <?= esc($eshop['description']) ?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                            <?php if (!empty($eshop['picture_name_2'])): ?>  <!-- if picture is provided it mean we will display in two table column -->
                               
                                    
                                        <img class="article_image_small" src="<?=base_url()?>/eshop_images/<?= esc($eshop['picture_name_2']) ?>" alt="Article image - <?= esc($eshop['product_name']) ?> "  >
                                        
                                   
                                
                            <?php endif ?>     
                            <?php if (!empty($eshop['picture_name_3'])): ?>  <!-- if picture is provided it mean we will display in two table column -->
                               
                                    
                                        <img class="article_image_small" src="<?=base_url()?>/eshop_images/<?= esc($eshop['picture_name_3']) ?>" alt="Article image - <?= esc($eshop['product_name']) ?> "  >
                                   
                                
                            <?php endif ?>  
                            </td>      
                        </tr>
                    </table>
                  
                   
                </div>   
                <?php  // debug - for testing purpouses
                            //echo "article users id: ". $news_item['user_id'];
                            //echo "session users id: ". session()->get('id');
                ?>
                
                <?php if ((session()->get('isLoggedIn')) && ( (session()->get('id'))==$eshop['user_id']) || (session()->get('role')=="admin")): 
                    //loged in and is owner or admin ?>
                    <br />
                    
                    <a  href="<?php echo base_url('eshop/delete_eshop_product/'.$eshop['id']);?> "><button id="input_button_delete"> Delete</button></a> 
                    <a  href="<?php echo base_url('eshop/update_eshop_product/'.$eshop['id']);?> "><button id="input_button_update"> Update</button></a> 
                        <?php if ((session()->get('isLoggedIn')) && session()->get('role')=="admin"): 
                        //if is loged admin - he can publis article to be visible ?>
                             <?php if ($eshop['is_published']==0): ?>
                                <a  href="<?php echo base_url('eshop/publish_eshop_product/'.$eshop['id']);?> "><button id="input_button_publish"> Publish</button></a> 
                             <?php else :   ?>
                                <a  href="<?php echo base_url('eshop/unpublish_eshop_product/'.$eshop['id']);?> "><button id="input_button_unpublish"> Unpublish</button></a> 
                            <?php endif ?>

                         <?php endif ?>

                    <!-- now we pass id of news article for deletion to controler news and them method  delete_news_article -->
                    <br />
                    <?php elseif ((session()->get('isLoggedIn')) && ( (session()->get('id'))!=$eshup['user_id']) ): 
                        // loged in but not owner of article and also not admin?>
                    <p>Only creator  or administrator can edit this product - please logout and login with appropriate user rights here:  <a  href="<?php echo base_url('users/logout/');?> "> logout</a></p>
                    
                    <?php else : 
                        // coomon unloged user?>
                    <p>Only loged in owner users or administrators can edit products -  <a  href="<?php echo base_url('users/');?> "> login</a> </p>
            
                    <?php endif ?>
            </div >        
                    <hr> <br />
            <?php endif ?>
</section>
<section>
<a href="<?php echo base_url('eshop'); ?>"><button type="button">Return to main e-shop page</button></a> 
<!-- bas_url is a way how to generate url consisting of main hostin domain name part and appropriate url denotating controller/method part -->
</section>