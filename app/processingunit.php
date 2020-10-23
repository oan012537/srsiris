<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class processingunit extends Model
{
    //
    protected $table = 'processingunit';
    protected $primaryKey = 'unit_id';
    
    public function unitdata(){
        return $this->hasOne('App\unit','unit_id','unit_unitfirst');
    }
}
