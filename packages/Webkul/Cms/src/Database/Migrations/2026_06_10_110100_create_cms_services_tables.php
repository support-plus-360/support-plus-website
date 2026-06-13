<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cms_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cms_service_type_id')
                ->nullable()
                ->constrained('cms_service_types')
                ->nullOnDelete();
	 $table->string('name');
	  $table->string('slug')->unique();
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('order')->default(0);
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')->references('id')->on('companies')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index('cms_service_type_id');
            $table->index('is_active');
            $table->index('company_id');
        });

        Schema::create('cms_service_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cms_service_id')
                ->constrained('cms_services')
                ->cascadeOnDelete();
            $table->string('locale', 2);
            $table->string('title');
            $table->string('sub_title')->nullable();
            $table->longText('problems')->nullable();
            $table->longText('solutions')->nullable();
            $table->longText('key_benefits')->nullable();
            $table->longText('deliverables')->nullable();
            $table->timestamps();

            $table->unique(['cms_service_id', 'locale'], 'cms_service_trans_locale_uniq');
            $table->index('locale');
            $table->index('title');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cms_service_translations');
        Schema::dropIfExists('cms_services');
    }
};
