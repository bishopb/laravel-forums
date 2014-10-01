<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGDNAnalyticsLocalTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('GDN_AnalyticsLocal', function(Blueprint $table)
        {
            $table->string('TimeSlot', 8)->unique('UX_AnalyticsLocal');
            $table->integer('Views')->nullable();
            $table->integer('EmbedViews')->nullable();
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('GDN_AnalyticsLocal');
    }

}
