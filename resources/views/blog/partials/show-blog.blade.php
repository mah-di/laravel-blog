<section>
    <div>
        @if (Auth::user() == $blogger)
        <div style="display: flex; justify-content: end;">
            <a href="{{ route('blog.edit', $blog->id) }}"><x-primary-button>{{ __('Update') }}</x-primary-button></a>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <x-danger-button
                x-data=""
                x-on:click.prevent="$dispatch('open-modal', 'confirm-blog-deletion')"
            >{{ __('Delete') }}</x-danger-button>

            <x-modal name="confirm-blog-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
                <form method="post" action="{{ route('blog.delete', $blog->id) }}" class="p-6">
                    @csrf
                    @method('delete')

                    <h2 class="text-lg font-medium text-gray-900">
                        {{ __('Are you sure you want to delete this blog?') }}
                    </h2>

                    <p class="mt-1 text-sm text-gray-600">
                        {{ __('Once the blog is deleted, all of its resources and data will be permanently deleted.') }}
                    </p>

                    <div class="mt-6 flex justify-end">
                        <x-secondary-button x-on:click="$dispatch('close')">
                            {{ __('Cancel') }}
                        </x-secondary-button>

                        <x-danger-button class="ml-3">
                            {{ __('Delete Blog') }}
                        </x-danger-button>
                    </div>
                </form>
            </x-modal>
        </div>
        <br>
        @endif

        <div>
            <img style="max-height: 300px; width: 100%" src="{{ $blog->cover_image_url }}" alt="cover image">
            <div style="margin-top:20px">
                <h2 class="text-lg font-medium text-gray-900">
                    {{ $blog->title_upper }}
                </h2><br>
                <small><i>Author: <b><a href="{{ route('profile.show', $blogger->id) }}">{{ $blogger->name }}</a></b></i></small><br>
                <small><i>Posted at: {{ $blog->date_created }}</i></small><br>
                @if($blog->category)
                <small>
                    <i>Posted in:</i>&nbsp;&nbsp;
                    <span class="px-1 py-1 bg-gray-100 rounded">{{ $blog->category->name }}</span>
                    @if($blog->sub_category)
                     → 
                    <span class="px-1 py-1 bg-gray-100 rounded">{{ $blog->sub_category->name }}</span>
                    @endif
                </small><br>
                @endif
            </div>
        </div>

        <br><hr><br>

        <div>
            <p>{!! nl2br($blog->body) !!}</p>
        </div>

        
    </div>
    
</section>
