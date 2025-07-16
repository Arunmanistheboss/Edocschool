<?php

use App\Models\Folder;
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
        Schema::create('files', function (Blueprint $table) {
            $table->id();

            $table->string('name');

            $table->string('type');

            // Lien d’accès (chemin)
            $table->string('path');

            // Date d'upload du fichier
            $table->timestamp('date_upload')->useCurrent();

            // Référence au dossier parent
            $table->foreignIdFor(Folder::class)
                ->constrained()
                ->cascadeOnDelete();

            // Référence à l'utilisateur qui a uploadé
            $table->foreignId('teacher_id')
                ->constrained('teachers')
                ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('files');
    }
};
