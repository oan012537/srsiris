<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class member extends Model
{
    //
    protected $table = 'member';
    protected $primaryKey = 'member_id';
    
    public function checkgender($num){
        if($this->gender == $num){
            return 'checked';
        }
        else{
            return '';
        }
    }
    
}
