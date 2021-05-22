<section>


<h1 class="main_h1"> Contact us  </h1>

<p> <b>Project name: </b>CodeIgniter 4  - basic concepts of MVC based web php framework</p>
<p> <b>Author: </b>Eng. Milan Ciljak</p>
<p> <b>www: </b><a href="https://cdesigner.eu">cdesigner.eu</a> </p>
<p> <b>youtube: </b><a href="https://www.youtube.com/channel/UCycc5wlWBr3fyIfZ9jWAeNg/videos">our youtube channel</a> </p>
<hr>

<p>Send us a message here:
</p>

<!-- in upper part display form for submiting text in guestbook and bottom part display all messages -->

    

    <?= \Config\Services::validation()->listErrors() ?>

    <form enctype="multipart/form-data" action="<?php echo base_url('public/contactus/contactus_add_post/'); ?>" method="post"> <!-- contactus_add_post $_SERVER['PHP_SELF'] -->
        <?= csrf_field() ?>
        <!-- There are probably only two things here that look unfamiliar. 
        The \Config\Services::validation()->listErrors() function is used to report errors related to form validation. 
        The csrf_field() function creates a hidden input with a CSRF token that helps protect against some common attacks. -->
      <fieldset>
        <legend><?= esc($title) ?></legend>
        <label for="name_of_writer">From - name/ nic</label>
        <input type="input" name="name" /><br />

		<label for="e-mail">E-mail</label>
        <input type="input" name="email" /><br />

        <label for="message_text">Message text</label>
        <textarea id="textarea_styled" name="message_text"></textarea><br />

        

        <input id="input_button_create" type="submit" name="submit" value="Send contact message" />
      </fieldset>
    </form>



    

    
    <br /> <br /> <br />

    <h1 class="main_h1"><?= esc($title) ?> - recorded messages yet</h1>

    <?php if (! empty($contactus) && is_array($contactus) && (session()->get('isLoggedIn')) ) : ?>

        <?php foreach ($contactus as $contactus_item): ?>
        <div class="article_header">
            <h3>Message from: <?= esc($contactus_item['name']) ?></h3>
            <h4>contact e-mail is: <?= esc($contactus_item['email']) ?></h4>
        </div>
        <div class="article_body">
            <table>
                <tr>
                  
                    <td id="left_news_article"> 
                        <div id="body_text" class="main">
                            <?= esc($contactus_item['message_text']) ?>
                        </div>
                    </td>
                </tr>
            </table>
            
            
        </div>   
            
             <br />
            <a  href="<?php echo base_url('contactus/delete_contactus_article/'.$contactus_item['id']);?> "><button id="input_button_delete"> Delete message</button></a> 
            <a  href="<?php echo base_url('contactus/update_contactus_article/'.$contactus_item['id']);?> "><button id="input_button_update"> Update message</button></a> 
             <!-- now we pass id of news article for deletion to controler news and them method  delete_news_article -->
             <br />
             <hr> <br />
        <?php endforeach; ?>
        
    <?php endif ?>
    

    <?php if (session()->get('isLoggedIn')) : ?>

        

    <?php else : ?>
        <h3>For reading stored messages you must log in</h3>

        <p>Please <a href="/users">log in</a>!</p>

    <?php endif ?>






</section>

<div class="further">

	<section>

		<h1>"Created with focus on object oriented application design and utilisation of MVC based php framework CodeIgniter 4."</h1>

        

	</section>

</div>