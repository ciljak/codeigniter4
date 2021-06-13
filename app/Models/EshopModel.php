<?php

namespace App\Models;

use CodeIgniter\Model;
helper('array');

class EshopModel extends Model
{
    protected $table = 'eshop';

    protected $allowedFields = ['id','product_name', 'product_category', 'product_subcategory','product_price', 'user_id', 'dph', 'is_published', 'nr_of_items_on_store',
    'slug', 'description', 'picture_name_1', 'picture_type_1', 'picture_name_2', 'picture_type_2', 'picture_name_3', 'picture_type_3'];

    public function getProducts($slug = false)
    {
        if ($slug === false)
        {
            return $this->findAll(); // helper methods used by Query builder
        }

        return $this->asArray()
                    ->where(['slug' => $slug])
                    ->first();       // helper methods used by Query builder
    }

    public function getLatestProducts($slug = false)
    {
        if ($slug === false)
        {
            // create connection to a database - for further reading please visit - https://codeigniter.com/user_guide/database/query_builder.html, 23.5.2021
            $db      = \Config\Database::connect();
            $builder = $db->table('eshop');

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


    public function list_category_subcategory()
    {
        // create connection to a database - for further reading please visit - https://codeigniter.com/user_guide/database/query_builder.html, 23.5.2021
            $db      = \Config\Database::connect();
            $builder = $db->table('eshop');

            //$builder->selectMax('id');
            $builder->orderBy('product_category', 'ASC'); // order from latest to older
            $builder->select('id, product_category, product_subcategory') ;
            $builder->distinct();  
            
            // $builder->limit(2);  return latest two articles
           

           return $builder->get()->getResultArray();
   }

   

    

}