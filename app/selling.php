<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class selling extends Model
{
    //
    protected $table = 'selling';
    protected $primaryKey = 'selling_id';

    public function detail(){
        return $this->hasMany('App\sellingdetail','selling_id','sellingdetail_ref');
    }
}
