<?php

namespace App\Controllers;

use App\Models\eshopModel;
use App\Models\orderModel;
use App\Models\FinalOrderModel;
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
                'title' => 'Our latest e-shop products are here ...',
                'eshop' => $model->orderBy('id', 'DESC')->paginate(3),
                'pager' => $model->pager,

                //"nonpaginated" data array for display of side menu e-shop itmes not limited by applied paging limit
                'nonpaginated_data_for_menu' => $model->orderBy('id', 'DESC')->paginate(),
                
            ];
           


    
        } else { // coomon user see only published articles

           $data = [
            //'eshop'  => $model->geteshop(),
            'title' => 'Our latest e-shop products are here ...',
            'eshop' => $model->where('is_published', '1')->orderBy('id', 'DESC')->paginate(3),
            'pager' => $model->pager,

            //"nonpaginated" data array for display of side menu e-shop itmes not limited by applied paging limit
            'nonpaginated_data_for_menu' => $model->where('is_published', '1')->orderBy('id', 'DESC')->paginate(),
            
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

    public function filter($selected_category = 0 ,  $selected_subcategory = 0 )
    {
        $model = new EshopModel();
        
       // $selected_category =  $this->uri->segment(3);
      //  $selected_subcategory=  $this->uri->segment(4);
    
       if($selected_subcategory != "none") {
            if(session()->get('role') == 'admin') { // if admin loged in thend dont filter published but display all to ability manage them
                $data = [
                    //'eshop'  => $model->geteshop(),
                    'title' => 'Our latest e-shop products are here ...',
                    'eshop' => $model->where('product_subcategory', $selected_subcategory)->orderBy('id', 'DESC')->paginate(3),
                    'pager' => $model->pager,

                     //"nonpaginated" data array for display of side menu e-shop itmes not limited by applied paging limit
                     'nonpaginated_data_for_menu' => $model->where('product_subcategory', $selected_subcategory)->orderBy('id', 'DESC')->paginate(),
                ];
        
            } else { // coomon user see only published articles

            $data = [
                //'eshop'  => $model->geteshop(),
                'title' => 'Our latest e-shop products are here ...',
                'eshop' => $model->where('is_published', '1')->where('product_subcategory', $selected_subcategory)->orderBy('id', 'DESC')->paginate(3),
                'pager' => $model->pager,

                //"nonpaginated" data array for display of side menu e-shop itmes not limited by applied paging limit
                'nonpaginated_data_for_menu' => $model->where('is_published', '1')->where('product_subcategory', $selected_subcategory)->orderBy('id', 'DESC')->paginate(),
            ];

                
            };

       } else { // if subcategory is none then filter along main product:category
            if(session()->get('role') == 'admin') { // if admin loged in thend dont filter published but display all to ability manage them
                $data = [
                    //'eshop'  => $model->geteshop(),
                    'title' => 'Our latest e-shop products are here ...',
                    'eshop' => $model->where('product_category', $selected_category)->orderBy('id', 'DESC')->paginate(3),
                    'pager' => $model->pager,

                    //"nonpaginated" data array for display of side menu e-shop itmes not limited by applied paging limit
                    'nonpaginated_data_for_menu' => $model->orderBy('id', 'DESC')->paginate(),
                ];
        
            } else { // coomon user see only published articles

            $data = [
                //'eshop'  => $model->geteshop(),
                'title' => 'Our latest e-shop products are here ...',
                'eshop' =>  $model->where('product_category', $selected_category)->orderBy('id', 'DESC')->paginate(3),
                'pager' => $model->pager,
                'nonpaginated_data_for_menu' =>  $model->where('product_category', $selected_category)->orderBy('id', 'DESC')->paginate(),
            ];

                
            };

       }

       

        /* pagination config */
        /* Customizing the Links
           View Configuration
           When the links are rendered out to the page, they use a view file to describe the HTML. You can easily change the view that is used by editing app/Config/Pager.php:
        */

        
    
        echo view('templates/header', $data);
        echo view('eshop/overview', $data);
        echo view('templates/footer', $data);
    }

    public function cart()
    {   /* older aproach using only product table for marking bought product, now we read from order table
        $model = new EshopModel();
    
       

           // send data to view for recreating list of user added items to cart

           $data = [
            //'eshop'  => $model->geteshop(),
            'title' => 'Your cart contains these items ...',
            'eshop' => $model->where('user_cart', session()->get('id'))->orderBy('id', 'DESC')->paginate(10), // read data marked with user_id in user_cart field in database
            'pager' => $model->pager,
        ];    */

        $db      = \Config\Database::connect();
               
                $builder = $db->table('order');
                $builder->select('*');
                $builder->join('eshop', 'eshop.id = order.product_id');
                $builder->where(array('user_id', session()->get('id')))->where('confirmed_order', '0'); //->orderBy('product_id', 'DESC');
                                                                         // >where('confirmed_order', '0'); display only non finaly confirmed items
                $data_aux =  $builder->get()->getResultArray();

    
        
        $data = [
            //'eshop'  => $model->geteshop(),
            'title' => 'Your cart contains these items ...',
            'eshop' => $data_aux  , // read data marked with user_id in user_cart field in database
           
        ];    
       

        
    
        echo view('templates/header', $data);
        echo view('eshop/cart', $data);
        echo view('templates/footer', $data);
    }

    /* Next, there are two methods, one to view all eshop items, 
    and one for a specific eshop item. You can see that the $slug variable is passed to the model’s method in the second method. 
    The model is using this slug to identify the eshop item to be returned. */

    public function view($slug = null)
    {
        $model = new EshopModel();
    
        $data['eshop'] = $model->getProducts($slug);
    
        if (empty($data['eshop']))
        {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Cannot find the eshop item: '. $slug);
        }
    
       // $data['title'] = $data['eshop']['title'];
    
        echo view('templates/header', $data);
        echo view('eshop/view', $data);
        echo view('templates/footer', $data);
    }

    public function create() // for further reading please visit https://codeigniter.com/user_guide/tutorial/create_eshop_items.html, 24.4.2021
    {
        $model = new eshopModel();
        // if first run provide category/ subcategory data for create view
        $data ['eshop'] = $model->list_category_subcategory();

        echo view('templates/header', ['title' => 'Create a eshop item']);
        echo view('eshop/create', $data );
        echo view('templates/footer');


        // if data submitted

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
                        'id' => $this->request->getPost('id'),
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

    /**
     * action function handle ajax request from product create form responsible for selective populatin subcategory select field in context of selected product category
     */
    public function action(){
        if($this->request->getVar('action'))
        {
            $action = $this->request->getVar('action');

            if($action == 'get_subcategory'){
                $model = new eshopModel();
                // if first run provide category/ subcategory data for create view
                $subcategorydata = $model->list_subcategory_subcategory($this->request->getVar('product_category'));
              // $subcategorydata = $model->where('product_category', $this->request->getVar('product_category'))->findAll;
                echo json_encode($subcategorydata);

            }
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
            if ($data['eshop']['picture_name_1'] != "no_image.png") {
                unlink('./eshop_images/'.$data['eshop']['picture_name_1']);
            }
            if ($data['eshop']['picture_name_2'] != "no_image.png") {
                unlink('./eshop_images/'.$data['eshop']['picture_name_2']);
            }
            if ($data['eshop']['picture_name_3'] != "no_image.png") {
                unlink('./eshop_images/'.$data['eshop']['picture_name_3']);
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
                       // 'uploaded[eshop_image_file1]',
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
                // image is absent  -> nothing change  - reread older values
                    
                    $data['eshop'] = $model->getID($id);
                    $newName1 = $data['eshop']['picture_name_1'] ;
                    $eshop_image_type1 = $data['eshop']['picture_type_1'] ;
                }
    
                $eshop_image2 = $this->request->getFile('eshop_image_file2'); // creating object of uploaded 
                if ($eshop_image2 !="") {
                // image is present then proceed with them and save its name
                    $newName2 = $eshop_image2->getRandomName(); // generate new random name
                    $eshop_image_type2 = $eshop_image2->getMimeType();
                    $eshop_image2 = $eshop_image2->move('./eshop_images', $newName2); //picture is moved into a images folder nested in public folder
                } else {
                // image is absent  -> nothing change  - reread older values
                    
                    $data['eshop'] = $model->getID($id);
                    $newName2 = $data['eshop']['picture_name_2'] ;
                    $eshop_image_type2 = $data['eshop']['picture_type_2'] ;
                }
    
                $eshop_image3 = $this->request->getFile('eshop_image_file3'); // creating object of uploaded 
                if ($eshop_image3 !="") {
                // image is present then proceed with them and save its name
                    $newName3 = $eshop_image3->getRandomName(); // generate new random name
                    $eshop_image_type3 = $eshop_image3->getMimeType();
                    $eshop_image3 = $eshop_image3->move('./eshop_images', $newName3); //picture is moved into a images folder nested in public folder
                } else {
                // image is absent  -> nothing change  - reread older values
                    
                    $data['eshop'] = $model->getID($id);
                    $newName3 = $data['eshop']['picture_name_3'] ;
                    $eshop_image_type3 = $data['eshop']['picture_type_3'] ;
                }
                
              
                
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
                        'id' => $id,
                        'peoduct_id' => $this->request->getPost('product_id'),
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

                // if first run provide category/ subcategory data for create view
                $data ['eshop_category_list'] = $model->list_category_subcategory();
               
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



 

    public function add_to_cart($id) // add product to cart - set user_cart field to current user id
    {
        
       
       // mark product - but when we have order table only decrease number of items and in next step create new order recors (new approach)
              /*  $db      = \Config\Database::connect();
                $builder = $db->table('eshop');
    
                //$builder->selectMax('id');
                $builder->where('id', $id)->set('user_cart', session()->get('id'));
               // insert create new article, but we will update existing $builder->insert();
                $builder-> update(); // for reference please visit https://codeigniter.com/user_guide/database/query_builder.html?highlight=select#updating-data */

          // 0. get number of obtained products
          // not implemented - only one item can be ordered - number of items adjustment can be done through cart in later implementation   
          $data = [
            //'eshop'  => $model->geteshop(),
            'message' => '',
            'message_type' => '',
           ];
          
          // read data about ordered products
          $model_eshop = new eshopModel();
          $data['eshop'] = $model_eshop->getID($id);
          $_calculated_total_price_without_DPH = $data['eshop']['product_price'];

          //I. decrease number of items
          if($data['eshop']['nr_of_items_on_store']>0 ) { // decrease only if number of item is 1 ore more on store
                $db      = \Config\Database::connect();
                $builder = $db->table('eshop');
    
                //$builder->selectMax('id');
                $builder->where('id', $id)->set('nr_of_items_on_store', 'nr_of_items_on_store-1',  false);
               // insert create new article, but we will update existing $builder->insert();
                $builder-> update(); // for reference please visit https://codeigniter.com/user_guide/database/query_builder.html?highlight=select#updating-data
            }
          
          //II. create records in order table
                
                $model_order = new orderModel();

                // check if enough products on store, if not write message and does not add item to order list
                if($data['eshop']['nr_of_items_on_store']>0 ) {
                    // product can be bought is available on store
                    $model_order->save([
                        'user_id'  => session()->get('id'),
                        'product_id' => $id,
                        'number_of_ordered_items' => '1',
                        'total_price' => $_calculated_total_price_without_DPH,
                        'state_of_order' => 'waiting',
                        'main_order_number'=> session()->get('id') // rework with adding date or time stamp
                      ]);  
                      
                     
                        $message = 'Item <b>'. $data['eshop']['product_name'] . '</b> has been succesfully aded to your cart. For further reference go to cart and adjust number of ordered items or remove
                                    item for order listening instead.';
                        $message_type = "msg_success";            
                       

                } else {
                    // product can not to be bought because is sold
                   
                        //'eshop'  => $model->geteshop(),
                        $message= 'Item has not to be added in to a order, because is not available on store. Please chose another item instad or contact our
                                       helpdesk for further info.';
                        $message_type = "msg_error";                
                       
                }


               


        // send data after publishing to view
        $model = new eshopModel();
    
        if(session()->get('role') == 'admin') { // if admin loged in thend dont filter published but display all to ability manage them
            $data = [
                //'eshop'  => $model->geteshop(),
                'message' =>  $message,
                'message_type' =>  $message_type,
                'title' => 'eshop archive',
                'eshop' => $model->orderBy('id', 'DESC')->paginate(3),
                'pager' => $model->pager,
            ];
    
        } else { // coomon user see only published articles

           $data = [
            //'eshop'  => $model->geteshop(),
            'message' =>  $message,
            'message_type' =>  $message_type,
            'title' => 'eshop archive',
            'eshop' => $model->where('is_published', '1')->orderBy('id', 'DESC')->paginate(3),
            'pager' => $model->pager,
           ];
        
        };

       

        echo view('templates/header');
        echo view('eshop/overview', $data ); // return into main eshop page 
        echo view('templates/footer');
    }   
    
    public function remove_from_cart($id) // remove product from cart - set user_cart back to default value 0 - our new aproach using order table does not need this function anymore
    {
        
        //find record with appropriate id and change value of item
        // $model->where('id', $id)->set('is_published', '0');
        $db      = \Config\Database::connect();
        $builder = $db->table('eshop');

        //$builder->selectMax('id');
        $builder->where('id', $id)->set('user_cart', '0');
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
    
    
    

    public function remove_from_cart_return_to_cart($id) // remove product from cart - set user_cart back to default value 0
    {
       /* old aproach
        //find record with appropriate id and change value of item
        // $model->where('id', $id)->set('is_published', '0');
        $db      = \Config\Database::connect();
        $builder = $db->table('eshop');

        //$builder->selectMax('id');
        $builder->where('id', $id)->set('user_cart', '0');
       // $builder->insert();
        $builder-> update();

        */
         // 0. get number of obtained products
          // not implemented - only one item can be ordered - number of items adjustment can be done through cart in later implementation   
          $data = [
            //'eshop'  => $model->geteshop(),
            'message' => '',
            'message_type' => '',
           ];
          // from order order_id read appropriate product_id to look into a product
          $model_order = new orderModel();
          $orders_list = $model_order->getID($id);

          // read data about ordered products
          $model_eshop = new eshopModel();
          $data['eshop'] = $model_eshop->getID($orders_list['product_id']);
          $_calculated_total_price_without_DPH = $data['eshop']['product_price'];

          //I. increase number of items - because item is returnet from user cart
                $db      = \Config\Database::connect();
                $builder = $db->table('eshop');
    
                //$builder->selectMax('id');
                $builder->where('id', $orders_list['product_id'])->set('nr_of_items_on_store', 'nr_of_items_on_store+1', false);
               // insert create new article, but we will update existing $builder->insert();
                $builder-> update(); // for reference please visit https://codeigniter.com/user_guide/database/query_builder.html?highlight=select#updating-data
          
          
          //II. delete records in order table
                
                $model_order = new orderModel();

                // find appropriate record and delete them from order table
                $model_order->where('order_id', $id)->delete();
               

        // send data after publishing to view - use join to combine order and product tables

        $db      = \Config\Database::connect();
               
        $builder = $db->table('order');
        $builder->select('*');
        $builder->join('eshop', 'eshop.id = order.product_id');
        $builder->where(array('user_id', session()->get('id'))); //->orderBy('product_id', 'DESC');
        $data_aux =  $builder->get()->getResultArray();



        $data = [
            //'eshop'  => $model->geteshop(),
            'title' => 'Your cart contains these items ...',
            'eshop' => $data_aux  , // read data marked with user_id in user_cart field in database
        
        ];    




       /* older simple aproach using only eshop table without order  $model = new eshopModel();
    
        $data = [
            //'eshop'  => $model->geteshop(),
            'title' => 'Your cart contains these items ...',
            'eshop' => $model->where('user_cart', session()->get('id'))->orderBy('id', 'DESC')->paginate(10), // read data marked with user_id in user_cart field in database
            'pager' => $model->pager,
        ]; */


        echo view('templates/header');
        echo view('eshop/cart', $data ); // return into main eshop page 
        echo view('templates/footer');
    }  

    public function add_item($id) // adds another product of appropriate type to cart (multiply same items in cart page listening after clicking + button)
    { // id is order_id from order table
        
       
           // 0. get number of obtained products
          // not implemented - only one item can be ordered - number of items adjustment can be done through cart in later implementation   
          $data = [
            //'eshop'  => $model->geteshop(),
            'message' => '',
            'message_type' => '',
           ];
          // from order order_id read appropriate product_id to look into a product
          $model_order = new orderModel();
          $orders_list = $model_order->getID($id);

          // read data about ordered products
          $model_eshop = new eshopModel();
          $data['eshop'] = $model_eshop->getID($orders_list['product_id']);
          $_calculated_total_price_without_DPH = $data['eshop']['product_price'];

          if($data['eshop']['nr_of_items_on_store']>0 ) { // decrease only if number of item is 1 ore more on store
            //I. decrease number of items in eshop - because item is added into a cart
                    $db      = \Config\Database::connect();
                    $builder = $db->table('eshop');
        
                    //$builder->selectMax('id');
                    $builder->where('id', $orders_list['product_id'])->set('nr_of_items_on_store', 'nr_of_items_on_store-1', false);
                // insert create new article, but we will update existing $builder->insert();
                    $builder-> update(); // for reference please visit https://codeigniter.com/user_guide/database/query_builder.html?highlight=select#updating-data
            
            // II. increase number of items and recalculate price in order table
                    
                    $builder = $db->table('order');

                    //$builder->selectMax('id');
                    $builder->where('product_id', $orders_list['product_id'])->set('number_of_ordered_items', 'number_of_ordered_items+1', false);
                    // insert create new article, but we will update existing $builder->insert();
                    $builder-> update(); // for reference please visit https://codeigniter.com/user_guide/database/query_builder.html?highlight=select#updating-data
    
          }
               

        // send data after publishing to view - use join to combine order and product tables

        $db      = \Config\Database::connect();
               
        $builder = $db->table('order');
        $builder->select('*');
        $builder->join('eshop', 'eshop.id = order.product_id');
        $builder->where(array('user_id', session()->get('id'))); //->orderBy('product_id', 'DESC');
        $data_aux =  $builder->get()->getResultArray();



        $data = [
            //'eshop'  => $model->geteshop(),
            'title' => 'Your cart contains these items ...',
            'eshop' => $data_aux  , // read data marked with user_id in user_cart field in database
        
        ];    




       /* older simple aproach using only eshop table without order  $model = new eshopModel();
    
        $data = [
            //'eshop'  => $model->geteshop(),
            'title' => 'Your cart contains these items ...',
            'eshop' => $model->where('user_cart', session()->get('id'))->orderBy('id', 'DESC')->paginate(10), // read data marked with user_id in user_cart field in database
            'pager' => $model->pager,
        ]; */


        echo view('templates/header');
        echo view('eshop/cart', $data ); // return into main eshop page 
        echo view('templates/footer');
    }   

    public function sub_item($id) // adds another product of appropriate type to cart (multiply same items in cart page listening after clicking + button)
    { // id is order_id from order table
        
       
           // 0. get number of obtained products
          // not implemented - only one item can be ordered - number of items adjustment can be done through cart in later implementation   
          $data = [
            //'eshop'  => $model->geteshop(),
            'message' => '',
            'message_type' => '',
           ];
          // from order order_id read appropriate product_id to look into a product
          $model_order = new orderModel();
          $orders_list = $model_order->getID($id);

          // read data about ordered products
          $model_eshop = new eshopModel();
          $data['eshop'] = $model_eshop->getID($orders_list['product_id']);
          $_calculated_total_price_without_DPH = $data['eshop']['product_price'];

          if($orders_list['number_of_ordered_items']>1 ) { // if number is heigher than 0
            //I. increase number of items in eshop - because item is removed from a cart
                    $db      = \Config\Database::connect();
                    $builder = $db->table('eshop');
        
                    //$builder->selectMax('id');
                    $builder->where('id', $orders_list['product_id'])->set('nr_of_items_on_store', 'nr_of_items_on_store+1', false);
                // insert create new article, but we will update existing $builder->insert();
                    $builder-> update(); // for reference please visit https://codeigniter.com/user_guide/database/query_builder.html?highlight=select#updating-data
            
            // II. decrease number of items and recalculate price in order table
                    
                    $builder = $db->table('order');

                    //$builder->selectMax('id');
                    $builder->where('product_id', $orders_list['product_id'])->set('number_of_ordered_items', 'number_of_ordered_items-1', false);
                    // insert create new article, but we will update existing $builder->insert();
                    $builder-> update(); // for reference please visit https://codeigniter.com/user_guide/database/query_builder.html?highlight=select#updating-data
    
          } else  if($orders_list['number_of_ordered_items'] == 1 ){ // if number is = 1 then coppletly delete row from order table


                  //I. increase number of items in eshop - because item is removed from a cart
                  $db      = \Config\Database::connect();
                  $builder = $db->table('eshop');
      
                  //$builder->selectMax('id');
                  $builder->where('id', $orders_list['product_id'])->set('nr_of_items_on_store', 'nr_of_items_on_store+1', false);
                 // insert create new article, but we will update existing $builder->insert();
                  $builder-> update(); // for reference please visit https://codeigniter.com/user_guide/database/query_builder.html?highlight=select#updating-data
          
                // II. but delete that item
                $model_order = new orderModel();

                // find appropriate record and delete them from order table
                $model_order->where('order_id', $id)->delete();
                  
                 
          }
               

        // send data after publishing to view - use join to combine order and product tables

        $db      = \Config\Database::connect();
               
        $builder = $db->table('order');
        $builder->select('*');
        $builder->join('eshop', 'eshop.id = order.product_id');
        $builder->where(array('user_id', session()->get('id'))); //->orderBy('product_id', 'DESC');
        $data_aux =  $builder->get()->getResultArray();



        $data = [
            //'eshop'  => $model->geteshop(),
            'title' => 'Your cart contains these items ...',
            'eshop' => $data_aux  , // read data marked with user_id in user_cart field in database
        
        ];    




       /* older simple aproach using only eshop table without order  $model = new eshopModel();
    
        $data = [
            //'eshop'  => $model->geteshop(),
            'title' => 'Your cart contains these items ...',
            'eshop' => $model->where('user_cart', session()->get('id'))->orderBy('id', 'DESC')->paginate(10), // read data marked with user_id in user_cart field in database
            'pager' => $model->pager,
        ]; */


        echo view('templates/header');
        echo view('eshop/cart', $data ); // return into main eshop page 
        echo view('templates/footer');
    }   

    /* make_order function is responsible for taking main_order_number and process order */
    public function make_order() { //

        // send data after publishing to view - use join to combine order and product tables


        // if data submited succesfully
        if ($this->request->getMethod() === 'post' && $this->validate([
            'first_name' => 'required|min_length[2]|max_length[255]',
            'last_name' => 'required|min_length[2]|max_length[255]',
            'delivery_type'  => 'required',
            'delivery_street'  => 'required',
            'delivery_state'  => 'required',
            'delivery_city'  => 'required',
            'ZIPcode'  => 'required',
            'GDPRaccept'  => 'required',
            'ShopServiceLawAccept'  => 'required',
            
        ]))
    {
       
        
        
        // The move() method returns a new File instance that for the relocated file, so you must capture the result if the resulting location is needed:
            $model_final_order = new FinalOrderModel();

            if(session()->get('id')== null) { // anonymous user - not loged in
                $model_final_order->save([
                    'first_name' => $this->request->getPost('first_name'),
                    'last_name' => $this->request->getPost('last_name'),
                    'delivery_type' => $this->request->getPost('delivery_type'),
                    'delivery_street' => $this->request->getPost('delivery_street'),
                    'delivery_state' => $this->request->getPost('delivery_state'),
                    'delivery_city' => $this->request->getPost('delivery_city'),
                    'ZIPcode' => $this->request->getPost('ZIPcode'),
                    'GDPRaccept'  => $this->request->getPost('GDPRaccept'),
                    'ShopServiceLawAccept'  => $this->request->getPost('ShopServiceLawAccept'),
                    'user_id'  => '0' 
                ]);    
            } else { // loged in user - session contains their user_id or id
                $model_final_order->save([
                    'first_name' => $this->request->getPost('first_name'),
                    'last_name' => $this->request->getPost('last_name'),
                    'delivery_type' => $this->request->getPost('delivery_type'),
                    'delivery_street' => $this->request->getPost('delivery_street'),
                    'delivery_state' => $this->request->getPost('delivery_state'),
                    'delivery_city' => $this->request->getPost('delivery_city'),
                    'ZIPcode' => $this->request->getPost('ZIPcode'),
                    'GDPRaccept'  => $this->request->getPost('GDPRaccept'),
                    'ShopServiceLawAccept'  => $this->request->getPost('ShopServiceLawAccept'),
                    'user_id'  => session()->get('id')
                ]);    
                
            };

        
        
        //$data['eshop'] = $model->getLatest(); this approach does not work because i cann note order_by and take first() element but all data ara available 
        // and can by simply passed by on from send post
        $data_order  = [
            'first_name' => $this->request->getPost('first_name'),
            'last_name' => $this->request->getPost('last_name'),
            'delivery_type' => $this->request->getPost('delivery_type'),
            'delivery_street' => $this->request->getPost('delivery_street'),
            'delivery_state' => $this->request->getPost('delivery_state'),
            'delivery_city' => $this->request->getPost('delivery_city'),
            'ZIPcode' => $this->request->getPost('ZIPcode'),
            'GDPRaccept'  => $this->request->getPost('GDPRaccept'),
            'ShopServiceLawAccept'  => $this->request->getPost('ShopServiceLawAccept'),
            'user_id'  => session()->get('id')
        ] ;
        //mark all items from processed and confirmed order as confirmed_order in order table
        $db      = \Config\Database::connect();
        
        // part I. - update confirmed order
        $builder = $db->table('order');
        $builder->select('*');
        $builder->join('eshop', 'eshop.id = order.product_id');
        $builder->where(array('user_id', session()->get('id')))->set('confirmed_order', '1'); //->orderBy('product_id', 'DESC');
        $builder-> update();

        // part II. obtain correct data for display of ordered items

        $builder = $db->table('order');
        $builder->select('*');
        $builder->join('eshop', 'eshop.id = order.product_id');
        $builder->where(array('user_id', session()->get('id')))->where('confirmed_order', '0'); //->orderBy('product_id', 'DESC');
        
        $data_aux =  $builder->get()->getResultArray();

        $data = [
            //compose array of data available into a view
            'title' => 'Order successful and confirmed_order set to 1',
            'eshop' => $data_aux  , // read data marked with user_id in user_cart field in database
            'final_order' => $data_order  ,
        
        ];    
        
        
        echo view('templates/header', ['title' => 'Create a eshop item']);
        echo view('eshop/ordered_succesfully', $data );
        echo view('templates/footer');
    }
    else
    { // if data has not to be posted
       
        $db      = \Config\Database::connect();
               
        $builder = $db->table('order');
        $builder->select('*');
        $builder->join('eshop', 'eshop.id = order.product_id');
        $builder->where(array('user_id', session()->get('id')))->where('confirmed_order', '0'); //->orderBy('product_id', 'DESC');
        
        $data_aux =  $builder->get()->getResultArray();
       

        // dummy data for testing purpouses only
        $data = [
            //'eshop'  => $model->geteshop(),
            'title' => 'Here we continous with order fullfilment ...',
            'eshop' => $data_aux  , // read data marked with user_id in user_cart field in database
            
        
        ];  
        
        


        echo view('templates/header');
        echo view('eshop/make_order', $data ); // return into main eshop page 
        echo view('templates/footer');
    }



    }

}