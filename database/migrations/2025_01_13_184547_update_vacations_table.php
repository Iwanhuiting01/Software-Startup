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
            $table->renameColumn('group_size', 'max_group_size'); // Rename column
        });

        Schema::table('vacations', function (Blueprint $table) {
            $table->decimal('price', 8, 2)->after('image');
            $table->date('start_date')->default('2000-01-01')->after('price'); // Add with default
            $table->date('end_date')->default('2000-01-01')->after('start_date'); // Add with default
            $table->text('long_description')->nullable()->after('description');
            $table->integer('min_group_size')->after('max_group_size');
            $table->foreignId('user_id')->constrained()->onDelete('cascade')->after('id');
        });
    }

    public function down()
    {
        Schema::table('vacations', function (Blueprint $table) {
            $table->dropColumn(['price', 'start_date', 'end_date', 'long_description', 'min_group_size']);
            $table->dropConstrainedForeignId('user_id');
        });

        Schema::table('vacations', function (Blueprint $table) {
            $table->renameColumn('max_group_size', 'group_size');
        });
    }
};
