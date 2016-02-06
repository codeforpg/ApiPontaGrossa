<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    protected $fillable = ['postit_id','identifier_id','value'];

    public function postIt(){
        return $this->belongsTo('App\PostIt','postit_id','id');
    }


}
