<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        foreach (['roles', 'permissions'] as $name) {
            Schema::table(config('permission.table_names.'.$name), function (Blueprint $table): void {
                $table->text('description')->nullable();
            });
        }
    }

    public function down(): void
    {
        foreach (['roles', 'permissions'] as $name) {
            Schema::table(config('permission.table_names.'.$name), function (Blueprint $table): void {
                $table->dropColumn('description');
            });
        }
    }
};
