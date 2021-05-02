<section>

<h1 class="main_h1"> Guestbook </h1>

<!-- in upper part display form for submiting text in guestbook and bottom part display all messages -->
<section>
    

    <?= \Config\Services::validation()->listErrors() ?>

    <form enctype="multipart/form-data" action="<?php echo base_url('public/pages/guestbook_add_post/'); ?>" method="post"> <!-- guestbook_add_post $_SERVER['PHP_SELF'] -->
        <?= csrf_field() ?>
        <!-- There are probably only two things here that look unfamiliar. 
        The \Config\Services::validation()->listErrors() function is used to report errors related to form validation. 
        The csrf_field() function creates a hidden input with a CSRF token that helps protect against some common attacks. -->
      <fieldset>
        <legend><?= esc($title) ?></legend>
        <label for="name_of_writer">From - name/ nic</label>
        <input type="input" name="name_of_writer" /><br />

		<label for="e-mail">E-mail</label>
        <input type="input" name="email" /><br />

        <label for="message_text">Message text</label>
        <textarea id="textarea_styled" name="message_text"></textarea><br />

        <label for="formGroupExampleInput">Article picture: </label>
        <input type="file" name="guestbook_image_file" class="form-control" id="guestbook_image_file" onchange="readURL(this);" accept=".png, .jpg, .jpeg" /> <br />

        <input id="input_button_create" type="submit" name="submit" value="Write new post" />
      </fieldset>
    </form>

</section>

    

    
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
                                <img src="<?=base_url()?>/public/images/<?= esc($guestbook_item['picture_name']) ?>" alt="Guestbook entry image - <?= esc($guestbook_item['name_of_writer']) ?> " width="250px" >
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
                <p><a class="news_article_hyperlink" href="<?php echo base_url('public/guestbook_single_view'); ?><?php echo "/" ; ?><?= esc($guestbook_item['slug'], 'url') ?>">View article 
                <br /> &nbsp; &nbsp; &nbsp;
                <?php echo base_url('public/guestbook_single_view'); ?><?php echo "/" ; ?><?= esc($guestbook_item['slug'], 'url') ?> </a></p>
            </div>
        </div>   
            
             <br />
            <a  href="<?php echo base_url('public/delete_guestbook_article/'.$guestbook_item['id']);?> "><button id="input_button_delete"> Delete</button></a> 
            <a  href="<?php echo base_url('public/update_guestbook_article/'.$guestbook_item['id']);?> "><button id="input_button_update"> Update</button></a> 
             <!-- now we pass id of news article for deletion to controler news and them method  delete_news_article -->
             <br />
             <hr> <br />
        <?php endforeach; ?>

    <?php else : ?>

        <h3>No News</h3>

        <p>Unable to find any news for you.</p>

    <?php endif ?>






</section>

<div class="further">

	<section>

		<h1>"Created with focus on object oriented application design and utilisation of MVC based php framework CodeIgniter 4."</h1>

        

	</section>

</div>