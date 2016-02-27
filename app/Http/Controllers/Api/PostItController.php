<?php

namespace App\Http\Controllers\Api;

use App\Decorators\DateFormat;
use App\Jobs\GetIdentity;
use App\Jobs\StorePostIt;
use App\PostIt;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PostItController extends ApiController
{
    public function index(Request $request){

        $page = $request->get('page',1);
        $limit = $request->get('limit',20);
        $sort = $request->get('sort','votes');
        if ($limit < 0 || $limit > 50) {
            $limit = 20;
        }

        $offset = ($page - 1) * $limit;


        $query = PostIt::active()->hasVoted($this->getIdentity($request))->offset($offset)->limit($limit);

        if ($sort == 'votes'){
            $query->sortVotes()->aged();
        }
        else {
            $query->sortAge()->latest();
        }

        $postIts = $query->get();

        return $postIts;

    }

    public function show($postit, Request $request){
        $postit = PostIt::where(['post_its.id'=>$postit])->hasVoted($this->getIdentity($request))->first();
        return $postit;
    }

    public function create(Request $request){}
    public function edit(Request $request){}
    public function store(Request $request){

        $postit = $this->dispatch(new StorePostIt($request, $this->getIdentity($request)));
        return $postit->toArray();

    }

    public function update(Request $request){}
    public function delete(Request $request){}

    public function getIdentity(Request $request){
        return $this->dispatch(new GetIdentity($request));
    }
}
