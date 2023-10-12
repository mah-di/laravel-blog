<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
            &nbsp;&nbsp;|&nbsp;&nbsp;
            {{ $user->name }}
        </h2>
    </x-slot>

    @if (session('message'))
    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="py-2 px-4 sm:py-2 sm:px-8 bg-white shadow sm:rounded-lg">
                <p style="color: #58CCBD;"><b>{{ session('message') }}</b></p>
            </div>
        </div>
    </div>
    @endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 flex justify-between">
                    <div>
                        <p>
                            <b>Blogs ••• {{ $user->blogs->count() }}</b>
                        </p>
                        <p>
                            <b>Total Likes: {{ $user->totalBlogLikes() }}</b>
                        </p>
                        <p>
                            <b>Most Liked: <a href="{{ route('blog.show', $user->getMostLikedBlog()->id) }}" style="color: yellowgreen;">{{ $user->getMostLikedBlog()->title_upper }} ({{ $user->getMostLikedBlog()->getLikesCount() }} Likes)</a></b>
                        </p>
                        <p>
                            <b>Most Commented: <a href="{{ route('blog.show', $user->getMostCommentedBlog()->id) }}" style="color: yellowgreen;">{{ $user->getMostCommentedBlog()->title_upper }} ({{ $user->getMostCommentedBlog()->getCommentsCount() }} Comments)</a></b>
                        </p>
                    </div>
                    <div>
                        <p>
                            <b>Comments ••• {{ $user->comments->count() }}</b>
                        </p>
                        <p>
                            <b>Total Likes: {{ $user->totalCommentLikes() }}</b>
                        </p>
                        <p>
                            <b>Most Liked: <a href="{{ route('blog.show', $user->getMostLikedComment()->blog->id) }}" style="color: yellowgreen;">{{ $user->getMostLikedComment()->body_preview }} ({{ $user->getMostLikedComment()->getLikesCount() }} Likes)</a></b>
                        </p>
                        <p>
                            <b>Most Replied: <a href="{{ route('blog.show', $user->getMostRepliedComment()->blog->id) }}" style="color: yellowgreen;">{{ $user->getMostRepliedComment()->body_preview }} ({{ $user->getMostRepliedComment()->getRepliesCount() }} Replies)</a></b>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
