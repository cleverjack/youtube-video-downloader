<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    public $fillable = ['title','parent_id'];

    protected $table = 'categories';

    /**
     * Get the index name for the model.
     *
     * @return string
    */
    public function childs() {
        return $this->hasMany('App\Models\Category','parent_id','id') ;
    }
}
