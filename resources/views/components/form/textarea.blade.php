@props(['name', 'label', 'value' => ''])

<div>
    <label for="{{ $name }}" class="form-label">{{ $label }}</label>
    <textarea id="{{ $name }}" name="{{ $name }}"
        aria-invalid="{{ $errors->has($name) ? 'true' : 'false' }}"
        @if ($errors->has($name)) aria-describedby="{{ $name }}-error" @endif
        {{ $attributes->class(['form-input', 'is-invalid' => $errors->has($name)])->merge(['rows' => 3]) }}>{{ old($name, $value) }}</textarea>
    @error($name)
        <p id="{{ $name }}-error" class="field-error" role="alert">{{ $message }}</p>
    @enderror
</div>
