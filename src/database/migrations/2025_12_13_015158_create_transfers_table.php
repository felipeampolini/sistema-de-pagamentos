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
        Schema::create('transfers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sender_id')->nullable()->constrained('users')->onDelete('SET NULL'); // remetente
            $table->foreignId('receiver_id')->constrained('users')->onDelete('CASCADE'); // destinatário
            $table->decimal('amount', 15, 2);
            $table->enum('status', ['pending', 'completed', 'reversed'])->default('pending');
            $table->timestamp('reversed_at')->nullable()->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfers');
    }
};
