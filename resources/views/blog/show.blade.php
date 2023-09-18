<x-app-layout>

    @if (session('message'))
    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="py-2 px-4 sm:py-2 sm:px-8 bg-white shadow sm:rounded-lg">
                <p style="color: #58CCBD;"><b>{{ session('message') }}</b></p>
            </div>
        </div>
    </div>
    @endif

    @if (session('error'))
    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="py-2 px-4 sm:py-2 sm:px-8 bg-white shadow sm:rounded-lg">
                <p style="color: red;"><b>{{ session('error') }}</b></p>
            </div>
        </div>
    </div>
    @endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                @include('blog.partials.show-blog')
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6"> 
            <section  class="bg-gray-100 dark:bg-gray-900 py-10 px-12">
                <!-- Card Grid -->
                @if ($relatedBlogs->count() > 1)
                    <h2>More blogs by <b><a href="{{ route('profile.show', $blogger->id) }}">{{ $blogger->name }}</a></b></h2><br>
                    <div class="grid grid-flow-row grid-gap text-neutral-600 md-grid-cols-4 sm:grid-cols-1">
                    @foreach($relatedBlogs as $blogPost)

                        @if($blogPost->id !== $blog->id)

                            @include('blog.partials.blog-card')

                        @endif
                        
                    @endforeach
                    </div>
                @endif
            </section>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6"> 
            <section  class="bg-gray-100 dark:bg-gray-900 py-10 px-12">
                <!-- Card Grid -->
                @if ($categoryRelatedBlogs->count() > 1)
                    <h2>Related blogs on <b><a href="{{ route('profile.show', $blogger->id) }}">{{ $blog->category->name }}</a></b> Category</h2><br>
                    <div class="grid grid-flow-row grid-gap text-neutral-600 md-grid-cols-4 sm:grid-cols-1">
                    @foreach($categoryRelatedBlogs as $blogPost)

                        @if($blogPost->id !== $blog->id)

                            @include('blog.partials.blog-card')

                        @endif
                        
                    @endforeach
                    </div>
                @endif
            </section>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6"> 
            <section  class="bg-gray-100 dark:bg-gray-900 py-10 px-12">
                <!-- Card Grid -->
                @if ($subCategoryRelatedBlogs->count() > 1)
                    <h2>More blogs on <b><a href="{{ route('profile.show', $blogger->id) }}">{{ $blog->sub_category->name }}</a></b> Sub Category</h2><br>
                    <div class="grid grid-flow-row grid-gap text-neutral-600 md-grid-cols-4 sm:grid-cols-1">
                    @foreach($subCategoryRelatedBlogs as $blogPost)

                        @if($blogPost->id !== $blog->id)

                            @include('blog.partials.blog-card')

                        @endif
                        
                    @endforeach
                    </div>
                @endif
            </section>
        </div>
    </div>
</x-app-layout>
