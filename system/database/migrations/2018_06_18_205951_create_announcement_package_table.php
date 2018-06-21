<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnnouncementPackageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('announcement_package', function (Blueprint $table) {
            $table->increments('id');

            $table->uuid('announcement_id')->nullable();
            $table->foreign('announcement_id')
                ->references('id')
                ->on('announcements')
                ->onDelete('cascade');

            $table->uuid('package_id')->nullable();
            $table->foreign('package_id')
                ->references('id')
                ->on('packages')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('announcement_package');
    }
}
