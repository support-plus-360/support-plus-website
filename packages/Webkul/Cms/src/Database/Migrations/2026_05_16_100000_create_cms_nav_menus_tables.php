<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cms_nav_menus', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')->references('id')->on('companies')->nullOnDelete();
            $table->string('key', 32);
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['company_id', 'key'], 'cms_nav_menus_company_key_uniq');
            $table->index('key');
        });

        Schema::create('cms_nav_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('menu_id')
                ->constrained('cms_nav_menus')
                ->cascadeOnDelete();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->foreign('parent_id')
                ->references('id')
                ->on('cms_nav_items')
                ->nullOnDelete();
            $table->unsignedBigInteger('cms_page_id')->nullable();
            $table->foreign('cms_page_id')
                ->references('id')
                ->on('cms_pages')
                ->nullOnDelete();
            $table->string('url', 2048)->nullable();
            $table->unsignedInteger('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->boolean('open_in_new_tab')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['menu_id', 'parent_id', 'order'], 'cms_nav_items_menu_parent_order_idx');
            $table->index(['menu_id', 'is_active', 'order'], 'cms_nav_items_menu_active_order_idx');
            $table->index('cms_page_id');
        });

        Schema::create('cms_nav_item_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cms_nav_item_id')
                ->constrained('cms_nav_items')
                ->cascadeOnDelete();
            $table->string('locale', 2);
            $table->string('label')->nullable();
            $table->timestamps();

            $table->unique(['cms_nav_item_id', 'locale'], 'cms_nav_item_trans_locale_uniq');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cms_nav_item_translations');
        Schema::dropIfExists('cms_nav_items');
        Schema::dropIfExists('cms_nav_menus');
    }
};
