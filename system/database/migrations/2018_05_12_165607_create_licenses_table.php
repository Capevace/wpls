<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLicensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('licenses', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            
            $table->string('license_key', 512);
            $table->uuid('package_id');

            $table->timestamp('supported_until')->nullable();
            $table->text('customer_data'); // JSON
            $table->boolean('is_purchase_code'); // If it is a purchase code, it is not deletable

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
        Schema::dropIfExists('licenses');
    }
}
