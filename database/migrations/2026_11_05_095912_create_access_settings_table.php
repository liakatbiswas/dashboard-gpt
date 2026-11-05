<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $roleId = DB::table(config('permission.table_names.roles'))
            ->where('name', 'super-admin')->where('guard_name', 'web')->value('id');
        $owners = $roleId
            ? DB::table(config('permission.table_names.model_has_roles'))
                ->where('role_id', $roleId)->where('model_type', (new User)->getMorphClass())
                ->distinct()->pluck(config('permission.column_names.model_morph_key', 'model_id'))
            : collect();

        if ($owners->count() > 1) {
            throw new RuntimeException('More than one super-admin exists. Choose the single owner before running this migration.');
        }

        Schema::create('access_settings', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('super_admin_user_id')->nullable()->unique()->constrained('users')->restrictOnDelete();
            $table->boolean('student_registration_enabled')->default(true);
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        DB::table('access_settings')->insert([
            'id' => 1,
            'super_admin_user_id' => $owners->first(),
            'student_registration_enabled' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('access_settings');
    }
};
