<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Blog posts are stored separately from `cms_pages`.
     * Media is handled via Spatie Media Library (`media` table).
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cms_blog_posts', function (Blueprint $table) {
            $table->id();

            $table->string('slug')->unique();

            // Publishing workflow
            $table->string('status')->default('draft'); // draft|published|archived
            $table->timestamp('published_at')->nullable();

            $table->string('author_name')->nullable();

            // Optional ownership (must match users.id: increments = unsignedInteger)
            // $table->unsignedInteger('author_id')->nullable();
            // $table->foreign('author_id')->references('id')->on('users')->nullOnDelete();

            // Listing helpers
            $table->boolean('is_featured')->default(false);
            $table->unsignedSmallInteger('reading_time_minutes')->nullable();

            // Optional engagement / analytics (increment on public “read”)
            $table->boolean('allow_comments')->default(false);
            $table->unsignedBigInteger('views_count')->default(0);
            $table->index('views_count');

            // SEO helpers (non-localized)
            $table->string('canonical_url')->nullable();
            $table->boolean('is_indexable')->default(true);

// is active
$table->boolean('is_active')->default(true);
$table->unsignedInteger('order')->default(0);

            // company id
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')->references('id')->on('companies')->nullOnDelete();

            $table->timestamps();
            $table->softDeletes();

            $table->index(['status', 'published_at']);
            $table->index(['is_featured', 'published_at']);
            // $table->index('author_id');
			$table->index('company_id');
        });

        Schema::create('cms_blog_post_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cms_blog_post_id')
                ->constrained('cms_blog_posts')
                ->cascadeOnDelete();

            $table->string('locale', 2); // en|ar

            // Core content
            $table->string('title');
            $table->text('excerpt')->nullable();
            $table->longText('content')->nullable();

            // SEO (localized)
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->string('og_title')->nullable();
            $table->text('og_description')->nullable();

            $table->timestamps();

            $table->unique(['cms_blog_post_id', 'locale'], 'cms_blog_post_translations_unique');
            $table->index('locale');
            $table->index('title');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cms_blog_post_translations');
        Schema::dropIfExists('cms_blog_posts');
    }
};
