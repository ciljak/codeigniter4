
<section>
    <h2><?= esc($title) ?></h2>

    <?= \Config\Services::validation()->listErrors() ?>

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <?= csrf_field() ?>
        <!-- There are probably only two things here that look unfamiliar. 
        The \Config\Services::validation()->listErrors() function is used to report errors related to form validation. 
        The csrf_field() function creates a hidden input with a CSRF token that helps protect against some common attacks. -->

        <label for="title">Title</label>
        <input type="input" name="title" /><br />

        <label for="body">Text</label>
        <textarea name="body"></textarea><br />

        <input type="submit" name="submit" value="Create news item" />
    </form>

</section>