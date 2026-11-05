@if (session('success'))
    <div class="notice-success" role="status">{{ session('success') }}</div>
@endif
@if ($errors->any())
    <div class="notice-error" role="alert">
        <p class="font-semibold">Please check the following:</p>
        <ul class="mt-2 list-disc space-y-1 ps-5">
            @foreach ($errors->all() as $message)<li>{{ $message }}</li>@endforeach
        </ul>
    </div>
@endif
