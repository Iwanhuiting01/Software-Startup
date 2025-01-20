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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Link to users
            $table->foreignId('vacation_id')->constrained()->onDelete('cascade'); // Link to vacations
            $table->string('first_name'); // First name of the person booked
            $table->string('middle_name')->nullable(); // Middle name of the person booked
            $table->string('last_name'); // Last name of the person booked
            $table->date('date_of_birth'); // Date of birth of the person booked
            $table->string('email'); // Email of the person booked
            $table->decimal('price', 8, 2); // Total price for the booking
            $table->decimal('amount_paid', 8, 2)->default(0); // Amount already paid
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
        Schema::dropIfExists('bookings');
    }
};
