 <!-- code from create must be extednded to load content of edited article and then update them -->
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
        <input type="input" name="product_name" value="<?php echo $eshop['product_name']; ?>"/><br />

        <label for="product_category">Product category</label>
        
        <input id="category_data" list="product_category" name="product_category" value="<?php echo $eshop['product_category']; ?>" onchange="modify_value_of_selected()" >
                <datalist id="product_category">

                 <?php foreach ($eshop_category_list as $eshop_item): ?>
                     <?php 
                        if (empty($previews_category)) { // if it is first run assign emty string
                          $previews_category = "";
                        }; 
                        
                        if($eshop_item['product_category'] != $previews_category ) { // display only distinct categories
                            echo "<option value=" . $eshop_item['product_category'] . ">";
                        };
                     
                        $previews_category = $eshop_item['product_category']; // remember current value
                     ?>

                  <?php endforeach; ?> 
        </datalist> <span id="selected_category"></span> <br>

        <!-- read value entered into product category -->
        <script>
          

           function modify_value_of_selected() { // function for calculating results
              var selected_category = document.getElementById("category_data").value;
              console.log('User selected -' + selected_category);
        
              var element_modified=  document.getElementById('selected_category');
              element_modified.textContent =selected_category ;

            
        
              
         }
        </script>


        <label for="product_subcategory">Product subcategory</label>
        <input list="product_subcategory" name="product_subcategory" value="<?php echo $eshop['product_subcategory']; ?>">
                <datalist id="product_subcategory">

                 <?php foreach ($eshop_category_list as $eshop_item): ?>
                  <?php 
                        if (empty($previews_subcategory)) { // if it is first run assign emty string
                          $previews_subcategory = "";
                        }; 
                        
                        if($eshop_item['product_subcategory'] != $previews_subcategory ) { // display only distinct categories
                            echo "<option value=" . $eshop_item['product_subcategory'] . ">";
                        };
                     
                        $previews_subcategory = $eshop_item['product_subcategory']; // remember current value
                     ?>

                  <?php endforeach; ?> 
        </datalist> <br>

        <label for="product_price">Product price without DPH</label>
        <input type="input" name="product_price" value="<?php echo $eshop['product_price']; ?>"/><br />

        <label for="dph">DPH</label>
        <input type="input" name="dph" value="<?php echo $eshop['dph']; ?>"/><br />

        <label for="nr_of_items_on_store">Number of items added on store</label>
        <input type="input" name="nr_of_items_on_store" value="<?php echo $eshop['nr_of_items_on_store']; ?>"/><br />

        <label for="description">Product decsription</label>
        <textarea id="textarea_styled" name="description" ><?php echo $eshop['description']; ?></textarea><br />

           <?php if (!empty($eshop['picture_name_1'])): ?>  <!-- if picture is provided it mean we will display in two table column -->
                      <img class="article_image_small" src="<?=base_url()?>/eshop_images/<?= esc($eshop['picture_name_1']) ?>" alt="Product image 1 - <?= esc($eshop['product_name']) ?> "  >
           <?php endif ?> 

        <label for="formGroupExampleInput">Article picture 1 (required):</label>
        <input type="file" name="eshop_image_file1" class="form-control" id="news_image_file" onchange="readURL(this);" accept=".png, .jpg, .jpeg" /> <br />

           <?php if (!empty($eshop['picture_name_2'])): ?>  <!-- if picture is provided it mean we will display in two table column -->
                      <img class="article_image_small" src="<?=base_url()?>/eshop_images/<?= esc($eshop['picture_name_2']) ?>" alt="Product image 2 - <?= esc($eshop['product_name']) ?> "  >
           <?php endif ?> 

        <label for="formGroupExampleInput">Article picture 2 (optional):</label>
        <input type="file" name="eshop_image_file2" class="form-control" id="news_image_file" onchange="readURL(this);" accept=".png, .jpg, .jpeg" /> <br />

           <?php if (!empty($eshop['picture_name_3'])): ?>  <!-- if picture is provided it mean we will display in two table column -->
                      <img class="article_image_small" src="<?=base_url()?>/eshop_images/<?= esc($eshop['picture_name_3']) ?>" alt="Product image 3 - <?= esc($eshop['product_name']) ?> "  >
           <?php endif ?> 

        <label for="formGroupExampleInput">Article picture 3 (optional):</label>
        <input type="file" name="eshop_image_file3" class="form-control" id="news_image_file" onchange="readURL(this);" accept=".png, .jpg, .jpeg" /> <br />

        <input id="input_button_create" type="submit" name="submit" value="Update  product info" />
      </fieldset>
    </form>

    

</section>

<section>
<a href="<?php echo base_url('eshop'); ?>"><button type="button">Return to main e-shop page</button></a> 
<!-- bas_url is a way how to generate url consisting of main hostin domain name part and appropriate url denotating controller/method part -->
</section>