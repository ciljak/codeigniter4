<?php

namespace App\Controllers;
// here list all models that are necessary for data access in appropriate controller  - because all common pages use this controller models for contact or guestbook must be added here
use App\Models\ContactusModel;

use CodeIgniter\Controller;
/*********************************
 *  Pagination in code igniter - for further reference please visit https://codeigniter.com/user_guide/libraries/pagination.html, 23.5.2021
 */
$pager = \Config\Services::pager();

class Contactus extends Controller
{
    public function index()
    {
        $model = new ContactusModel();

        $data = [
           // 'contactus'  => $model->getContactusPosts(),
           'contactus' => $model->orderBy('id', 'DESC')->paginate(5), // after use pagination, ordering must be implemented here - method in model is not used
           'pager' => $model->pager,
            
        ];
        
       /* if (empty($data['contactus']))
            {
                throw new \CodeIgniter\Exceptions\PageNotFoundException('Cannot find the contactitem: ');
            } */
    
        

        echo view('templates/header', ['title' => 'Contact us']);
        echo view('contactus/contactus', $data );
        echo view('templates/footer');
    }

    public function view($slug = null)   // not in use in this approach where guestbook is separated in its own folder
    {
        $model = new ContactusModel();

        $data = [
            'guestbook'  => $model->getContactusPosts(),
            
        ];
     if (empty($data['guestbook']))
        {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Cannot find the guestbookitem: '. $name);
        }
    
        

        echo view('templates/header', ['title' => 'Contact us']);
        echo view('guestbook/contactus', $data );
        echo view('templates/footer');
    
       
    
       
    
        
    }

    

    /**
     *  GUESTBOOK methods handling responsibility for - add, delete or update guestbook posts
     */

    /* add or delete guestbook post part */
    public function Guestbook_single_view($slug = null)
    {
        $model = new GuestbookModel();
    
        $data['guestbook'] = $model->getContactusPosts($slug);
    
        if (empty($data['guestbook']))
        {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Cannot find the news item: '. $slug);
        }
    
        $data['title'] = $data['guestbook']['name_of_writer'];
    
        echo view('templates/header', $data);
        echo view('guestbook/guestbook_single_view', $data);
        echo view('templates/footer', $data);
    }

    public function contactus_add_post() // for further reading please visit https://codeigniter.com/user_guide/tutorial/create_news_items.html, 24.4.2021
        {
            $model = new ContactusModel();
    
            if ($this->request->getMethod() === 'post' && $this->validate([
                    'name' => 'required|min_length[3]|max_length[255]',
                    'email' => 'required|valid_email',
                    'message_text'  => 'required',
                    
                ]))
            {
                
                // The move() method returns a new File instance that for the relocated file, so you must capture the result if the resulting location is needed:
                $model->save([
                        'name' => $this->request->getPost('name'),
                        'email' => $this->request->getPost('email'),
                        'message_text'  => $this->request->getPost('message_text'),
                        'user_id'  => session()->get('id'), // user id passed to a sesion
                        
                ]);    
                
               
    
                
                // part responsible for reading all guestbook osts and passing them into a view
                $data = [
                    //'contactus'  => $model->getContactusPosts(),
                    'contactus' => $model->orderBy('id', 'DESC')->paginate(5), // after use pagination, ordering must be implemented here - method in model is not used
                    'pager' => $model->pager,
                    
                ];
    
    
                echo view('templates/header', ['title' => 'Contact us']);
                echo view('contactus/contactus', $data );
                echo view('templates/footer');
            }
            else
            {   // part responsible for display a error messages if data not validated or post does not went succesfully
                echo view('templates/header', ['title' => 'Contact us']);
                echo view('contactus/contactus_err');
                echo view('templates/footer');
            }
        }

        public function delete_contactus_article($id) {

            $model = new ContactusModel();
           
                // first obtain data that will be deleted for passing into view informing about data deletion
                $data['contactus'] = $model->getContactusID($id);
                        
                
                $model->where('id', $id)->delete();
                   
                echo view('templates/header');
                echo view('contactus/delete_contactus_article',$data);
                echo view('templates/footer');
           
            }
    
            public function update_contactus_article($id) {
    
                $model = new ContactusModel();
        
    
                    if ($this->request->getMethod() === 'post' && $this->validate([
                        'name' => 'required|min_length[3]|max_length[255]',
                        'email' => 'required|valid_email',
                        'message_text'  => 'required',
                        
                    ]))
                {
                    
                    $model->save([
                            'id' => $id,
                            'name' => $this->request->getPost('name'),
                            'email' => $this->request->getPost('email'),
                            'message_text'  => $this->request->getPost('message_text'),
                            
                    ]);    
                    
                  
                     // part responsible for reading all contact posts and passing them into a view
                $data = [
                    'contactus'  => $model->getContactusPosts(),
                    
                ];
    
    
                    echo view('templates/header', ['title' => 'Contact message list - updated']);
                    echo view('contactus/contactus', $data );
                    echo view('templates/footer');
                }
                else
                {
                     // first obtain data that will be deleted for passing into view informing about data deletion
                    $data['contactus'] = $model->getContactusID($id);
                   
                    echo view('templates/header', ['title' => 'Update a contact message item']);
                    echo view('contactus/update_contactus_article', $data );
                    echo view('templates/footer');
                }
                 
               
        
                }



   /**
     *  CONTACTUS methods handling responsibility for - contac us page functionality
     */      



}