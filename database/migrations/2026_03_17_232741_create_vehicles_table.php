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
    Schema::create('vehicles', function (Blueprint $table) {
        $table->id();
        $table->string('brand');           // Marque : Toyota, Honda...
        $table->string('model');           // Modèle : Corolla, CB500...
        $table->enum('type', ['car', 'motorcycle']);
        $table->year('year');              // Année de fabrication
        $table->string('plate')->unique(); // Plaque d'immatriculation
        $table->decimal('price_per_day', 10, 2); // Prix/jour
        $table->integer('mileage')->default(0);
        $table->enum('status', ['available', 'rented', 'maintenance'])
              ->default('available');
        $table->string('image')->nullable();
        $table->text('description')->nullable();
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
