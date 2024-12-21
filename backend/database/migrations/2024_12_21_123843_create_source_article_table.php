<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('source_article', function (Blueprint $table) {
            $table->foreignId('source_id')->constrained('sources')->cascadeOnDelete();
            $table->foreignId('article_id')->constrained('articles')->cascadeOnDelete();
            $table->unique(['source_id', 'article_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('source_article');
    }
};
