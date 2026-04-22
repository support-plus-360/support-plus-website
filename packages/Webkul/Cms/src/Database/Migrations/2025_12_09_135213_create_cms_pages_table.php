<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cms_pages', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('name'); // Internal name for admin
            $table->boolean('is_active')->default(true);
            $table->integer('order')->default(0);
	$table->string('type')->default('page'); // page|service|case_study|industry
	$table->string('status')->default('draft'); // draft|published|archived
	$table->timestamp('published_at')->nullable();
            $table->unsignedInteger('author_id')->nullable();
            $table->foreign('author_id')->references('id')->on('users')->nullOnDelete();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')->references('id')->on('companies')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
	$table->index(['type', 'status', 'published_at']);
	$table->index(['type', 'is_active', 'order']);
	$table->index('author_id');
	$table->index('company_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cms_pages');
    }
};
