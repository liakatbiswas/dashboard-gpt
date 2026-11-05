@props(['name', 'label', 'value' => '', 'type' => 'text', 'required' => false])

<div>
    <label for="{{ $name }}" class="form-label">
        {{ $label }} @if ($required)<span class="text-rose-600 dark:text-rose-400" aria-hidden="true">*</span>@endif
    </label>
    <input id="{{ $name }}" name="{{ $name }}" type="{{ $type }}"
        @if ($type !== 'password') value="{{ old($name, $value) }}" @endif
        @required($required)
        aria-invalid="{{ $errors->has($name) ? 'true' : 'false' }}"
        @if ($errors->has($name)) aria-describedby="{{ $name }}-error" @endif
        {{ $attributes->class(['form-input', 'is-invalid' => $errors->has($name)]) }}>
    @error($name)
        <p id="{{ $name }}-error" class="field-error" role="alert">{{ $message }}</p>
    @enderror
</div>
