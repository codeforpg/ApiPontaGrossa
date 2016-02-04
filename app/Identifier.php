<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Identifier extends Model
{
    protected $fillable = ['type','value'];

    public function owner(){
        return $this->belongsTo($this->type)->where('value',$this->value);
    }
}
