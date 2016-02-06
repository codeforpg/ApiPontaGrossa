<?php

namespace App\Jobs;

use App\Email;
use App\Guest;
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
    public function handle()
    {

        if (\Auth::check()){
            return \Auth::user();
        }


        $user = $this->getSession();
        if ($user){
            return $user;
        }

        if ($this->request->hasCookie('email_user')){
            $user = Email::where('email',$this->request->cookie('email_user'));
            $this->saveSession($user);
            return $this->getSession();
        }

        if ($this->request->hasCookie('guest_user')){
           $tracker = $this->request->cookie('guest_user');
        }
        $tracker = $this->request->getClientIp();

        $user = Guest::firstOrCreate(['identifier'=>$tracker]);
        $this->saveSession($user);
        return $this->getSession();
    }

    public function getSession(){

        if (\Session::has('current_user')){

            $data =  \Session::get('current_user');
            switch($data['model']){
                case 'App\User':
                    return User::find($data['id']);
                    break;
                case 'App\Email':
                    return Email::find($data['id']);
                    break;
                case 'App\Guest':
                    return Guest::find($data['id']);
                    break;
                default:
                    throw new \Exception("Unknown User Session");
                    break;
            }
        }

       return false;

    }

    public function saveSession(Model $model){
        $data = ['model'=>get_class($model), 'id'=>$model->id];
        \Session::put('current_user',$data);
    }
}
