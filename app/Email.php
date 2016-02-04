<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    protected $fillable = ['email'];

    public function identifier(){
        return $this->hasOne('App\Identifier')->where('type','App\Email')->where('value',$this->id);
    }
}
