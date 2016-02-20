<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Support\Facades\Cache;

class GeoCoordinates extends Job
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
            'address' => $this->location
        ];
        $url = 'https://maps.googleapis.com/maps/api/geocode/json?'.http_build_query($params);
        $response = $curl->get($url);
        $data = json_decode($response->body);;
        Cache::forever($this->cache_key(), $data);
        return Cache::get($this->cache_key());
    }

    public function cache_key(){
        return 'geocoordinate.'.str_slug($this->location);
    }
}