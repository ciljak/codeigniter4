
<section>
    

    <?= \Config\Services::validation()->listErrors() ?>

    <form enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <?= csrf_field() ?>
        <!-- There are probably only two things here that look unfamiliar. 
        The \Config\Services::validation()->listErrors() function is used to report errors related to form validation. 
        The csrf_field() function creates a hidden input with a CSRF token that helps protect against some common attacks. -->
      <fieldset>
        <legend><?= esc($title) ?></legend>
        <label for="product_name">Product name</label>
        <input type="input" name="product_name" /><br />

        <label for="product_category">Product category</label>
        <input type="input" name="product_category" /><br />

        <label for="product_subcategory">Product subcategory</label>
        <input type="input" name="product_subcategory" /><br />

        <label for="product_price">Product price without DPH</label>
        <input type="input" name="product_price" /><br />

        <label for="dph">DPH</label>
        <input type="input" name="dph" /><br />

        <label for="nr_of_items_on_store">Number of items added on store</label>
        <input type="input" name="nr_of_items_on_store" /><br />

        <label for="description">Product decsription</label>
        <textarea id="textarea_styled" name="description"></textarea><br />

        <label for="formGroupExampleInput">Article picture 1 (required):</label>
        <input type="file" name="eshop_image_file1" class="form-control" id="news_image_file" onchange="readURL(this);" accept=".png, .jpg, .jpeg" /> <br />

        <label for="formGroupExampleInput">Article picture 2 (optional):</label>
        <input type="file" name="eshop_image_file2" class="form-control" id="news_image_file" onchange="readURL(this);" accept=".png, .jpg, .jpeg" /> <br />

        <label for="formGroupExampleInput">Article picture 3 (optional):</label>
        <input type="file" name="eshop_image_file3" class="form-control" id="news_image_file" onchange="readURL(this);" accept=".png, .jpg, .jpeg" /> <br />

        <input id="input_button_create" type="submit" name="submit" value="Create new product" />
      </fieldset>
    </form>

</section>

<section>
<a href="<?php echo base_url('eshop'); ?>"><button type="button">Return to main e-shop page</button></a> 
<!-- bas_url is a way how to generate url consisting of main hostin domain name part and appropriate url denotating controller/method part -->
</section>