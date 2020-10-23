<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class imports extends Model
{
    //
    protected $table = 'import_product';
    protected $primaryKey = 'imp_id';
    public function supplierdata(){
        return $this->hasOne('App\supplier','supplier_id','supplier_id');
    }
    
    public function userdata(){
        return $this->hasOne('App\User','id','user_id');
    }
    
    public function firstproduct(){
        return $this->hasOne('App\subimports','imp_id','imp_id')->orderBy('sub_id','asc');
    }
    
    public function allproduct(){
        return $this->hasMany('App\subimports','imp_id','imp_id');
    }
}
