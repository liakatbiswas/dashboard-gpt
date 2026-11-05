<x-app-layout title="Edit Role">
    @include('backend.access.catalog-form', ['catalog' => 'roles', 'singular' => 'Role', 'record' => $role])
</x-app-layout>
