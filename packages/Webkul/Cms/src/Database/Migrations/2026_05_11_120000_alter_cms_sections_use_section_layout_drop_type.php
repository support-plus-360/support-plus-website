<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Align existing cms_sections rows with section_layout (builder layout key) and drop legacy type/template/layout columns.
     */
    public function up(): void
    {
        if (! Schema::hasTable('cms_sections')) {
            return;
        }

        Schema::table('cms_sections', function (Blueprint $table) {
            if (Schema::hasColumn('cms_sections', 'type')) {
                $table->dropColumn('type');
            }
        });

        if (! Schema::hasColumn('cms_sections', 'section_layout')) {
            if (Schema::hasColumn('cms_sections', 'template')) {
                Schema::table('cms_sections', function (Blueprint $table) {
                    $table->renameColumn('template', 'section_layout');
                });
            } elseif (Schema::hasColumn('cms_sections', 'layout')) {
                Schema::table('cms_sections', function (Blueprint $table) {
                    $table->renameColumn('layout', 'section_layout');
                });
            } else {
                Schema::table('cms_sections', function (Blueprint $table) {
                    $table->string('section_layout')->nullable()->after('name');
                });
            }
        }

        Schema::table('cms_sections', function (Blueprint $table) {
            if (Schema::hasColumn('cms_sections', 'template')) {
                $table->dropColumn('template');
            }
            if (Schema::hasColumn('cms_sections', 'layout')) {
                $table->dropColumn('layout');
            }
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        if (! Schema::hasTable('cms_sections')) {
            return;
        }

        Schema::table('cms_sections', function (Blueprint $table) {
            if (! Schema::hasColumn('cms_sections', 'type')) {
                $table->string('type')->default('default')->after('name');
            }
        });

        if (Schema::hasColumn('cms_sections', 'section_layout') && ! Schema::hasColumn('cms_sections', 'template')) {
            Schema::table('cms_sections', function (Blueprint $table) {
                $table->renameColumn('section_layout', 'template');
            });
        }
    }
};
