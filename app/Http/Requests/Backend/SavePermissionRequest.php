<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SavePermissionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return (bool) $this->user()?->isSuperAdmin();
    }

    public function rules(): array
    {
        $record = $this->route('permission');

        return [
            'name' => ['required', 'string', 'max:100', 'regex:/^[a-z][a-z0-9_.-]*$/',
                Rule::unique(config('permission.table_names.permissions'), 'name')
                    ->where('guard_name', 'web')->ignore($record?->getKey())],
            'description' => ['nullable', 'string', 'max:500'],
        ];
    }
}
