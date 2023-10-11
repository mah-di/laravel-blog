<x-app-layout>
    <x-slot name="header">
        <h1 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="{{ route('category.blogs.show', $subCategory->category->id) }}">{{ $subCategory->category->name }}</a>&nbsp;&nbsp;&nbsp;→&nbsp;&nbsp;&nbsp;{{ $subCategory->name }}
        </h1>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6"> 
            <section class="bg-gray-100 dark:bg-gray-900 py-10 px-12">
                @if ($subCategory->blogs->count() > 0)
                    <div id="blogs" class="text-neutral-600"></div>

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
        const blogsCount = {{ $subCategory->blogs->count() }}

        let next = null

        const createBlogCards = ( data ) => {
            let cards = ''

            data.forEach( blog => {

                cards += `
                    <div class="py-4">
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
                                        <div style="display: flex; align-items: center; padding-bottom: 20px">
                                            <a href="http://localhost:8000/profile/${ blog.user_id }">
                                                <img height="32px" width="32px" src="${ blog.user_avatar }" style="border: 2px solid limegreen;border-radius: 50%; display:block;" alt="profile image">
                                            </a>
                                            &nbsp;&nbsp;&nbsp;
                                            <a href="http://localhost:8000/profile/${ blog.user_id }">
                                                <b>${ blog.user_name }</b>
                                            </a>
                                        </div>
                                        <small>
                                            <a href="http://localhost:8000/category/${ blog.category_id }">
                                            <span class="px-1 py-1 bg-gray-100 rounded">${ blog.category }</span>
                                            </a>
                                            → 
                                            <a href="http://localhost:8000/sub_category/${ blog.sub_category_id }">
                                                <span class="px-1 py-1 bg-gray-100 rounded">${ blog.sub_category }</span>
                                            </a>
                                        </small>
                                        <br>
                                        <small class="leading-5 text-gray-700 dark:text-gray-400">
                                            ${ blog.date_created }
                                        </small>

                                        <p
                                            class="leading-5 text-gray-500 dark:text-gray-400">
                                            ${ blog.body }
                                        </p>
                                    </figcaption>
                                </figure>
                            </a>
                        </div>
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
                    document.querySelector( '#blogs' ).innerHTML += blogCards
                    
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
                fetchBlogs("http://localhost:8000/api/sub_category/blogs/{{ $subCategory->id }}")
            })
        }
    </script>

</x-app-layout>