 <!-- code from create must be extednded to load content of edited article and then update them -->
 <section>
    

    <?= \Config\Services::validation()->listErrors() ?>
    <form enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post"> <!-- guestbook_add_post $_SERVER['PHP_SELF'] -->
        <?= csrf_field() ?>
        <!-- There are probably only two things here that look unfamiliar. 
        The \Config\Services::validation()->listErrors() function is used to report errors related to form validation. 
        The csrf_field() function creates a hidden input with a CSRF token that helps protect against some common attacks. -->
      <fieldset>
        <legend><?= esc($title) ?></legend>
        <label for="name_of_writer">From - name/ nic</label>
        <input type="input" name="name_of_writer" value="<?php echo $guestbook['name_of_writer']; ?>" /><br />

		<label for="e-mail">E-mail</label>
        <input type="input" name="email" value="<?php echo $guestbook['email']; ?>" /><br />

        <label for="message_text">Message text</label>
        <textarea id="textarea_styled" name="message_text" ><?php echo $guestbook['message_text']; ?></textarea><br />

        <label for="formGroupExampleInput">Article picture: </label>
        <input type="file" name="guestbook_image_file" class="form-control" id="guestbook_image_file" onchange="readURL(this);" accept=".png, .jpg, .jpeg" /> <br />

        <input id="input_button_create" type="submit" name="submit" value="Upadte post" />
      </fieldset>
    </form>

    

</section>

<section>
<a href="<?php echo base_url('guestbook'); ?>"><button type="button">Return to main guestbook page</button></a> 
<!-- bas_url is a way how to generate url consisting of main hostin domain name part and appropriate url denotating controller/method part -->
</section>