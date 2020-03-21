<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTMDBDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_m_d_b_data', function (Blueprint $table) {
            $table->id();

            $table->integer('user_id')->default(0);

            $table->string('original_title', 200);
            $table->string('genre', 50);
            $table->date('primary_release_date');

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
        Schema::dropIfExists('t_m_d_b_data');
    }
}
