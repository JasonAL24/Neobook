<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('author');
            $table->string('editor');
            $table->string('language');
            $table->string('publisher');
            $table->string('paper_type');
            $table->string('ISBN');
            $table->text('description')->nullable();
            $table->string('image');
            $table->string('type');
            $table->integer('rating');
            $table->string('last_rating_date');
            $table->string('last_rating_desc');
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
        Schema::dropIfExists('books');
    }
}
