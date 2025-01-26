<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vacations', function (Blueprint $table) {
            $table->boolean('is_closed')->default(false);
        });
    }

    public function down()
    {
        Schema::table('vacations', function (Blueprint $table) {
            $table->dropColumn('is_closed');
        });
    }
};