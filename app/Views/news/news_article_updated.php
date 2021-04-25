 <!-- code from create must be extednded to load content of edited article and then update them -->
<section>
    

    <?= \Config\Services::validation()->listErrors() ?>

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <?= csrf_field() ?>
        <!-- There are probably only two things here that look unfamiliar. 
        The \Config\Services::validation()->listErrors() function is used to report errors related to form validation. 
        The csrf_field() function creates a hidden input with a CSRF token that helps protect against some common attacks. -->
      <fieldset>
      <legend><?= esc($title) ?> </legend>  
        <label for="title">Title</label>
        <input type="input" name="title" value="<?php echo $news['title']; ?>"/><br />

        <label for="body">Text</label>
        <textarea id="textarea_styled" name="body"><?php echo $news['body']; ?></textarea><br />

        <input id="input_button_update" type="submit" name="submit" value="Update news item" />
       </fieldset> 
    </form>

</section>

<section>
<a href="<?php echo base_url('public/news'); ?>"><button type="button">Return to main news page</button></a> 
<!-- bas_url is a way how to generate url consisting of main hostin domain name part and appropriate url denotating controller/method part -->
</section>