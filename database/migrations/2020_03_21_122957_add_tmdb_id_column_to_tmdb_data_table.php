<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTmdbIdColumnToTmdbDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('t_m_d_b_data', function (Blueprint $table) {
            //
            $table->string('tmdb_id', 20)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('t_m_d_b_data', function (Blueprint $table) {
            //
            $table->dropColumn('tmdb_id');
        });
    }
}
