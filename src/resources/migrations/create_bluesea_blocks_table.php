<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateBlueSeaCmsCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bluesea_blocks', function (Blueprint $table) {
            $table->id();
            $table->morphs('owner');
            $table->string('template')->nullable();
            $table->longText('draft_content')->nullable();
            $table->longText('published_content')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bluesea_blocks');
    }
}
