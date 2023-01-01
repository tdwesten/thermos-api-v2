<?php

use App\Enums\MetricInterval;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('metrics', function (Blueprint $table) {
            $table->foreignUuid('thermostat_id')->nullable()->constrained('thermostats')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('interval')->default(MetricInterval::Minute->value);
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('metrics', function (Blueprint $table) {
            $table->dropForeign(['thermostat_id']);
            $table->dropColumn('interval');
        });
    }
};
