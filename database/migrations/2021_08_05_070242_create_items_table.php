<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('construction_number')->nullable();
            $table->string('inventory_number')->nullable();
            $table->string('identification_number')->nullable();
            $table->date('date_expiry')->nullable();
            $table->date('date_legalisation')->nullable();
            $table->date('date_legalisation_due')->nullable();
            $table->date('date_production')->nullable();
            $table->string('name')->nullable();
            
            $table->foreignId('item_database_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('fire_brigade_unit_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('manufacturer_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('vehicle_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('cascade');

            $table->boolean('activated')->default(false);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
}
