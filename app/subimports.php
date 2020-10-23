<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class subimports extends Model
{
    //
    protected $table = 'sub_import_product';
    protected $primaryKey = 'sub_id';
    
    public function productdata(){
        return $this->hasOne('App\product','product_id','product_id');
    }
}
