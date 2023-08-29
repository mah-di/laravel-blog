<!-- Card Item -->
<div
    style="overflow: hidden"
    class="my-8 rounded shadow-lg shadow-gray-200 dark:shadow-gray-900 bg-white dark:bg-gray-800 duration-300 hover:-translate-y-1"
    x-for="(post, index) in posts">
    <!-- Clickable Area -->
    <a href="{{ route('blog.show', $blogPost->id) }}" class="cursor-pointer">
        <figure>
            <!-- Image -->
            <img
                src="{{ $blogPost->cover_image_url }}?auto=format&fit=crop&w=400&q=50"
                class="rounded-t h-72 w-full object-cover" />

            <figcaption class="p-4">
                <!-- Title -->
                <h3
                    class="text-lg mb-4 font-bold leading-relaxed text-gray-800 dark:text-gray-300"
                    x-text="post.title">
                    <!-- Post Title -->
                    <b>
                        {{ $blogPost->title_upper }}
                    </b>
                </h3>

                <!-- Description -->
                <small class="leading-5 text-gray-700 dark:text-gray-400">
                    {{ $blogPost->date_created }}
                </small>
                <br>
                <p
                    class="leading-5 text-gray-500 dark:text-gray-400"
                    x-text="post.description">
                    <!-- Post Description -->
                    {{ $blogPost->body_preview }}
                </p>
            </figcaption>
        </figure>
    </a>
</div>
