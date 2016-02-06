<?php

namespace App\Http\Controllers\Api;

use App\Jobs\GetIdentity;
use App\Vote;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class VoteController extends ApiController
{

    public function store(Request $request){
        $this->validate($request,[
            'postit_id'=>'required',
            'value'=>"required|integer"
        ],
        [
            'required'=>'precisa :attribute',
            'integer'=>'precisa ser numero :attribute'
        ]);

        $identity = $this->dispatch(new GetIdentity($request));

        $vote = Vote::firstOrNew(['postit_id'=>$request->get('postit_id'), 'identifier_id'=>$identity->id]);

        if ($vote->value == $request->value){
            $vote->value =0;
        }
        else {
            $vote->value = $request->value;
        }
        $vote->save();

        $vote->postIt->hasVoted = $vote->value;

        return $vote->postIt;

    }
    public function delete(Request $request){}
}
