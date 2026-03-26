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
    Schema::create('contracts', function (Blueprint $table) {
        $table->id();
        $table->foreignId('rental_id')->constrained()->onDelete('cascade');
        $table->string('contract_number')->unique(); // Ex: CONT-2024-001
        $table->date('signed_at')->nullable();
        $table->decimal('deposit_amount', 10, 2)->default(0); // Caution
        $table->enum('status', [
            'draft',     // Brouillon
            'signed',    // Signé
            'closed'     // Clôturé
        ])->default('draft');
        $table->text('terms')->nullable(); // Conditions
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
