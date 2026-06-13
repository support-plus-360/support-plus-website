<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cms_case_studies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cms_case_study_category_id')
                ->nullable()
                ->constrained('cms_case_study_categories')
                ->nullOnDelete();
            $table->string('city')->nullable();
	  $table->string('slug')->unique();
            $table->json('kpis')->nullable();
            $table->decimal('rate', 5, 2)->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->unsignedInteger('order')->default(0);
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')->references('id')->on('companies')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index('cms_case_study_category_id');
            $table->index('city');
            $table->index('is_active');
            $table->index('is_featured');
            $table->index('company_id');
        });

        Schema::create('cms_case_study_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cms_case_study_id')
                ->constrained('cms_case_studies')
                ->cascadeOnDelete();
            $table->string('locale', 2);
            $table->string('title');
            $table->string('sub_title')->nullable();
            $table->longText('content')->nullable();
            $table->longText('challenges')->nullable();
            $table->longText('solutions')->nullable();
            $table->timestamps();

            $table->unique(['cms_case_study_id', 'locale'], 'cms_case_study_trans_locale_uniq');
            $table->index('locale');
            $table->index('title');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cms_case_study_translations');
        Schema::dropIfExists('cms_case_studies');
    }
};