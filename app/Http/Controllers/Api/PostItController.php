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

        if ($limit < 0 || $limit > 50) {
            $limit = 20;
        }

        $offset = ($page - 1) * $limit;


        $postIts = PostIt::active()->hasVoted($this->getIdentity($request))->offset($offset)->limit($limit)->get();

        return $postIts;

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
