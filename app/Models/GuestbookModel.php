<?php

namespace App\Models;

use CodeIgniter\Model;

class GuestbookModel extends Model
{
    protected $table = 'guestbook';

    protected $allowedFields = ['id','name_of_writer', 'write_date', 'email','picture_name', 'picture_type', 'message_text','slug'];

    public function getGuestPosts($slug = false)
    {
        if ($slug=== false)
        {
            $this->builder()
            
            ->orderBy('id', 'desc');
            return $this->findAll(); // helper methods used by Query builder
        }

        return $this->asArray()
                    ->where(['slug' => $slug])
                    ->first();       // helper methods used by Query builder
    }

   

    

   /*not used public function deleteNewsArtilce($id){ 

        $this->db->delete('news', array('id' => $id));  // Produces: DELETE FROM news WHERE id = $id
        //$this -> db -> where('id', $id);
        //$this -> db -> delete('news');
        
                        } */
    public function getGuestID($id)
     {
        

        return $this->asArray()
                    ->where(['id' => $id])
                    ->first();       // helper methods used by Query builder
    }
}
