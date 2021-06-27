
<section>
    

    <?= \Config\Services::validation()->listErrors() ?>

    <form enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" onsubmit="FormSubmit(this);"> <!-- if form submited invoke script that check if additional subcategory has been created and put that value into a product_subcategory that is select input (use hiden element) -->
        <?= csrf_field() ?>
        <!-- There are probably only two things here that look unfamiliar. 
        The \Config\Services::validation()->listErrors() function is used to report errors related to form validation. 
        The csrf_field() function creates a hidden input with a CSRF token that helps protect against some common attacks. -->
      <fieldset>
        <legend><?= esc($title) ?></legend>
        <label for="product_name">Product name</label>
        <input type="input" name="product_name" /><br />

        <label for="product_category">Product category</label>

      <!--   <select name="product_category" id="category_data" onchange="modify_value_of_selected()"> -->
        <input id="category_data" list="product_category" name="product_category" onchange="modify_value_of_selected()" placeholder="Select category">
            <datalist id="product_category">
            
                    <?php foreach ($eshop as $eshop_item): ?>
                    <?php 
                        if (empty($previews_category)) { // if it is first run assign emty string
                            $previews_category = "";
                        }; 
                        
                        if($eshop_item['product_category'] != $previews_category ) { // display only distinct categories
                            echo "<option value=" . $eshop_item['product_category'] . ">". $eshop_item['product_category']."</option>";
                        };
                        
                        $previews_category = $eshop_item['product_category']; // remember current value
                    ?>
                    <?php endforeach; ?> 
              </datalist>
        </select> <span id="selected_category"></span> <br>

        <label for="product_category">Product subcategory</label>
        <select name="product_subcategory" id="subcategory_data" >
            <option value="">Select subcategory</option>
        </select> 
        <!-- hidden input field for input new subcategory that is not available in a database --> 
            <label for="product_name" id="new_subcategory_data_label">Please enter new subcategory name:</label>
            <input type="input" name="new_product_subcategory" id="new_subcategory_data"/><br /> 
        
        <br> 

            
        
        
       

                

        <!-- read value entered into product category -->
        <script>
           $(document).ready(function(){ // only when document is fully loaded

               // hide optional input fieled for creating own subcategory
               $('#new_subcategory_data_label').hide();
               $('#new_subcategory_data').hide();
                  //if in subcategory has been selected * New subcategory, unhide previous input fileds
                  $('#subcategory_data').change(function(){  
                      console.log($('#subcategory_data').val()); // debug outupt during functionality testing
                    if($('#subcategory_data').val() == "new_subcategory") {
                        $('#new_subcategory_data_label').show();
                        $('#new_subcategory_data').show();
                    }
                });
                
                // on submit check if hiden element for product_subcategory contains value and then read this value and assign it into a value of product_subcategory select element
                /* function FormSubmit(oForm) {
                    if($('#new_subcategory_data').val() != "") {
                        $('#subcategory_data').val($('#new_subcategory_data').val());

                    }
   
                }  abandoned way how to solve that problem*/

                // another aproach on change hidem element update the main product_subcategory select elelment that provide appropriate data after submitting the form
                $('#new_subcategory_data').change(function(){

                              var entered_new_subcategory = $('#new_subcategory_data').val();
                              var html = '<option value="'+ entered_new_subcategory +'" placeholder="'+ entered_new_subcategory +'">'+ entered_new_subcategory +'</option>';
                              // html += '<option value="'+ entered_new_subcategory +'" >"'+ entered_new_subcategory +'"</option>';
                              $('#subcategory_data').html(html); // change content of html of the selected html element marked with mentioned ID "#subcategory_data"

                });
               
               // make Ajax request for subcategory when know selected main category
               $('#category_data').change(function(){
                   var product_category = $('#category_data').val();
                   var action = 'get_subcategory';
                   if(product_category != '') {
                       $.ajax({
                           url:"<?php echo base_url('/eshop/action'); ?>",
                           method:"POST",
                           data:{product_category:product_category, action:action},
                           dataType:"JSON",
                           success:function(data) {
                           
                               var html = '<option value="">Select subcategory</option>';

                               for(var count = 0; count < data.length; count++) {
                                   html += '<option value='+data[count].product_subcategory+'>'+data[count].product_subcategory+'</option>';
                               }
                               // here we provide options for entering new subcategory
                               html += '<option value="new_subcategory" id="new_subcategory">* New subcategory</option>';
                                
                               $('#subcategory_data').html(html);
                           }

                       });

                   } else {
                    $('#subcategory_data').val('');
                   }

               });

           });

          

           function modify_value_of_selected() { // function for calculating results
              var selected_category = document.getElementById("category_data").value;
              console.log('User selected -' + selected_category);
        
              var element_modified=  document.getElementById('selected_category');
              element_modified.textContent =selected_category ;

            
        
              
         }
        </script>


        

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