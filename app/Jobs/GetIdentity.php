<?php

namespace App\Jobs;

use App\Email;
use App\Guest;
use App\Identifier;
use App\Jobs\Job;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class GetIdentity extends Job
{
    /**
     * @var Request
     */
    private $request;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        //
        $this->request = $request;
    }

    /**
     * Execute the job.
     *
     */

    public function handle(){

        $identity = $this->loadFromSession();
        return $identity;
    }
    public function getModel()
    {

        if (\Auth::check()){
            return \Auth::user();
        }

        if ($this->request->hasCookie('email_user')){
            $user = Email::where('email',$this->request->cookie('email_user'));
        }

        if ($this->request->hasCookie('guest_user')){
           $tracker = $this->request->cookie('guest_user');
        }

        $tracker = $this->request->getClientIp();
        $user = Guest::firstOrCreate(['identifier'=>$tracker]);

        return $user;
    }

    public function loadFromSession(){

        if (\Session::has('current_user')){
            $data =  \Session::get('current_user');
        }
        else {
            $model = $this->getModel();
            $data = ['model'=>get_class($model), 'id'=>$model->id];
            \Session::put('current_user',$data);
        }

        $identity = Identifier::firstOrCreate(['type'=>$data['model'],'value'=>$data['id']]);
        return $identity;

    }

}
