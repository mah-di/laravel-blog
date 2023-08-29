<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $user->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                @include('profile.partials.show-profile')
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6"> 
            <section  class="bg-gray-100 dark:bg-gray-900 py-10 px-12">
                @if(Auth::user() && Auth::user()->id == $user->id)
                <h1 class="font-semibold text-xl">Your Blogs</h1><br>
                @else
                <h1 class="font-semibold text-xl">Blogs by {{ $user->name }}</h1><br>
                @endif
                <!-- Card Grid -->
                @if ($blogs->count() > 0)
                    <div class="grid grid-flow-row grid-gap text-neutral-600 md:grid-cols-2 sm:grid-cols-1">
                    @foreach($blogs as $blogPost)

                        @include('blog.partials.blog-card')
                        
                    @endforeach
                    </div>
                @else
                <div class="my-8 rounded shadow-lg shadow-gray-200 dark:shadow-gray-900 bg-white dark:bg-gray-800" style="display: flex; justify-content: center; align-items: center; min-height: 200px">
                    <p>Wow, such empty..</p>
                </div>
                @endif
            </section>
        </div>
    </div>
</x-app-layout>