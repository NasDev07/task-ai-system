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
        Schema::create('sales_pages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('product_name');
            $table->text('description');
            $table->text('features');
            $table->string('target_audience');
            $table->decimal('price', 10, 2);
            $table->text('unique_selling_point');
            $table->longText('headline')->nullable();
            $table->longText('subheadline')->nullable();
            $table->longText('benefits')->nullable();
            $table->longText('features_breakdown')->nullable();
            $table->text('social_proof')->nullable();
            $table->text('pricing_display')->nullable();
            $table->text('call_to_action')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_pages');
    }
};
