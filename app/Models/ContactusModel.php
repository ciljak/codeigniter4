<?php

namespace App\Models;

use CodeIgniter\Model;

class ContactusModel extends Model
{
    protected $table = 'contact';

    protected $allowedFields = ['id','name', 'write_date', 'email','message_text'];

    public function getContactusPosts($name = false)
    {
        if ($name=== false)
        {
            $this->builder()
            
            ->orderBy('id', 'desc');
            return $this->findAll(); // helper methods used by Query builder
        }

        return $this->asArray()
                    ->where(['name' => $name])
                    ->first();       // helper methods used by Query builder
    }

   

    

  
    public function getContactusID($id)
     {
        

        return $this->asArray()
                    ->where(['id' => $id])
                    ->first();       // helper methods used by Query builder
    }
}
