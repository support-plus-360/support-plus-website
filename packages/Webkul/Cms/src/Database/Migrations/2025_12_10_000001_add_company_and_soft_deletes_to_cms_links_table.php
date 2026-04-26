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
        if (! Schema::hasTable('cms_links')) {
            return;
        }

        Schema::table('cms_links', function (Blueprint $table) {
            if (! Schema::hasColumn('cms_links', 'company_id')) {
                $table->unsignedBigInteger('company_id')->nullable()->after('is_active');
                $table->foreign('company_id')->references('id')->on('companies')->nullOnDelete();
            }

            if (! Schema::hasColumn('cms_links', 'deleted_at')) {
                $table->softDeletes();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasTable('cms_links')) {
            return;
        }

        Schema::table('cms_links', function (Blueprint $table) {
            if (Schema::hasColumn('cms_links', 'company_id')) {
                $table->dropForeign(['company_id']);
                $table->dropColumn('company_id');
            }

            if (Schema::hasColumn('cms_links', 'deleted_at')) {
                $table->dropSoftDeletes();
            }
        });
    }
};
