<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Blog categories are separated (instead of reusing cms_terms) to keep the blog module
     * self-contained and simple for Next.js consumption.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cms_blog_categories', function (Blueprint $table) {
            $table->id();
$table->string('name');
            $table->string('slug')->unique();
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('order')->default(0);
	        $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')->references('id')->on('companies')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['is_active', 'order']);
			$table->index('company_id');
        });

        Schema::create('cms_blog_category_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cms_blog_category_id')
                ->constrained('cms_blog_categories')
                ->cascadeOnDelete();
            $table->string('locale', 2); // en|ar
            $table->string('title');
            $table->text('description')->nullable();
            $table->timestamps();

            // Default name exceeds MySQL 64-char limit; keep explicit short name.
            $table->unique(['cms_blog_category_id', 'locale'], 'cms_blog_cat_trans_locale_uniq');
            $table->index('locale');
            $table->index('title');
        });

        Schema::create('cms_blog_category_post', function (Blueprint $table) {
            $table->foreignId('cms_blog_post_id')
                ->constrained('cms_blog_posts')
                ->cascadeOnDelete();
            $table->foreignId('cms_blog_category_id')
                ->constrained('cms_blog_categories')
                ->cascadeOnDelete();

            $table->primary(['cms_blog_post_id', 'cms_blog_category_id'], 'cms_blog_category_post_pk');
            $table->index(['cms_blog_category_id', 'cms_blog_post_id'], 'cms_blog_category_post_cat_idx');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cms_blog_category_post');
        Schema::dropIfExists('cms_blog_category_translations');
        Schema::dropIfExists('cms_blog_categories');
    }
};