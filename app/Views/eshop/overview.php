<!-- OVERVIEW is responsible for display of all news articles with buttons for desired operations -->
<section>

<div class="row">
   <div class="col-12">
			
		
            <?php if (isset($message)) : //if message from controler in data asociative array is passed then display content ?>
                <h3 class="message_above <?= esc($message_type) ?>"><?= $message ?></h3>
            <?php endif ?>  
            <img src="/eshop_images/eshop_logo.png" alt="main_eshop_logo" height="250px"> <br><br>
            <?php if ((session()->get('isLoggedIn')) ): 
                        //loged in user - can publish news article but still markt as unpublished and only site admin can make it visible by changing value is_published to true = 1 ?>
            <a href="/eshop/create"><button type="button">Add new eshop product</button></a>
            <br /> <br /> <br />
                        

            <?php else :
                        //not logged in user - common page visitor ?>

            
                <!-- <a href="users"><button type="button">Log in for ability to publish products</button></a>  only admin of the page can add items for further decision is to create also role for e-shop publisher -->
            <br /> <br /> <br />

            <?php endif; ?>			

            

            <h1 class="main_h1"><?= esc($title) ?></h1>
         
  </div>

  <div class="col-9">
            <?php if (! empty($eshop) && is_array($eshop)) : ?>

                <?php foreach ($eshop as $eshop_item): ?>
                    <?php if (($eshop_item['is_published']==1) || (session()->get('role') == 'admin')) : // this is only a security chec, if this select visible article then pagination 
                    // will result in different number of displayed pages, must by implemented in query - but site admin can see all post and news controller suply them with unfiltered data
                        ?> 
                    <div class="whole_article <?php if ($eshop_item['is_published']==0) echo "whole_article_unpublished";  ?>" > <!-- if unpublished add marking whole_article_unpublished -->
                    <?php if ($eshop_item['is_published']==0) echo "<p><b>Unpublished article</b> - please visit them and publish.<p>";  ?>  
                    
                        <div class="eshop_article_product">
                            <h1 class="inline_disp"><?= esc($eshop_item['product_name']) ?> </h1> <span class="tab"></span> <h2 class="inline_disp category tabular_underground"> Category: <?= esc($eshop_item['product_category']) ?> </h2> - <h2 class="inline_disp tabular_underground subcategory"><?= esc($eshop_item['product_subcategory']) ?> </h2>
                            <span class="tab"></span> <h2 class="inline_disp subcategory tabular_underground">Nr. of items on store: <?= esc($eshop_item['nr_of_items_on_store']) ?> </h2>
                        </div>
                        <div class="eshop_article_header">
                            
                            <h3>  
                                <br> <div id="eshop_product_price"> <?= esc(number_format($eshop_item['product_price'], 2, ',', ' ')) ?>€ </div>
                            </h3>
                        </div>
                        <div class="article_body">
                            <table>
                                <tr>
                                <?php if (!empty($eshop_item['picture_name_1'])): ?>  <!-- if picture is provided it mean we will display in two table column -->
                                        <td>
                                            <div id="article_image" class="article_image">
                                                <img src="<?=base_url()?>/eshop_images/<?= esc($eshop_item['picture_name_1']) ?>" alt="Article image - <?= esc($eshop_item['product_name']) ?> " width="250px" >
                                            </div>
                                        </td>
                                    <?php endif ?>  
                                    <td id="left_news_article"> 
                                        <div id="body_text" class="main">
                                            <?= esc($eshop_item['description']) ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                    <?php if (!empty($eshop_item['picture_name_2'])): ?>  <!-- if picture is provided it mean we will display in two table column -->
                                    
                                            
                                                <img class="article_image_small" src="<?=base_url()?>/eshop_images/<?= esc($eshop_item['picture_name_2']) ?>" alt="Article image - <?= esc($eshop_item['product_name']) ?> "  >
                                                
                                        
                                        
                                    <?php endif ?>     
                                    <?php if (!empty($eshop_item['picture_name_3'])): ?>  <!-- if picture is provided it mean we will display in two table column -->
                                    
                                            
                                                <img class="article_image_small" src="<?=base_url()?>/eshop_images/<?= esc($eshop_item['picture_name_3']) ?>" alt="Article image - <?= esc($eshop_item['product_name']) ?> "  >
                                        
                                        
                                    <?php endif ?>  
                                    </td>      
                                </tr>
                            </table>
                            <!-- old version <p><a href="/news/<?= esc($eshop_item['slug'], 'url') ?>">View article</a></p>  without base url -->
                            <div id="article_hyperlink" class="article_hyperlink">
                                <p><a class="news_article_hyperlink" href="<?php echo base_url('eshop') ; ?><?php echo "/" ; ?><?= esc($eshop_item['slug'], 'url') ?>">View article 
                                <br /> &nbsp; &nbsp; &nbsp;
                                <?php echo base_url('eshop'); ?><?php echo "/" ; ?><?= esc($eshop_item['slug'], 'url') ?> </a>
                                </p>
                            </div>

                            <!-- add/ remove item to cart -->
                            <div class="add_to_cart_button">
                                    <?php if ($eshop_item['user_cart']==0): ?>
                                                <a  href="<?php echo base_url('eshop/add_to_cart/'.$eshop_item['id']);?> "><button id="cart_button_add"> <img src="/eshop_images/cart_icon_colored.png" alt="choping_cart" height="45px"> Add to cart </button></a> 
                                    <?php else :   ?>
                                                <a  href="<?php echo base_url('eshop/remove_from_cart/'.$eshop_item['id']);?> "><button id="cart_button_remove">  <img src="/eshop_images/cart_icon_colored.png" alt="choping_cart" height="45px"> Remove from cart </button></a> 
                                    <?php endif ?>
                            </div>
                            
                            </div>   
                        <?php  // debug - for testing purpouses
                                    //echo "article users id: ". $news_item['user_id'];
                                    //echo "session users id: ". session()->get('id');
                        ?>
                        
                        <?php if ((session()->get('isLoggedIn')) && ( (session()->get('id'))==$eshop_item['user_id']) || (session()->get('role')=="admin")): 
                            //loged in and is owner or admin ?>
                            <br />
                            
                            <a  href="<?php echo base_url('eshop/delete_eshop_product/'.$eshop_item['id']);?> "><button id="input_button_delete"> Delete</button></a> 
                            <a  href="<?php echo base_url('eshop/update_eshop_product/'.$eshop_item['id']);?> "><button id="input_button_update"> Update</button></a> 
                                <?php if ((session()->get('isLoggedIn')) && session()->get('role')=="admin"): 
                                //if is loged admin - he can publis article to be visible ?>
                                    <?php if ($eshop_item['is_published']==0): ?>
                                        <a  href="<?php echo base_url('eshop/publish_eshop_product/'.$eshop_item['id']);?> "><button id="input_button_publish"> Publish</button></a> 
                                    <?php else :   ?>
                                        <a  href="<?php echo base_url('eshop/unpublish_eshop_product/'.$eshop_item['id']);?> "><button id="input_button_unpublish"> Unpublish</button></a> 
                                    <?php endif ?>

                                <?php endif ?>

                            <!-- now we pass id of news article for deletion to controler news and them method  delete_news_article -->
                            <br />
                            <?php elseif ((session()->get('isLoggedIn')) && ( (session()->get('id'))!=$eshup_item['user_id']) ): 
                                // loged in but not owner of article and also not admin?>
                            <p>Only creator  or administrator can edit this product - please logout and login with appropriate user rights here:  <a  href="<?php echo base_url('users/logout/');?> "> logout</a></p>
                            
                            <?php else : 
                                // coomon unloged user?>
                            <p>Only loged in owner users or administrators can edit products -  <a  href="<?php echo base_url('users/');?> "> login</a> </p>
                    
                            <?php endif ?>
                    </div >        
                            <hr> <br />
                    <?php endif ?>
                <?php endforeach; ?>
                <?= $pager->links() 
                // CodeIgniter 4 pagination https://www.bookstack.cn/read/codeigniter4-en/2bd0095ae8b900bb.md ,
                            //how to style links https://stackoverflow.com/questions/30096942/how-to-style-pagination-links-without-config-codeigniter, 23.5.21
                ?> 

            <?php else : ?>

                <h3>No products yet</h3>

                <p>Unable to find any products for you.</p>

            <?php endif ?>

    </div>

    <div class="col-3">
    <!-- side menu for e-shop -->
                <?php if (session()->get('isLoggedIn')): ?> 
				<h2>Private zone</h2>
				<ul class="nav flex-column">  <!-- bootstrap styling https://getbootstrap.com/docs/5.0/components/navs-tabs/ -->
					
					<li class="menu-item hidden"><a href="<?php echo base_url('users/profile') ; ?>">Update profile</a></li>
					<li class="menu-item hidden"><a href="<?php echo base_url('users/logout') ; ?>">Logout</a></li>
				</ul>
				</br></br>
                <?php endif; ?> 
                
                <h2>e-shop categories</h2>
                <ul class="nav flex-column">  <!-- bootstrap styling https://getbootstrap.com/docs/5.0/components/navs-tabs/ -->
                <?php foreach ($nonpaginated_data_for_menu as $eshop_item): ?>
                    <?php 
                        if (empty($previews_category)) { // if it is first run assign emty string
                            $previews_category = "";
                        }; 
                        if (empty($previews_subcategory)) { // if it is first run assign emty string
                            $previews_subcategory = "";
                        }; 
                        
                        if($eshop_item['product_category'] != $previews_category ) { // display only distinct categories
                            // a tag create ling only for main category
                            echo '<li class="menu-item hidden" value="' . $eshop_item['product_category'] . '">';
                            echo '<a class="news_article_hyperlink" href="';
                            echo base_url('eshop') ;  
                            echo "/filter/" ;
                            echo $eshop_item['product_category'] ;
                            echo "/none" ; //two arguments must be passed - none is pased indicating no subcatgory is selected
                            
                            echo '">';
                            echo $eshop_item['product_category']."</a></li>";
                        };

                        if($eshop_item['product_subcategory'] != $previews_subcategory ) { // display only distinct categories
                            // a tags create ling with category and subcategory
                            echo '<li class="menu-item hidden hidesub" value="' . $eshop_item['product_subcategory'] . '"> &nbsp &nbsp ';
                            echo '<a class="news_article_hyperlink" href="';
                            echo base_url('eshop') ;  
                            echo "/filter/" ;
                            echo $eshop_item['product_category'] ;
                            echo "/" ;
                            echo $eshop_item['product_subcategory'] ;
                            echo '">';
                            echo $eshop_item['product_subcategory']."</a></li>";
                        };
                        
                        $previews_category = $eshop_item['product_category']; // remember current value
                        $previews_subcategory = $eshop_item['product_subcategory'];
                    ?>
                    <?php endforeach; ?> 
                    <!-- last menu item is link returning to main e-shop page displaying all category links -->
                    <li class="menu-item hidden"><a href="<?php echo base_url('eshop') ; ?>"><img src="/images/return_icon.png" alt="return_icon" height="20px"> Return</a></li>
                </ul>   
				
				<h2>Menu options</h2>
					<ul class="nav flex-column">
					
					<!-- base_url inserts part defined in .env config file consists of main url part that can be easy chenged along hosting migration -->
					<li class="menu-item hidden"><a href="<?php echo base_url('about') ; ?>">About</a></li>
					<li class="menu-item hidden"><a href="<?php echo base_url('news') ; ?>">News</a></li>
					<li class="menu-item hidden"><a href="<?php echo base_url('guestbook') ; ?>">Guestbook</a></li>
					<li class="menu-item hidden"><a href="https://codeigniter4.github.io/userguide/" target="_blank">Docs</a>
					</li>
					<li class="menu-item hidden"><a href="https://forum.codeigniter.com/" target="_blank">Community</a></li>
					<li class="menu-item hidden"><a href="<?php echo base_url('contactus') ; ?>">Contact us</a></li>
					
					</ul>

					<h2>About project</h2>	

					<ul class="nav flex-column">
					<li class="menu-item hidden"><a href="<?php echo base_url('project_milestones') ; ?>">Project milestones</a></li>
				    </ul>

    </div>
  </div>  
</section>