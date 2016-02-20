<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Support\Facades\Cache;

class GeoLocation extends Job
{
    /**
     * @var
     */
    private $location;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($location)
    {
        //
        $this->location = $location;
    }

    /**
     * Execute the job.
     *
     */
    public function handle()
    {
        if (Cache::has($this->cache_key())){
            return Cache::get($this->cache_key());
        }
        $curl = new \anlutro\cURL\cURL;

        $params = [
            'key'=>env('GOOGLE_MAP_SERVER_KEY'),
            'input' => $this->location,
            'language'=>'pt-BR',
            'region'=>'br',
            'types'=>'(cities)',
            'components'=>'country:BR',
            'sensor'=>'false'
        ];

        $url = 'https://maps.googleapis.com/maps/api/place/autocomplete/json?'.http_build_query($params);
        $response = $curl->get($url);
        $data = json_decode($response->body);;
        Cache::forever($this->cache_key(), $data);
        return Cache::get($this->cache_key());
    }

    public function cache_key(){
        return 'geolocation.'.str_slug($this->location);
    }
}
