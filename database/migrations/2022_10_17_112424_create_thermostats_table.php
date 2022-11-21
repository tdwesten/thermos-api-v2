<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Schema;
use Ramsey\Uuid\Uuid;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('thermostats', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->timestamps();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('last_update')->useCurrent();
            $table->timestamp('last_manual_change')->nullable();
            $table->string('mode')->default('auto');
            $table->string('password');
            $table->string('name');
            $table->rememberToken();
            $table->string('token')->default(Uuid::uuid4()->toString())->readonly()->unique();
            $table->integer('target_temperature')->default(1600);
            $table->integer('min_temperature')->default(1600);
            $table->integer('current_temperature')->default(0);
            $table->boolean('is_heating')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('thermostats');
    }
};
