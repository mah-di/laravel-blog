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
            <section class="bg-gray-100 dark:bg-gray-900 py-10 px-12">
                @if(Auth::user() && Auth::user()->id == $user->id)
                <h1 class="font-semibold text-xl">Your Blogs</h1><br>
                @else
                <h1 class="font-semibold text-xl">Blogs by {{ $user->name }}</h1><br>
                @endif
                <!-- Card Grid -->
                @if ($user->blogs->count() > 0)
                    <div id="user-blogs" class="grid grid-flow-row grid-gap text-neutral-600 md:grid-cols-2 sm:grid-cols-1"></div>

                    <div id="next-button-container" class="py-4 flex items-center"></div>
                @else
                <div id="blogs" class="my-8 rounded shadow-lg shadow-gray-200 dark:shadow-gray-900 bg-white dark:bg-gray-800" style="display: flex; justify-content: center; align-items: center; min-height: 200px" onload="fetchBlogs()">
                    <p>Wow, such empty..</p>
                </div>
                @endif
            </section>
        </div>
    </div>

    <script>
        const blogsCount = {{ $user->blogs->count() }}

        let next = null

        const createBlogCards = ( data ) => {
            let cards = ''

            data.forEach( blog => {

                cards += `
                    <div
                        style="overflow: hidden"
                        class="my-8 rounded shadow-lg shadow-gray-200 dark:shadow-gray-900 bg-white dark:bg-gray-800 duration-300 hover:-translate-y-1">
                        <!-- Clickable Area -->
                        <a href="${ blog.url }" class="cursor-pointer">
                            <figure>
                                <!-- Image -->
                                <img
                                    src="${ blog.cover_image }?auto=format&fit=crop&w=400&q=50"
                                    class="rounded-t h-72 w-full object-cover" />
    
                                <figcaption class="p-4">
                                    <!-- Title -->
                                    <h3
                                    class="text-lg mb-4 font-bold leading-relaxed text-gray-800 dark:text-gray-300">
                                    <b>
                                    ${ blog.title }
                                    </b>
                                    </h3>
    
                                    <!-- Description -->
                                    <small>
                                        <a href="${ blog.category.url }">
                                            <span class="px-1 py-1 bg-gray-100 rounded">${ blog.category.name }</span>
                                        </a>
                                        → 
                                        <a href="${ blog.sub_category.url }">
                                            <span class="px-1 py-1 bg-gray-100 rounded">${ blog.sub_category.name }</span>
                                        </a>
                                    </small>
                                    <br>
                                    <small class="leading-5 text-gray-700 dark:text-gray-400">
                                        ${ blog.date_created }
                                    </small>

                                    <p
                                        class="leading-5 text-gray-500 dark:text-gray-400">
                                        ${ blog.body_preview }
                                    </p>
                                </figcaption>
                            </figure>
                        </a>
                    </div>
                `
            })

            return cards
        }

        const fetchBlogs = ( url ) => {
            fetch( url )
                .then( ( response ) => response.json() )
                .then( ( response ) => {
                    let blogCards = createBlogCards( response.data )
                    document.querySelector( '#user-blogs' ).innerHTML += blogCards
                    
                    if ( response.links.next !== null ) {
                        next = response.links.next
                        let nextButton = `
                            <button onclick="fetchBlogs('${ next }')" style="display: block; width: 100%; background-color: #91D0C6; color: white;" class="py-2 shadow rounded">Show More</button>
                        `

                        document.querySelector( '#next-button-container' ).innerHTML += nextButton
                    } else {
                        next = null
                        
                        document.querySelector( '#next-button-container' ).innerHTML = ''
                    }
                })
                .catch( ( error ) => console.log( error ) )

        }

        if ( blogsCount > 0 ) {
            window.addEventListener( "load", ( event ) => {
                fetchBlogs("http://localhost:8000/api/blogs/{{ $user->id }}")
            })
        }
    </script>

</x-app-layout>