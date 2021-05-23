<?php

namespace App\Models;

use CodeIgniter\Model;
helper('array');

class NewsModel extends Model
{
    protected $table = 'news';

    protected $allowedFields = ['id','title', 'slug', 'body','picture_name', 'picture_type'];

    public function getNews($slug = false)
    {
        if ($slug === false)
        {
            return $this->findAll(); // helper methods used by Query builder
        }

        return $this->asArray()
                    ->where(['slug' => $slug])
                    ->first();       // helper methods used by Query builder
    }

    public function getLatestNews($slug = false)
    {
        if ($slug === false)
        {
            // create connection to a database - for further reading please visit - https://codeigniter.com/user_guide/database/query_builder.html, 23.5.2021
            $db      = \Config\Database::connect();
            $builder = $db->table('news');

            //$builder->selectMax('id');
            $builder->orderBy('id', 'DESC'); // order from latest to older
            $builder->limit(2); // return latest two articles
           

           return $builder->get()->getResultArray();
            
          
            
        }

        return $this->asArray()
                    ->where(['slug' => $slug])
                    ->first();       // helper methods used by Query builder
    }

    public function getLatest() // return latest added item into a database
    {
       
       
       return $this->asArray()
      
                  ->where(['id' => "3"])
                  
                  ->first();       // helper methods used by Query builder

       
    }

    

   /*not used public function deleteNewsArtilce($id){ 

        $this->db->delete('news', array('id' => $id));  // Produces: DELETE FROM news WHERE id = $id
        //$this -> db -> where('id', $id);
        //$this -> db -> delete('news');
        
                        } */
    public function getID($id)
     {
        

        return $this->asArray()
                    ->where(['id' => $id])
                    ->first();       // helper methods used by Query builder
    }
}