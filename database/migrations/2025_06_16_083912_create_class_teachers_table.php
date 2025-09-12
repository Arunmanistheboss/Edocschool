<?php

use App\Models\SchoolClass;
use App\Models\Teacher;
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
        Schema::create('class_teachers', function (Blueprint $table) {
            // Référence vers le professeur
            $table->foreignIdFor(Teacher::class)
                  ->constrained()
                  ->cascadeOnDelete();

            // Référence vers la classe
            $table->foreignIdFor(SchoolClass::class)
                  ->constrained()
                  ->cascadeOnDelete();

            // Clé primaire composée
            $table->primary(['teacher_id', 'school_class_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('class_teachers');
    }
};
