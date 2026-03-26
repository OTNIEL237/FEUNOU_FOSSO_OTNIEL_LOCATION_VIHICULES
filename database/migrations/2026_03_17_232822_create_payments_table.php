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
    Schema::create('payments', function (Blueprint $table) {
        $table->id();
        $table->foreignId('rental_id')->constrained()->onDelete('cascade');
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->decimal('amount', 10, 2);
        $table->enum('method', [
            'cash',          // Espèces
            'card',          // Carte bancaire
            'mobile_money',  // Mobile Money (MTN, Orange)
            'transfer'       // Virement
        ])->default('cash');
        $table->enum('status', [
            'pending',   // En attente
            'paid',      // Payé
            'failed',    // Échoué
            'refunded'   // Remboursé
        ])->default('pending');
        $table->string('transaction_ref')->nullable(); // Référence paiement
        $table->timestamp('paid_at')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
