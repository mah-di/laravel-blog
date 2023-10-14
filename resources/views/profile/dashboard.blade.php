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
                        <h2 class="py-2 font-semibold text-xl text-gray-800 leading-tight">
                            Blogs ••• {{ $user->blogs->count() }}
                        </h2>
                        <hr class="py-2">
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
                        <h2 class="py-2 font-semibold text-xl text-gray-800 leading-tight">
                            Comments ••• {{ $user->comments->count() }}
                        </h2>
                        <hr class="py-2">
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

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="py-2 font-semibold text-xl text-gray-800 leading-tight">
                        Liked Blogs ••• {{ $user->liked_blogs_count }}
                    </h2>
                    <hr class="py-2">
                    <div id="liked-blogs">

                    </div>
                    <div id="liked-blogs-next-button-container" class="py-4 flex items-center">
    
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="py-2 font-semibold text-xl text-gray-800 leading-tight">
                        Liked Comments ••• {{ $user->liked_comments_count }}
                    </h2>
                    <hr class="py-2">
                    <div id="liked-comments">

                    </div>
                    <div id="liked-comments-next-button-container" class="py-4 flex items-center">
    
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const createLikedBlogElement = ( data ) => {
            let element = ``

            data.forEach( ( like ) => {
                element += `
                    <div class="py-1">
                        <a href="${ like.blog.url }">
                            <p style="background: #f9f9f9; padding: 3px">
                                You Liked a Blog | <span style="color: yellowgreen;">${ like.blog.title }</span> on <span style="color: yellowgreen;">${ like.date_created }</span>
                            </p>
                        </a>
                    </div>
                `
            })

            return element
        }

        const createLikedCommentElement = ( data ) => {
            let element = ``

            data.forEach( ( like ) => {
                element += `
                    <div class="py-1">
                        <a href="${ like.comment.url }">
                            <p style="background: #f9f9f9; padding: 3px">
                                You Liked a Comment | <span style="color: yellowgreen;">${ like.comment.body_preview }</span> on <span style="color: yellowgreen;">${ like.date_created }</span>
                            </p>
                        </a>
                    </div>
                `
            })

            return element
        }

        const createNextButton = ( callbackFn, nextUrl ) => {
            let button = `
                <button onclick="${ callbackFn }('${ nextUrl }')" style="display: block; width: 100%; background-color: #91D0C6; color: white;" class="py-2 shadow rounded">Show More</button>
            `

            return button
        }

        const fetchLikedBlogs = ( url ) => {
            fetch(url)
                .then( ( response ) => response.json() )
                .then( ( response ) => {
                    let likedBlogElement = createLikedBlogElement( response.data )
                    document.querySelector('#liked-blogs').innerHTML += likedBlogElement

                    if ( response.links.next !== null ) {
                        let nextButton = createNextButton( 'fetchLikedBlogs', response.links.next )
                        document.querySelector('#liked-blogs-next-button-container').innerHTML = nextButton
                    } else {
                        document.querySelector('#liked-blogs-next-button-container').innerHTML = null
                    }
                })
                .catch( ( error ) => console.log(error) )
        }

        const fetchLikedComments = ( url ) => {
            fetch(url)
                .then( ( response ) => response.json() )
                .then( ( response ) => {
                    let likedCommentElement = createLikedCommentElement( response.data )
                    document.querySelector('#liked-comments').innerHTML += likedCommentElement

                    if ( response.links.next !== null ) {
                        let nextButton = createNextButton( 'fetchLikedComments', response.links.next )
                        document.querySelector('#liked-comments-next-button-container').innerHTML = nextButton
                    } else {
                        document.querySelector('#liked-comments-next-button-container').innerHTML = null
                    }
                })
                .catch( ( error ) => console.log(error) )
        }

        window.addEventListener( 'load', () => {
            fetchLikedBlogs( 'http://localhost:8000/api/user/{{ $user->id }}/liked-blogs' )
            fetchLikedComments( 'http://localhost:8000/api/user/{{ $user->id }}/liked-comments' )
        })
    </script>

</x-app-layout>