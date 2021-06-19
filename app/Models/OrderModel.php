<?php

namespace App\Models;

use CodeIgniter\Model;
helper('array');

class OrderModel extends Model
{
    protected $table = 'order';

    protected $allowedFields = ['order_id','user_id', 'product_id', 'number_of_ordered_items','total_price', 'state_of_order', 'main_order_number'];

    public function getOrders($slug = false)
    {
        if ($slug === false)
        {
            return $this->findAll(); // helper methods used by Query builder
        }

        return $this->asArray()
                    ->where(['slug' => $slug])
                    ->first();       // helper methods used by Query builder
    }

    public function getLatestOrder($slug = false)
    {
        if ($slug === false)
        {
            // create connection to a database - for further reading please visit - https://codeigniter.com/user_guide/database/query_builder.html, 23.5.2021
            $db      = \Config\Database::connect();
            $builder = $db->table('order');

            //$builder->selectMax('id');
            $builder->orderBy('id', 'DESC'); // order from latest to older
            $builder->where('is_published', '1'); // select only published news
            $builder->limit(2); // return latest two articles
           

           return $builder->get()->getResultArray();
            
          
            
        }

        return $this->asArray()
                    ->where(['slug' => $slug])
                    ->first();       // helper methods used by Query builder
    }

    public function getLatest() // return latest added item into a database - not good example - bad tray
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