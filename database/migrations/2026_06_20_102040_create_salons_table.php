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
    Schema::create('salons', function (Blueprint $table) {
        $table->id();

        // Relational link: references the 'id' on 'users' table
        // constrained() crée la contrainte, onDelete('cascade') supprime le salon si le user est supprimé
        $table->foreignId('user_id')->constrained()->onDelete('cascade');

        // Professional business identity fields
        $table->string('name');
        $table->string('slug')->unique(); // For URLs like nappyelite.cm/salons/salon-royale
        $table->text('description')->nullable();

        // Cameroon local routing system fields
        $table->string('city');
        $table->string('quarter'); // Akwa, Bastos, Bonapriso...

        // Hybrid business rules toggles (From our advanced Figma UX logic)
        $table->boolean('has_domicile')->default(false); // Service à domicile ?
        $table->boolean('has_marketplace')->default(false); // Boutique active ?

        // Social proof and ratings system (Note sur 5 étoiles)
        $table->decimal('rating', 3, 2)->default(5.00);

        // FinTech localized payouts routing column
        $table->string('momo_payout_number')->nullable(); // Numéro Orange/MTN pour recevoir l'argent

        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salons');
    }
};
