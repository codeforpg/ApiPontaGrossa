<?php

namespace App\Decorators;


use Illuminate\Database\Eloquent\Collection;

class DateFormat
{
    /**
     * @var Collection
     */
    private $collection;

    public function __construct(Collection $collection)
    {
        $this->collection = $collection;
    }

    public function toDateString(){
        return $this->collection->map(function($item){
            $item->displayTime = $item->created_at->format('M d,Y');
        });
    }

    public function toHumanDiff(){
        return $this->collection->map(function($item){
            $item->displayTime = $item->created_at->diffForHumans();
        });
    }
}