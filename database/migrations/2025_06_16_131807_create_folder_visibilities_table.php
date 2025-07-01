<?php

use App\Models\Folder;
use App\Models\SchoolClass;
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
        Schema::create('folder_visibilities', function (Blueprint $table) {
            // Référence vers dossier
            $table->foreignIdFor(Folder::class)
                  ->constrained()
                  ->cascadeOnDelete();
            // Référence vers classe
            $table->foreignIdFor(SchoolClass::class)
                  ->constrained()
                  ->cascadeOnDelete();

            // Clé primaire composée
            $table->primary(['folder_id', 'school_class_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('folder_visibilities');
    }
};
