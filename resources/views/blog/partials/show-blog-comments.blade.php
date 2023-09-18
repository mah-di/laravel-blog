<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Comments') }}
        </h2>
        <small>{{ $blog->getCommentsCount() }} {{ __('Comments on this blog') }}</small>
    </header>

    <hr class="mb-4 mt-4">

    <div>
        <form class="rounded" style="overflow: hidden" method="post" action="">
            @csrf
            <input type="hidden" name="blog_id" value="{{ $blog->id }}">
            <div>
                <textarea placeholder="{{ __('Write a comment') }}" rows="4" id="body" name="body" class="block w-full shadow border-gray-100" required autofocus autocomplete="body" >{{old('body')}}</textarea>
                <x-input-error class="mt-2" :messages="$errors->get('body')" />
            </div>

            <div class="flex items-center">
                <button type="submit"style="display: block; width: 100%; background-color: #91D0C6; color: white;" class="py-1">{{ __('Comment') }}</button>
            </div>
        </form>
    </div>
    
    <div class="mb-4 mt-4">
        @foreach ($blog->comments as $comment)
        <div class="rounded px-2" style="border-left: 2px solid #A5B7A5">
            <div class="mb-4 mt-4">
                <div class="mb-4 px-4 py-4 bg-gray-100 rounded">
                    <div class="mb-4" style="display: flex; justify-content: space-between">
                        <div>
                            <a href="{{ route('profile.show', $comment->user->id) }}" style="color: #58CCBD">{{ $comment->user->name }}</a>
                            <small>{{ $comment->date_created }}</small>
                        </div>

                        <div>
                            @if (Auth::user() == $blogger)
                                <a href="{{ route('blog.edit', $blog->id) }}"><x-secondary-button>{{ __('Update') }}</x-secondary-button></a>
                                &nbsp;&nbsp;
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
                            @endif
                        </div>
                    </div>
                    <hr>
                    <div class="mt-2 mb-2">
                        <p>{{ $comment->body }}</p>
                    </div>
                </div>
            
                <div>
                    <form class="rounded" style="overflow: hidden" method="post" action="">
                        @csrf
                        <input type="hidden" name="blog_id" value="{{ $blog->id }}">
                        <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                        <div>
                            <textarea placeholder="{{ __('Write a reply') }}" rows="2" id="body" name="body" class="block w-full shadow border-gray-100" required autofocus autocomplete="body" >{{old('body')}}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('body')" />
                        </div>

                        <div class="flex items-center">
                            <button type="submit"style="display: block; width: 100%; background-color: #91D0C6; color: white;" class="py-1">{{ __('Reply') }}</button>
                        </div>
                    </form>
                </div>
            </div>
            
            @foreach ($comment->replies as $reply)
            <div class="rounded px-2" style="border-left: 2px solid #A5B7A5">
                <div class="mb-4 mt-4">
                    <div class="mb-4 px-4 py-4 bg-gray-100 rounded">
                        <div class="mb-4" style="display: flex; justify-content: space-between">
                            <div>
                                <a href="{{ route('profile.show', $reply->user->id) }}" style="color: #58CCBD">{{ $reply->user->name }}</a>
                                <small>{{ $reply->date_created }}</small>
                            </div>

                            <div>
                                @if (Auth::user() == $blogger)
                                    <a href="{{ route('blog.edit', $blog->id) }}"><x-secondary-button>{{ __('Update') }}</x-secondary-button></a>
                                    &nbsp;&nbsp;
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
                                @endif
                            </div>
                        </div>
                        <hr>
                        <div class="mb-2 mt-2">
                            <p>{{ $reply->body }}</p>
                        </div>
                    </div>
                    
                    <div>
                        <form class="rounded" style="overflow: hidden" method="post" action="">
                            @csrf
                            <input type="hidden" name="blog_id" value="{{ $blog->id }}">
                            <input type="hidden" name="parent_id" value="{{ $reply->id }}">
                            <div>
                                <textarea placeholder="{{ __('Write a reply') }}" rows="2" id="body" name="body" class="block w-full shadow border-gray-100" required autofocus autocomplete="body" >{{old('body')}}</textarea>
                                <x-input-error class="mt-2" :messages="$errors->get('body')" />
                            </div>

                            <div class="flex items-center">
                                <button type="submit"style="display: block; width: 100%; background-color: #91D0C6; color: white;" class="py-1">{{ __('Reply') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
                    
                    @foreach ($reply->replies as $reply)
                    <div class="rounded px-2" style="border-left: 2px solid #A5B7A5">
                        <div class="mb-4 px-4 py-4 bg-gray-100 rounded">
                            <div class="mb-4" style="display: flex; justify-content: space-between">
                                <div>
                                    <a href="{{ route('profile.show', $reply->user->id) }}" style="color: #58CCBD">{{ $reply->user->name }}</a>
                                    <small>{{ $reply->date_created }}</small>
                                </div>

                                <div>
                                    @if (Auth::user() == $blogger)
                                        <a href="{{ route('blog.edit', $blog->id) }}"><x-secondary-button>{{ __('Update') }}</x-secondary-button></a>
                                        &nbsp;&nbsp;
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
                                    @endif
                                </div>
                            </div>
                            <hr>
                            <div class="mb-2 mt-2">
                                <p>{{ $reply->body }}</p>
                            </div>
                        </div>
                    </div>
    
                    @endforeach
                </div>
    
                @endforeach
        </div>
        @endforeach
    </div>
    
</section>
