<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('nik');
            $table->string('kk');
            $table->string('name');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->enum('gender', ['male', 'female']);
            $table->string('birth_place');
            $table->date('birth_date');
            $table->boolean('is_deceased')->default(false);
            $table->text('address_line');
            $table->string('province_code');
            $table->string('city_code');
            $table->string('district_code');
            $table->string('village_code');
            $table->string('rt');
            $table->string('rw');
            $table->string('postal_code');
            $table->string('marital_status');
            $table->string('relationship_name')->nullable();
            $table->string('relationship_phone')->nullable();
            $table->enum('extension', ['WNI', 'WNA']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
