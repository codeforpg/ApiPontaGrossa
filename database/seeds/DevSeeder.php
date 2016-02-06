<?php

use Illuminate\Database\Seeder;

class DevSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        /**
         * Make 10 of each user types
         */

        $this->it(10,function(){
            factory(App\User::class)->create();
            factory(App\Email::class)->create();
            factory(App\Guest::class)->create();
        });


        /**
         * Make 20 of a type and identifier
         */

        $this->it(20,function(){
            $this->create_identifier();
        });

        /**
         * Make 20 PostIts
         */

        factory(App\PostIt::class,20)->create()->each(function($iteration){

            $identifier = $this->create_identifier();
            $iteration->identifier()->associate($identifier);

        });

        /**
         * Make 50 PostIts with Various Votes
         */

        factory(App\PostIt::class,50)->create()->each(function($iteration){

            $identifier = $this->create_identifier();

            $votes = [];
            $this->it(rand(1,12), function() use($votes) {
               $votes[]=factory(App\Vote::class)->make();
            });


            $iteration->identifier()->associate($identifier);
            $iteration->votes()->saveMany($votes);;

        });
    }

    public function it($loops, \Closure $handle){

        foreach(range(0,$loops) as $index){
            $handle($index);
        }
    }

    public function create_identifier(){
        $class = array_any([App\User::class,App\Email::class,App\Guest::class]);
        $model = factory($class)->create();

        $identifier = factory(App\Identifier::class)->create([
            'type'=>$class,
            'value'=>$model->id
        ]);

        return $identifier;
    }
}
