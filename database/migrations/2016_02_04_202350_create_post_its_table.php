<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostItsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_its', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('identifier_id')->references('id')->on('identifiers');;
            $table->text('message');
            $table->smallInteger('status');
            $table->timestamps();
        });

        \DB::statement('ALTER TABLE post_its ADD COLUMN coordinates POINT NULL DEFAULT NULL ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('post_its');
    }
}
