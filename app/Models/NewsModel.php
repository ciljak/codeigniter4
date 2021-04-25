<?php

namespace App\Models;

use CodeIgniter\Model;

class NewsModel extends Model
{
    protected $table = 'news';

    protected $allowedFields = ['id','title', 'slug', 'body'];

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