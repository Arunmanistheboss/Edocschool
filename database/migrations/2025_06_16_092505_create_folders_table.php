<?php

use App\Models\Teacher;
use App\Models\User;
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
        Schema::create('folders', function (Blueprint $table) {
            $table->id();

            // Nom du dossier
            $table->string('name');

            // Date d'upload
            $table->timestamp('date_upload')->useCurrent();

            // Créateur du dossier

            $table->foreignIdFor(Teacher::class)
                ->constrained()
                ->cascadeOnDelete();

            // Dossier parent (auto-référence)
            $table->foreignId('parent_id')
                ->nullable()
                ->constrained('folders')
                ->nullOnDelete();

            $table->timestamps();

            // Contrainte : interdiction de doublon de nom dans le même dossier parent
            $table->unique(['parent_id', 'name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('folders');
    }
};
