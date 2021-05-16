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
        <label for="name">From - name/ nic</label>
        <input type="input" name="name" value="<?php echo $contactus['name']; ?>" /><br />

		<label for="e-mail">E-mail</label>
        <input type="input" name="email" value="<?php echo $contactus['email']; ?>" /><br />

        <label for="message_text">Message text</label>
        <textarea id="textarea_styled" name="message_text" ><?php echo $contactus['message_text']; ?></textarea><br />

        

        <input id="input_button_create" type="submit" name="submit" value="Correct Contact message" />
      </fieldset>
    </form>

    

</section>

<section>
<a href="<?php echo base_url('contactus'); ?>"><button type="button">Return to main Contact us page</button></a> 
<!-- bas_url is a way how to generate url consisting of main hostin domain name part and appropriate url denotating controller/method part -->
</section>