<?php
// for further reference please visit https://codeigniter.com/user_guide/tutorial/news_section.html, 24.4.2021
namespace App\Controllers;

use App\Models\NewsModel;
use CodeIgniter\Controller;

class News extends Controller
{
    public function index()
    {
        $model = new NewsModel();
    
        $data = [
            'news'  => $model->getNews(),
            'title' => 'News archive',
        ];
    
        echo view('templates/header', $data);
        echo view('news/overview', $data);
        echo view('templates/footer', $data);
    }

    /* Next, there are two methods, one to view all news items, 
    and one for a specific news item. You can see that the $slug variable is passed to the model’s method in the second method. 
    The model is using this slug to identify the news item to be returned. */

    public function view($slug = null)
    {
        $model = new NewsModel();
    
        $data['news'] = $model->getNews($slug);
    
        if (empty($data['news']))
        {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Cannot find the news item: '. $slug);
        }
    
        $data['title'] = $data['news']['title'];
    
        echo view('templates/header', $data);
        echo view('news/view', $data);
        echo view('templates/footer', $data);
    }

    public function create() // for further reading please visit https://codeigniter.com/user_guide/tutorial/create_news_items.html, 24.4.2021
    {
        $model = new NewsModel();

        if ($this->request->getMethod() === 'post' && $this->validate([
                'title' => 'required|min_length[3]|max_length[255]',
                'body'  => 'required',
            ]))
        {
            $model->save([
                'title' => $this->request->getPost('title'),
                'slug'  => url_title($this->request->getPost('title'), '-', TRUE),
                'body'  => $this->request->getPost('body'),
            ]);
            
            //$data['news'] = $model->getLatest(); this approach does not work because i cann note order_by and take first() element but all data ara available 
            // and can by simply passed by on from send post
            $data ['news'] = [
                'title' => $this->request->getPost('title'),
                'slug'  => url_title($this->request->getPost('title'), '-', TRUE),
                'body'  => $this->request->getPost('body'),
            ] ;
            echo view('templates/header', ['title' => 'Create a news item']);
            echo view('news/success', $data );
            echo view('templates/footer');
        }
        else
        {
            echo view('templates/header', ['title' => 'Create a news item']);
            echo view('news/create');
            echo view('templates/footer');
        }
    }

    public function delete_news_article($id) {

        $model = new NewsModel();

            // first obtain data that will be deleted for passing into view informing about data deletion
            $data['news'] = $model->getID($id);
           
            
            $model->where('id', $id)->delete();

            // data giwen to view must be array - keep that in mind!!! now we first create string and pass them
            /* $data ['news'] = [
                'id' => $id
            ] ; */
           
            echo view('templates/header');
            echo view('news/news_article_deleted', $data );
            echo view('templates/footer');
       

        }

        public function update_news_article($id) {

            $model = new NewsModel();
    
               


                if ($this->request->getMethod() === 'post' && $this->validate([
                    'title' => 'required|min_length[3]|max_length[255]',
                    'body'  => 'required',
                ]))
            {
                $model->save([
                    'id' => $id,
                    'title' => $this->request->getPost('title'),
                    'slug'  => url_title($this->request->getPost('title'), '-', TRUE),
                    'body'  => $this->request->getPost('body'),
                ]);
                
                //$data['news'] = $model->getLatest(); this approach does not work because i cann note order_by and take first() element but all data ara available 
                // and can by simply passed by on from send post
                $data ['news'] = [
                    'title' => $this->request->getPost('title'),
                    'slug'  => url_title($this->request->getPost('title'), '-', TRUE),
                    'body'  => $this->request->getPost('body'),
                ] ;
                echo view('templates/header', ['title' => 'Create a news item']);
                echo view('news/success', $data );
                echo view('templates/footer');
            }
            else
            {
                 // first obtain data that will be deleted for passing into view informing about data deletion
                $data['news'] = $model->getID($id);
               
                echo view('templates/header', ['title' => 'Update a news item']);
                echo view('news/news_article_updated', $data );
                echo view('templates/footer');
            }
             
           
    
            }
}