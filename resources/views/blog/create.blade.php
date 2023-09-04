<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $user->name }}
        </h2>
    </x-slot>

    @if (session('error'))
    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="py-2 px-4 sm:py-2 sm:px-8 bg-white shadow sm:rounded-lg">
                <p style="color: red;"><b>{{ session('error') }}</b></p>
            </div>
        </div>
    </div>
    @endif

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                @include('blog.partials.blog-create-form')
            </div>
        </div>
    </div>
</x-app-layout>