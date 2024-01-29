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
        Schema::create('knives', function (Blueprint $table) {
            $table->id();
            $table->string('Service IDs')->nullable();
            $table->string('Pitch')->nullable();
            $table->string('Type')->nullable();
            $table->string('Gear')->nullable();
            $table->string('Shape')->nullable();
            $table->string('Blade Type')->nullable();
            $table->string('Cut Type')->nullable();
            $table->string('Cut Position')->nullable();
            $table->string('Corner Radius')->nullable();
            $table->string('Size Across')->nullable();
            $table->string('Size Around')->nullable();
            $table->string('No Across')->nullable();
            $table->string('No Around')->nullable();
            $table->string('Gap Across')->nullable();
            $table->string('Gap Around')->nullable();
            $table->string('Center-to-Center Across')->nullable();
            $table->string('Center-to-Center Around')->nullable();
            $table->string('Liner')->nullable();
            $table->string('Perforation')->nullable();
            $table->string('Location')->nullable();
            $table->string('Supplier ID')->nullable();
            $table->string('Notes')->nullable();
            $table->string('Size Width')->nullable();
            $table->string('Repeat Length')->nullable();
            $table->string('No of Knife')->nullable();
            $table->string('Status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('knives');
    }
};
