<?php

namespace App\Controllers;
// here list all models that are necessary for data access in appropriate controller  - because all common pages use this controller models for contact or guestbook must be added here
use App\Models\GuestbookModel;
use App\Models\NewsModel;
use app\Helpers;

use CodeIgniter\Controller;

class Pages extends Controller
{
    public function index()
    {
        return view('welcome_message');
    }

    public function view($page = 'home') // controler method responsible for common display of all pages
    {

        // load helpers for photo gallery -  read https://roytuts.com/codeigniter-photo-gallery/
            // It loads the required helper classes. If you want, you may auto-load them in application/config/auto-load.php file.
        //$this->load->helper('url');
		//$this->load->helper('directory');
        helper('directory');
        helper('url');
		//$this->load->view('photo_gallery');

        if ( ! is_file(APPPATH.'/Views/pages/'.$page.'.php'))
        {
            // Whoops, we don't have a page for that!
            throw new \CodeIgniter\Exceptions\PageNotFoundException($page);
        }
    
        $data['title'] = ucfirst($page); // Capitalize the first letter

        /* this part adapt data that will be read from model and send to approprite page - as example for the guestbook we read all posts from database and pass them into a view */
        switch($page) {
            case "guestbook"  :
                {
                    $model = new GuestbookModel();
                    $data = [
                        'guestbook'  => $model->getGuestPosts(),
                        
                    ];
            
            
                    echo view('templates/header', ['title' => 'Guestbook']);
                    echo view('pages/guestbook', $data );
                    echo view('templates/footer');
                }
            case "delete_guestbook_article"  :
                {
                    delete_guestbook_article($id);
                } 
            case "about"  :
                {
                $model = new NewsModel();
    
                $data = [
                    'news'  => $model->getLatestNews(),
                    'title' => 'News archive',
                ];
            
            
                    echo view('templates/header', ['title' => 'Guestbook']);
                    echo view('pages/about', $data );
                    echo view('templates/footer');
                }        
            break; //optional - for next pages that need obtain data from model representing a data stored in a database */
           // case constant-expression  :
             //  statement(s);
            //   break; //optional
           
            // this part handle default page behaviour
            default : 
            echo view('templates/header', $data);
            echo view('pages/'.$page, $data);
            echo view('templates/footer', $data);
         }

    
        
    }

    /**
     *  GUESTBOOK methods handling responsibility for - add, delete or update guestbook posts
     */

    /* add or delete guestbook post part */
    public function Guestbook_single_view($slug = null)
    {
        $model = new GuestbookModel();
    
        $data['guestbook'] = $model->getGuestPosts($slug);
    
        if (empty($data['guestbook']))
        {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Cannot find the news item: '. $slug);
        }
    
        $data['title'] = $data['guestbook']['name_of_writer'];
    
        echo view('templates/header', $data);
        echo view('pages/guestbook_single_view', $data);
        echo view('templates/footer', $data);
    }

    public function guestbook_add_post() // for further reading please visit https://codeigniter.com/user_guide/tutorial/create_news_items.html, 24.4.2021
        {
            $model = new GuestbookModel();
    
            if ($this->request->getMethod() === 'post' && $this->validate([
                    'name_of_writer' => 'required|min_length[3]|max_length[255]',
                    'email' => 'required|valid_email',
                    'message_text'  => 'required',
                    'guestbook_image_file' => [
                        'uploaded[guestbook_image_file]',
                        'mime_in[guestbook_image_file,image/jpg,image/jpeg,image/gif,image/png]',
                        'max_size[guestbook_image_file,12096]',
                    ],
                ]))
            {
                $guestbook_image = $this->request->getFile('guestbook_image_file'); // creating object of uploaded image
    
                
                $newName = $guestbook_image->getRandomName(); // generate new random name
                $guestbook_image_type = $guestbook_image->getMimeType();
               
                $guestbook_image = $guestbook_image->move('./images', $newName); //picture is moved into a images folder nested in public folder
                
                // The move() method returns a new File instance that for the relocated file, so you must capture the result if the resulting location is needed:
                $model->save([
                        'name_of_writer' => $this->request->getPost('name_of_writer'),
                        'email' => $this->request->getPost('email'),
                        'slug'  => url_title($this->request->getPost('name_of_writer'), '-', TRUE),
                        'message_text'  => $this->request->getPost('message_text'),
                        'picture_name' => $newName, //$newName , //$newName, //  or if orignal upload name is $news_image->usedgetClientName(),
                        'picture_type'  => $guestbook_image_type
                ]);    
                
                //$data['news'] = $model->getLatest(); this approach does not work because i cann note order_by and take first() element but all data ara available 
                // and can by simply passed by on from send post
               /* $data ['guestbook'] = [
                        'name_of_writer' => $this->request->getPost('name_of_writer'),
                        'email' => $this->request->getPost('email'),
                        
                        'message_text'  => $this->request->getPost('message_text'),
                        'picture_name' => $newName, //$newName , //$newName, //  or if orignal upload name is $news_image->usedgetClientName(),
                        'picture_type'  => $guestbook_image_type
                ] ; */
    
                
                // part responsible for reading all guestbook osts and passing them into a view
                $data = [
                    'guestbook'  => $model->getGuestPosts(),
                    
                ];
    
    
                echo view('templates/header', ['title' => 'Create a news item']);
                echo view('pages/guestbook', $data );
                echo view('templates/footer');
            }
            else
            {   // part responsible for display a error messages if data not validated or post does not went succesfully
                echo view('templates/header', ['title' => 'Create a news item']);
                echo view('pages/guestbook_err');
                echo view('templates/footer');
            }
        }

        public function delete_guestbook_article($id) {

            $model = new GuestbookModel();
            console.log("It works"); 
            console.log("Obtained id".$id); 
                // first obtain data that will be deleted for passing into view informing about data deletion
                $mydata['guestbook'] = $model->getGuestID($id);
            
            
                // delete related image
                helper('filesystem'); // load helper - for more please read https://codeigniter.com/user_guide/helpers/filesystem_helper.html, 1.5.2021 
                    // delete appropriate file
                    /*  echo '<?=base_url()?>/public/images/'.$data['news']['picture_name']; - for debug of delete link creation*/ 
                    /* delete_files('<?=base_url()?>/public/images/'.$data['news']['picture_name'], true); */
                    unlink('./images/'.$data['guestbook']['picture_name']);
               
                
                $model->where('id', $id)->delete();
    
               
               
                echo view('templates/header');
                echo view('pages/delete_guestbook_article',$mydata);
              
                echo view('templates/footer');
           
    
            }
    
            public function update_guestbook_article($id) {
    
                $model = new GuestbookModel();
        
                   
    
    
                    if ($this->request->getMethod() === 'post' && $this->validate([
                        'name_of_writer' => 'required|min_length[3]|max_length[255]',
                        'email' => 'required|valid_email',
                        'message_text'  => 'required',
                        'guestbook_image_file' => [
                            'uploaded[guestbook_image_file]',
                            'mime_in[guestbook_image_file,image/jpg,image/jpeg,image/gif,image/png]',
                            'max_size[guestbook_image_file,12096]',
                        ],
                    ]))
                {
                    $guestbook_image = $this->request->getFile('guestbook_image_file'); // creating object of uploaded image
    
                
                    $newName = $guestbook_image->getRandomName(); // generate new random name
                    $guestbook_image_type = $guestbook_image->getMimeType();
                   
                    $guestbook_image = $guestbook_image->move('./images', $newName); //picture is moved into a images folder nested in public folder
                    
                    // The move() method returns a new File instance that for the relocated file, so you must capture the result if the resulting location is needed:
                    $model->save([
                            'name_of_writer' => $this->request->getPost('name_of_writer'),
                            'email' => $this->request->getPost('email'),
                            'slug'  => url_title($this->request->getPost('name_of_writer'), '-', TRUE),
                            'message_text'  => $this->request->getPost('message_text'),
                            'picture_name' => $newName, //$newName , //$newName, //  or if orignal upload name is $news_image->usedgetClientName(),
                            'picture_type'  => $guestbook_image_type
                    ]);    
                    
                    //$data['news'] = $model->getLatest(); this approach does not work because i cann note order_by and take first() element but all data ara available 
                    // and can by simply passed by on from send post
                     // part responsible for reading all guestbook osts and passing them into a view
                $data = [
                    'guestbook'  => $model->getGuestPosts(),
                    
                ];
    
    
                    echo view('templates/header', ['title' => 'Guestbook - updated']);
                    echo view('pages/guestbook', $data );
                    echo view('templates/footer');
                }
                else
                {
                     // first obtain data that will be deleted for passing into view informing about data deletion
                    $data['guestbook'] = $model->getGuestID($id);
                   
                    echo view('templates/header', ['title' => 'Update a news item']);
                    echo view('pages/update_guestbook_article', $data );
                    echo view('templates/footer');
                }
                 
               
        
                }



   /**
     *  CONTACTUS methods handling responsibility for - contac us page functionality
     */      



}