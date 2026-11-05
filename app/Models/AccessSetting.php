<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AccessSetting extends Model
{
    protected $fillable = ['super_admin_user_id', 'student_registration_enabled', 'updated_by'];

    protected function casts(): array
    {
        return ['super_admin_user_id' => 'integer', 'student_registration_enabled' => 'boolean'];
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
