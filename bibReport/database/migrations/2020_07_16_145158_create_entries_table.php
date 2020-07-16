<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entries', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('entryNo');
            $table->string('type')->nullable();
            $table->string('title');
            $table->string('seriesTitle')->nullable();
            $table->integer('issue')->nullable();
            $table->integer('publicationYear')->nullable();
            $table->string('place')->nullable();
            $table->integer('startingYear')->nullable();
            $table->integer('finishingYear')->nullable();
            $table->string('abstract')->nullable();
            $table->unsignedBigInteger('author_id');
            $table->unsignedBigInteger('entry_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('entries');
    }
}
