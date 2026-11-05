<x-app-layout title="Edit Permission">
    @include('backend.access.catalog-form', ['catalog' => 'permissions', 'singular' => 'Permission', 'record' => $permission])
</x-app-layout>
