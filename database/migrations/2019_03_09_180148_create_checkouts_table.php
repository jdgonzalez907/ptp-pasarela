<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCheckoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checkouts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('status', 20);
            
            // Buyer
            $table->string('document', 50);
            $table->string('documentType', 2);
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->string('email', 50);
            $table->string('address', 100);
            $table->string('city', 100);
            $table->string('phone', 20);

            // Payment
            $table->string('description', 150);
            $table->decimal('amount', 11, 2);
            $table->datetime('expiration');
            $table->string('requestId')->nullable();
            $table->string('authorization')->nullable();
            $table->string('franchise')->nullable();
            $table->string('bank')->nullable();
            $table->string('reason')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('checkouts');
    }
}
