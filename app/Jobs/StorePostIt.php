<?php

namespace App\Jobs;

use Illuminate\Http\Request;
use App\Identifier;
use App\Jobs\Job;
use App\PostIt;
use Illuminate\Foundation\Validation\ValidatesRequests;

class StorePostIt extends Job
{
    use ValidatesRequests;
    /**
     * @var Request
     */
    private $request;
    /**
     * @var Identifier
     */
    private $identifier;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Request $request, Identifier $identifier)
    {
        //
        $this->request = $request;
        $this->identifier = $identifier;
    }

    /**
     * Execute the job.
     *
     */
    public function handle()
    {
        $this->validate($this->request,[
                'message'=>'string|required'
        ],[
            'required'=>'o campo :attribute é obrigatório'
        ]);

        $postit = new PostIt($this->request->only('message') + ['status'=>10]);
        $postit->identifier()->associate($this->identifier);
        $postit->save();

        return $postit;

    }
}
