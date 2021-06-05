<section>

<h1 class="main_h1"> Guestbook </h1>

<!-- in upper part display form for submiting text in guestbook and bottom part display all messages -->

    

    <?= \Config\Services::validation()->listErrors() ?>

    <form enctype="multipart/form-data" action="<?php echo base_url('/guestbook/guestbook_add_post/'); ?>" method="post"> <!-- guestbook_add_post $_SERVER['PHP_SELF'] -->
        <?= csrf_field() ?>
        <!-- There are probably only two things here that look unfamiliar. 
        The \Config\Services::validation()->listErrors() function is used to report errors related to form validation. 
        The csrf_field() function creates a hidden input with a CSRF token that helps protect against some common attacks. -->
      <fieldset>
        <legend><?= esc($title) ?></legend>
        <label for="name_of_writer">From - name/ nic</label>
        <input type="input" name="name_of_writer" value="<?php echo session()->get('firstname') . " " .session()->get('lastanem'); ?>" /><br />

		<label for="e-mail">E-mail</label>
        <input type="input" name="email" value="<?php echo session()->get('email') ; ?>"/><br />

        <label for="message_text">Message text</label>
        <textarea id="textarea_styled" name="message_text" cols="50" rows="5"></textarea><br />

        <label for="formGroupExampleInput">Article picture: </label>
        <input type="file" name="guestbook_image_file" class="form-control" id="guestbook_image_file" onchange="readURL(this);" accept=".png, .jpg, .jpeg" /> <br />

        <input id="input_button_create" type="submit" name="submit" value="Write new post" />
      </fieldset>
    </form>



    

    
    <br /> <br /> <br />

    <h1 class="main_h1"><?= esc($title) ?></h1>

    <?php if (! empty($guestbook) && is_array($guestbook)) : ?>

        <?php foreach ($guestbook as $guestbook_item): ?>
        <div class="article_header">
            <h3><?= esc($guestbook_item['name_of_writer']) ?></h3>
        </div>
        <div class="article_body">
            <table>
                <tr>
                   <?php if (!empty($guestbook_item['picture_name'])): ?>  <!-- if picture is provided it mean we will display in two table column -->
                        <td>
                            <div id="article_image" class="article_image">
                                <img src="<?=base_url()?>/images/<?= esc($guestbook_item['picture_name']) ?>" alt="Guestbook entry image - <?= esc($guestbook_item['name_of_writer']) ?> " width="250px" >
                            </div>
                        </td>
                    <?php endif ?>  
                    <td id="left_news_article"> 
                        <div id="body_text" class="main">
                            <?= esc($guestbook_item['message_text']) ?>
                        </div>
                    </td>
                </tr>
            </table>
            
            <div id="article_hyperlink" class="article_hyperlink">
                <p><a class="news_article_hyperlink" href="<?php echo base_url('guestbook/guestbook_single_view'); ?><?php echo "/" ; ?><?= esc($guestbook_item['slug'], 'url') ?>">View article 
                <br /> &nbsp; &nbsp; &nbsp;
                <?php echo base_url('guestbook_single_view'); ?><?php echo "/" ; ?><?= esc($guestbook_item['slug'], 'url') ?> </a></p>
            </div>
        </div>   
            
       

             <br />
             <?php if ((session()->get('isLoggedIn')) && ( (session()->get('id'))==$guestbook_item['user_id']) || (session()->get('role')=="admin")): 
            //loged in and is owner or admin ?>
            <a  href="<?php echo base_url('guestbook/delete_guestbook_article/'.$guestbook_item['id']);?> "><button id="input_button_delete"> Delete</button></a> 
            <a  href="<?php echo base_url('guestbook/update_guestbook_article/'.$guestbook_item['id']);?> "><button id="input_button_update"> Update</button></a> 
             <!-- now we pass id of news article for deletion to controler news and them method  delete_news_article -->
             <?php elseif ((session()->get('isLoggedIn')) && ( (session()->get('id'))!=$guestbook_item['user_id']) ): 
                // loged in but not owner of article and also not admin?>
             <p>Only owner user or administrator can edit this article - please logout and login with appropriate user rights here:  <a  href="<?php echo base_url('users/logout/');?> "> logout</a></p>
            
             <?php else : 
                // coomon unloged user?>
             <p>Only loged in owner users or administrators can edit articles -  <a  href="<?php echo base_url('users/');?> "> login</a> </p>
            
            <?php endif ?>
             <br />
             <hr> <br />
        <?php endforeach; ?>

    <?php else : ?>

        <h3>No guestbook entries</h3>

        <p>Unable to find any guestbook posts for you.</p>

    <?php endif ?>


    <?= $pager->links() 
        // CodeIgniter 4 pagination https://www.bookstack.cn/read/codeigniter4-en/2bd0095ae8b900bb.md ,
                       //how to style links https://stackoverflow.com/questions/30096942/how-to-style-pagination-links-without-config-codeigniter, 23.5.21
        ?> 



</section>

<div class="further">

	<section>

		<h1>"Created with focus on object oriented application design and utilisation of MVC based php framework CodeIgniter 4."</h1>

        

	</section>

</div>