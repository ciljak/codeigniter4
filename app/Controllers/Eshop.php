<?php

namespace App\Controllers;

use App\Models\eshopModel;
use CodeIgniter\Controller;

/*********************************
 *  Pagination in code igniter - for further reference please visit https://codeigniter.com/user_guide/libraries/pagination.html, 23.5.2021
 */
$pager = \Config\Services::pager();

//$image = Config\Services::image();
// for image handling please refer this article https://www.nicesnippets.com/blog/codeigniter-4-image-upload-with-preview-example, 1.5.2021

class Eshop extends Controller
{
    public function index()
    {
        $model = new EshopModel();
    
       

        if(session()->get('role') == 'admin') { // if admin loged in thend dont filter published but display all to ability manage them
            $data = [
                //'eshop'  => $model->geteshop(),
                'title' => 'eshop archive',
                'eshop' => $model->orderBy('id', 'DESC')->paginate(3),
                'pager' => $model->pager,
            ];
    
        } else { // coomon user see only published articles

           $data = [
            //'eshop'  => $model->geteshop(),
            'title' => 'eshop archive',
            'eshop' => $model->where('is_published', '1')->orderBy('id', 'DESC')->paginate(3),
            'pager' => $model->pager,
        ];

            
        };

        /* pagination config */
        /* Customizing the Links
           View Configuration
           When the links are rendered out to the page, they use a view file to describe the HTML. You can easily change the view that is used by editing app/Config/Pager.php:
        */

        
    
        echo view('templates/header', $data);
        echo view('eshop/overview', $data);
        echo view('templates/footer', $data);
    }

    /* Next, there are two methods, one to view all eshop items, 
    and one for a specific eshop item. You can see that the $slug variable is passed to the model’s method in the second method. 
    The model is using this slug to identify the eshop item to be returned. */

    public function view($slug = null)
    {
        $model = new EshopModel();
    
        $data['eshop'] = $model->getProduct($slug);
    
        if (empty($data['eshop']))
        {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Cannot find the eshop item: '. $slug);
        }
    
        $data['title'] = $data['eshop']['title'];
    
        echo view('templates/header', $data);
        echo view('eshop/view', $data);
        echo view('templates/footer', $data);
    }

    public function create() // for further reading please visit https://codeigniter.com/user_guide/tutorial/create_eshop_items.html, 24.4.2021
    {
        $model = new eshopModel();

        if ($this->request->getMethod() === 'post' && $this->validate([
                'product_name' => 'required|min_length[3]|max_length[255]',
                'description'  => 'required',
                'product_price'  => 'required',
                'product_category'  => 'required',
                'product_subcategory'  => 'required',
                'dph'  => 'required',
                'nr_of_items_on_store'  => 'required',
                
                'eshop_image_file1' => [
                    'uploaded[eshop_image_file1]',
                    'mime_in[eshop_image_file1,image/jpg,image/jpeg,image/gif,image/png]',
                    'max_size[eshop_image_file1,12096]',
                ],
                'eshop_image_file2' => [
                    //'uploaded[eshop_image_file2]',
                    'mime_in[eshop_image_file2,image/jpg,image/jpeg,image/gif,image/png]',
                    'max_size[eshop_image_file2,12096]',
                ],
                'eshop_image_file3' => [
                   // 'uploaded[eshop_image_file3]',
                    'mime_in[eshop_image_file3,image/jpg,image/jpeg,image/gif,image/png]',
                    'max_size[eshop_image_file3,12096]',
                ],
            ]))
        {
            $eshop_image1 = $this->request->getFile('eshop_image_file1'); // creating object of uploaded 
            if ($eshop_image1 !="") {
            // image is present then proceed with them and save its name
                $newName1 = $eshop_image1->getRandomName(); // generate new random name
                $eshop_image_type1 = $eshop_image1->getMimeType();
                $eshop_image1 = $eshop_image1->move('./eshop_images', $newName1); //picture is moved into a images folder nested in public folder
            } else {
            // image is absent - reference to no image example    
                $newName1 = "no_image.png"; // generate new random name
                $eshop_image_type1 = "image/png";
            }

            $eshop_image2 = $this->request->getFile('eshop_image_file2'); // creating object of uploaded 
            if ($eshop_image2 !="") {
            // image is present then proceed with them and save its name
                $newName2 = $eshop_image2->getRandomName(); // generate new random name
                $eshop_image_type2 = $eshop_image2->getMimeType();
                $eshop_image2 = $eshop_image2->move('./eshop_images', $newName2); //picture is moved into a images folder nested in public folder
            } else {
            // image is absent - reference to no image example    
                $newName2 = "no_image.png"; // generate new random name
                $eshop_image_type2 = "image/png";
            }

            $eshop_image3 = $this->request->getFile('eshop_image_file3'); // creating object of uploaded 
            if ($eshop_image3 !="") {
            // image is present then proceed with them and save its name
                $newName3 = $eshop_image3->getRandomName(); // generate new random name
                $eshop_image_type3 = $eshop_image3->getMimeType();
                $eshop_image3 = $eshop_image3->move('./eshop_images', $newName3); //picture is moved into a images folder nested in public folder
            } else {
            // image is absent - reference to no image example    
                $newName3 = "no_image.png"; // generate new random name
                $eshop_image_type3 = "image/png";
            }
            
            
            // The move() method returns a new File instance that for the relocated file, so you must capture the result if the resulting location is needed:
                if(session()->get('id')== null) { // anonymous user - not loged in
                    $model->save([
                        'product_name' => $this->request->getPost('product_name'),
                        'product_id' => $this->request->getPost('product_id'),
                        'product_category' => $this->request->getPost('product_category'),
                        'product_subcategory' => $this->request->getPost('product_subcategory'),
                        'product_price' => $this->request->getPost('product_price'),
                        'dph' => $this->request->getPost('dph'),
                        'nr_of_items_on_store' => $this->request->getPost('nr_of_items_on_store'),
                        'slug'  => url_title($this->request->getPost('title'), '-', TRUE),
                        'description'  => $this->request->getPost('description'),
                        'picture_name_1' => $newName1, //$newName , //$newName, //  or if orignal upload name is $eshop_image->usedgetClientName(),
                        'picture_type_1'  => $eshop_image_type1,
                        'picture_name_2' => $newName2, //$newName , //$newName, //  or if orignal upload name is $eshop_image->usedgetClientName(),
                        'picture_type_2'  => $eshop_image_type2,
                        'picture_name_3' => $newName3, //$newName , //$newName, //  or if orignal upload name is $eshop_image->usedgetClientName(),
                        'picture_type_3'  => $eshop_image_type3,
                        'user_id'  => '0' 
                    ]);    
                } else { // loged in user - session contains their user_id or id
                    $model->save([
                        'product_name' => $this->request->getPost('product_name'),
                        'product_id' => $this->request->getPost('product_id'),
                        'product_category' => $this->request->getPost('product_category'),
                        'product_subcategory' => $this->request->getPost('product_subcategory'),
                        'product_price' => $this->request->getPost('product_price'),
                         'dph' => $this->request->getPost('dph'),
                        'nr_of_items_on_store' => $this->request->getPost('nr_of_items_on_store'),
                        'slug'  => url_title($this->request->getPost('product_name'), '-', TRUE),
                        'description'  => $this->request->getPost('description'),
                        'picture_name_1' => $newName1, //$newName , //$newName, //  or if orignal upload name is $eshop_image->usedgetClientName(),
                        'picture_type_1'  => $eshop_image_type1,
                        'picture_name_2' => $newName2, //$newName , //$newName, //  or if orignal upload name is $eshop_image->usedgetClientName(),
                        'picture_type_2'  => $eshop_image_type2,
                        'picture_name_3' => $newName3, //$newName , //$newName, //  or if orignal upload name is $eshop_image->usedgetClientName(),
                        'picture_type_3'  => $eshop_image_type3,
                        'user_id'  => session()->get('id')
                    ]);    
                    
                };

           
            
            //$data['eshop'] = $model->getLatest(); this approach does not work because i cann note order_by and take first() element but all data ara available 
            // and can by simply passed by on from send post
            $data ['eshop'] = [
                        'product_name' => $this->request->getPost('product_name'),
                        'product_id' => $this->request->getPost('product_id'),
                        'product_category' => $this->request->getPost('product_catgory'),
                        'product_subcategory' => $this->request->getPost('product_subcategory'),
                        'product_price' => $this->request->getPost('product_price'),
                         'dph' => $this->request->getPost('dph'),
                        'nr_of_items_on_store' => $this->request->getPost('nr_of_items_on_store'),
                        'slug'  => url_title($this->request->getPost('product_name'), '-', TRUE),
                        'description'  => $this->request->getPost('description'),
                        'picture_name_1' => $newName1, //$newName , //$newName, //  or if orignal upload name is $eshop_image->usedgetClientName(),
                        'picture_type_1'  => $eshop_image_type1,
                        'picture_name_2' => $newName2, //$newName , //$newName, //  or if orignal upload name is $eshop_image->usedgetClientName(),
                        'picture_type_2'  => $eshop_image_type2,
                        'picture_name_3' => $newName3, //$newName , //$newName, //  or if orignal upload name is $eshop_image->usedgetClientName(),
                        'picture_type_3'  => $eshop_image_type3,
                        'user_id'  => session()->get('id')
            ] ;

           


            echo view('templates/header', ['title' => 'Create a eshop item']);
            echo view('eshop/success', $data );
            echo view('templates/footer');
        }
        else
        {
            echo view('templates/header', ['title' => 'Create a eshop item']);
            echo view('eshop/create');
            echo view('templates/footer');
        }
    }

    public function delete_eshop_product($id) {

        $model = new eshopModel();

            // first obtain data that will be deleted for passing into view informing about data deletion
            $data['eshop'] = $model->getID($id);

            // delete related image
            helper('filesystem'); // load helper - for more please read https://codeigniter.com/user_guide/helpers/filesystem_helper.html, 1.5.2021 
                // delete appropriate file
                /*  echo '<?=base_url()?>/public/images/'.$data['eshop']['picture_name']; - for debug of delete link creation*/ 
                /* delete_files('<?=base_url()?>/public/images/'.$data['eshop']['picture_name'], true); */
            if ($data['eshop']['picture_name'] != null) {
                unlink('./images/'.$data['eshop']['picture_name']);
            }
            
            $model->where('id', $id)->delete();

            // data giwen to view must be array - keep that in mind!!! now we first create string and pass them
            /* $data ['eshop'] = [
                'id' => $id
            ] ; */
           
            echo view('templates/header');
            echo view('eshop/eshop_article_deleted', $data );
            echo view('templates/footer');
       

        }

        public function update_eshop_product($id) {

            $model = new eshopModel();
    
               


                if ($this->request->getMethod() === 'post' && $this->validate([
                    'product_name' => 'required|min_length[3]|max_length[255]',
                    'description'  => 'required',
                    'product_price'  => 'required',
                    'product_category'  => 'required',
                    'product_subcategory'  => 'required',
                    'dph'  => 'required',
                    'nr_of_items_on_store'  => 'required',
                    
                    'eshop_image_file1' => [
                        'uploaded[eshop_image_file1]',
                        'mime_in[eshop_image_file1,image/jpg,image/jpeg,image/gif,image/png]',
                        'max_size[eshop_image_file1,12096]',
                    ],
                    'eshop_image_file2' => [
                        //'uploaded[eshop_image_file2]',
                        'mime_in[eshop_image_file2,image/jpg,image/jpeg,image/gif,image/png]',
                        'max_size[eshop_image_file2,12096]',
                    ],
                    'eshop_image_file3' => [
                    // 'uploaded[eshop_image_file3]',
                        'mime_in[eshop_image_file3,image/jpg,image/jpeg,image/gif,image/png]',
                        'max_size[eshop_image_file3,12096]',
                    ],
                ]))
            {
                $eshop_image1 = $this->request->getFile('eshop_image_file1'); // creating object of uploaded 
                if ($eshop_image1 !="") {
                // image is present then proceed with them and save its name
                    $newName1 = $eshop_image1->getRandomName(); // generate new random name
                    $eshop_image_type1 = $eshop_image1->getMimeType();
                    $eshop_image1 = $eshop_image1->move('./eshop_images', $newName1); //picture is moved into a images folder nested in public folder
                } else {
                // image is absent - reference to no image example    
                    $newName1 = "no_image.png"; // generate new random name
                    $eshop_image_type1 = "image/png";
                }
    
                $eshop_image2 = $this->request->getFile('eshop_image_file2'); // creating object of uploaded 
                if ($eshop_image2 !="") {
                // image is present then proceed with them and save its name
                    $newName2 = $eshop_image2->getRandomName(); // generate new random name
                    $eshop_image_type2 = $eshop_image2->getMimeType();
                    $eshop_image2 = $eshop_image2->move('./eshop_images', $newName2); //picture is moved into a images folder nested in public folder
                } else {
                // image is absent - reference to no image example    
                    $newName2 = "no_image.png"; // generate new random name
                    $eshop_image_type2 = "image/png";
                }
    
                $eshop_image3 = $this->request->getFile('eshop_image_file3'); // creating object of uploaded 
                if ($eshop_image3 !="") {
                // image is present then proceed with them and save its name
                    $newName3 = $eshop_image3->getRandomName(); // generate new random name
                    $eshop_image_type3 = $eshop_image3->getMimeType();
                    $eshop_image3 = $eshop_image3->move('./eshop_images', $newName3); //picture is moved into a images folder nested in public folder
                } else {
                // image is absent - reference to no image example    
                    $newName3 = "no_image.png"; // generate new random name
                    $eshop_image_type3 = "image/png";
                }
                
                $model->save([
                    'id' => $id,
                    'title' => $this->request->getPost('title'),
                    'slug'  => url_title($this->request->getPost('title'), '-', TRUE),
                    'body'  => $this->request->getPost('body'),
                    'picture_name' =>  $newName , //$newName, //  or if orignal upload name is $eshop_image->usedgetClientName(),
                    'picture_type'  => $eshop_image_type
                ]);
                
                //$data['eshop'] = $model->getLatest(); this approach does not work because i cann note order_by and take first() element but all data ara available 
                // and can by simply passed by on from send post
                if(session()->get('id')== null) { // anonymous user - not loged in
                    $model->save([
                        'product_name' => $this->request->getPost('product_name'),
                        'product_id' => $this->request->getPost('product_id'),
                        'product_category' => $this->request->getPost('product_category'),
                        'product_subcategory' => $this->request->getPost('product_subcategory'),
                        'product_price' => $this->request->getPost('product_price'),
                        'dph' => $this->request->getPost('dph'),
                        'nr_of_items_on_store' => $this->request->getPost('nr_of_items_on_store'),
                        'slug'  => url_title($this->request->getPost('title'), '-', TRUE),
                        'description'  => $this->request->getPost('description'),
                        'picture_name_1' => $newName1, //$newName , //$newName, //  or if orignal upload name is $eshop_image->usedgetClientName(),
                        'picture_type_1'  => $eshop_image_type1,
                        'picture_name_2' => $newName2, //$newName , //$newName, //  or if orignal upload name is $eshop_image->usedgetClientName(),
                        'picture_type_2'  => $eshop_image_type2,
                        'picture_name_3' => $newName3, //$newName , //$newName, //  or if orignal upload name is $eshop_image->usedgetClientName(),
                        'picture_type_3'  => $eshop_image_type3,
                        'user_id'  => '0' 
                    ]);    
                } else { // loged in user - session contains their user_id or id
                    $model->save([
                        'product_name' => $this->request->getPost('product_name'),
                        'product_id' => $this->request->getPost('product_id'),
                        'product_category' => $this->request->getPost('product_category'),
                        'product_subcategory' => $this->request->getPost('product_subcategory'),
                        'product_price' => $this->request->getPost('product_price'),
                         'dph' => $this->request->getPost('dph'),
                        'nr_of_items_on_store' => $this->request->getPost('nr_of_items_on_store'),
                        'slug'  => url_title($this->request->getPost('product_name'), '-', TRUE),
                        'description'  => $this->request->getPost('description'),
                        'picture_name_1' => $newName1, //$newName , //$newName, //  or if orignal upload name is $eshop_image->usedgetClientName(),
                        'picture_type_1'  => $eshop_image_type1,
                        'picture_name_2' => $newName2, //$newName , //$newName, //  or if orignal upload name is $eshop_image->usedgetClientName(),
                        'picture_type_2'  => $eshop_image_type2,
                        'picture_name_3' => $newName3, //$newName , //$newName, //  or if orignal upload name is $eshop_image->usedgetClientName(),
                        'picture_type_3'  => $eshop_image_type3,
                        'user_id'  => session()->get('id')
                    ]);    
                    
                };

                echo view('templates/header', ['title' => 'Create a eshop item']);
                echo view('eshop/success', $data );
                echo view('templates/footer');
            }
            else
            {
                 // first obtain data that will be deleted for passing into view informing about data deletion
                $data['eshop'] = $model->getID($id);
               
                echo view('templates/header', ['title' => 'Update a eshop item']);
                echo view('eshop/eshop_article_updated', $data );
                echo view('templates/footer');
            }
             
           
    
            }

    public function publish_eshop_product($id) // publish article - is_published chante to 1
    {
        
        //find record with appropriate id and change value of item
       // $model->where('id', $id)->set('is_published', '1');

       // rework this part - how to update only one field in row
                $db      = \Config\Database::connect();
                $builder = $db->table('eshop');
    
                //$builder->selectMax('id');
                $builder->where('id', $id)->set('is_published', '1');
               // insert create new article, but we will update existing $builder->insert();
                $builder-> update(); // for reference please visit https://codeigniter.com/user_guide/database/query_builder.html?highlight=select#updating-data

        // send data after publishing to view
        $model = new eshopModel();
    
        if(session()->get('role') == 'admin') { // if admin loged in thend dont filter published but display all to ability manage them
            $data = [
                //'eshop'  => $model->geteshop(),
                'title' => 'eshop archive',
                'eshop' => $model->orderBy('id', 'DESC')->paginate(3),
                'pager' => $model->pager,
            ];
    
        } else { // coomon user see only published articles

           $data = [
            //'eshop'  => $model->geteshop(),
            'title' => 'eshop archive',
            'eshop' => $model->where('is_published', '1')->orderBy('id', 'DESC')->paginate(3),
            'pager' => $model->pager,
           ];
        
        };

       

        echo view('templates/header');
        echo view('eshop/overview', $data ); // return into main eshop page 
        echo view('templates/footer');
    }   
    
    public function unpublish_eshop_product($id) // unpublish article - is_published chante to 1
    {
        
        //find record with appropriate id and change value of item
        // $model->where('id', $id)->set('is_published', '0');
        $db      = \Config\Database::connect();
        $builder = $db->table('eshop');

        //$builder->selectMax('id');
        $builder->where('id', $id)->set('is_published', '0');
       // $builder->insert();
        $builder-> update();

        // send data after publishing to view
        $model = new eshopModel();
    
        if(session()->get('role') == 'admin') { // if admin loged in thend dont filter published but display all to ability manage them
            $data = [
                //'eshop'  => $model->geteshop(),
                'title' => 'eshop archive',
                'eshop' => $model->orderBy('id', 'DESC')->paginate(3),
                'pager' => $model->pager,
            ];
    
        } else { // coomon user see only published articles

           $data = [
            //'eshop'  => $model->geteshop(),
            'title' => 'eshop archive',
            'eshop' => $model->where('is_published', '1')->orderBy('id', 'DESC')->paginate(3),
            'pager' => $model->pager,
           ];
        
        };


        echo view('templates/header');
        echo view('eshop/overview', $data ); // return into main eshop page 
        echo view('templates/footer');
    }        
}