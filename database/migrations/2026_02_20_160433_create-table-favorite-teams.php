<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
Schema::create('favorite_teams', function (Blueprint $table) {
    $table->id();
    $table->foreignIdFor(User::class)->constrained()->onDelete('cascade');
    $table->unsignedBigInteger('team_id');
    $table->timestamps();

    // 🔹 Índice único para evitar duplicados
    $table->unique(['user_id', 'team_id']);
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('favorite_teams');
    }
};
