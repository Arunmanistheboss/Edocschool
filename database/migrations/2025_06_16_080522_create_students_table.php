<?php

use App\Models\SchoolClass;
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
        Schema::create('students', function (Blueprint $table) {
           // Un seul champ id, clé primaire ET clé étrangère
            $table->unsignedBigInteger('id')->primary();
            $table->foreign('id')->references('id')->on('users')->onDelete('cascade');

            // Relation FACULTATIVE vers school_classes (0,1)
            $table->foreignIdFor(SchoolClass::class)
                ->nullable() // ← 0,1 ici
                ->constrained()
                ->nullOnDelete(); //  ← devient NULL si la classe est supprimée

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
