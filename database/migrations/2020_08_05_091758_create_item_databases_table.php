<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemDatabasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_databases', function (Blueprint $table) {
            $table->id();
            $table->string('stencil_name');
            $table->Boolean('construction_number')->default(false);
            $table->Boolean('inventory_number')->default(false);
            $table->Boolean('identification_number')->default(false);
            $table->Boolean('date_expiry')->default(false);
            $table->Boolean('date_legalisation')->default(false);
            $table->Boolean('date_legalisation_due')->default(false);
            $table->Boolean('date_production')->default(false);
            $table->Boolean('name')->default(false);
            $table->Boolean('manufacturer')->default(false);
            $table->Boolean('vehicle')->default(false);
            $table->foreignId('cathegory_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('item_databases');
    }
}
