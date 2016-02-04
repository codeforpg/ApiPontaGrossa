<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostIt extends Model
{
    protected $fillable = ['identifier_id','message','coordinates','status'];

    public function identifier(){
        return $this->belongsTo('App\Identifier');
    }

    public function votes(){
        return $this->hasMany('App\Vote','postit_id','id');
    }

    public function setCoordinatesAttribute(Array $coordinates){
        if (!empty($coordinates)){
            $this->attributes['coordinates'] = \DB::raw(sprintf('POINT(%s)', (is_array($coordinates)) ? implode(",",$coordinates) : $coordinates));
        }
    }

    public function getCoordinatesAttribute($value){
        if (is_array($value)){
            return $value;
        }
        $loc =  substr($value, 6);
        $loc = preg_replace('/[ ,]+/', ',', $loc, 1);
        list($lat, $lng) = array_pad(explode(",",substr($loc,0,-1)), 2, null);
        return ['lat'=>(float) $lat,'lon'=>(float) $lng];
    }
}
