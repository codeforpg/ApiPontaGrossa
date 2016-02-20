<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    protected $fillable = ['identifier'];

    public function identifier(){
        return $this->hasOne('App\Identifier')->where('type','App\Guest')->where('value',$this->id);
    }
}
