<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Comments') }}
        </h2>
        <small>{{ $blog->getCommentsCount() }} {{ __('Comments on this blog') }}</small>
    </header>

    <hr class="mb-4 mt-4">

    <div>
        <form class="rounded" style="overflow: hidden" method="post" action="{{ route('blog.comment') }}">
            @csrf
            <input type="hidden" name="blog_id" value="{{ $blog->id }}">
            <input type="hidden" name="parent_id" value>
            <div>
                <textarea placeholder="{{ __('Write a comment') }}" rows="4" id="body" name="body" class="block w-full shadow border-gray-100" required autofocus autocomplete="body" >{{old('body')}}</textarea>
            </div>

            <div class="flex items-center">
                <button type="submit"style="display: block; width: 100%; background-color: #91D0C6; color: white;" class="py-1">{{ __('Comment') }}</button>
            </div>
        </form>
    </div>

    <div class="mb-4 mt-4">
        @foreach ($blog->comments as $comment)
        <div class="rounded px-2" style="border-left: 2px solid #A5B7A5">
            <div id="comment-{{ $comment->id }}" class="mb-4 mt-4">
                <div class="mb-4 px-4 py-4 bg-gray-100 rounded">
                    <div class="mb-4" style="display: flex; justify-content: space-between">
                        <div>
                            <a href="{{ route('profile.show', $comment->user->id) }}" style="color: #58CCBD">{{ $comment->user->name }}</a>
                            <small>{{ $comment->date_created }}</small>
                        </div>

                        <div>
                            @if (Auth::user() == $comment->user)
                                <x-secondary-button onclick='{{ "showUpdateForm($comment, `$csrfToken`)" }}'>✏️</x-secondary-button>
                                &nbsp;&nbsp;
                                <x-danger-button
                                    x-data=""
                                    x-on:click.prevent="$dispatch('open-modal', 'confirm-blog-deletion-{{ $comment->id }}')"
                                >☠️</x-danger-button>

                                <x-modal name="confirm-blog-deletion-{{ $comment->id }}" :show="$errors->userDeletion->isNotEmpty()" focusable>
                                    <form method="post" action="{{ route('comment.delete') }}" class="p-6">
                                        @csrf
                                        @method('delete')
                                        <input type="hidden" name="id" value="{{ $comment->id }}">

                                        <h2 class="text-lg font-medium text-gray-900">
                                            {{ __('Are you sure you want to delete this comment?') }}
                                        </h2>

                                        <div class="mt-6 flex justify-end">
                                            <x-secondary-button x-on:click="$dispatch('close')">
                                                {{ __('Cancel') }}
                                            </x-secondary-button>
        
                                            <x-danger-button class="ml-3">
                                                {{ __('Delete Comment') }}
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
                    <br>

                    <div style="display: flex; justify-content: space-between;">
                        @if (Auth::user())
                            @if ($comment->isLiked())
                            <form method="post" action="{{ route('comment.unlike', $comment->id) }}">
                                @csrf
                                @method('delete')
                                <x-secondary-submit-button>{{ __('💔 Unlike') }}</x-secondary-submit-button>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                {{ $comment->getLikesCount() }} likes
                            </form>
    
                            @else
                            <form method="post" action="{{ route('comment.like', $comment->id) }}">
                                @csrf
                                <x-secondary-submit-button>{{ __('❤️ Like') }}</x-secondary-submit-button>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                {{ $comment->getLikesCount() }} likes
                            </form>
                            @endif
    
                        @else
                            <div>{{ $comment->getLikesCount() }} likes</div>
                        @endif
    
                        <x-secondary-button class="show-reply-form " id="show-reply-form-{{ $comment->id }}" onclick='{{ "showReplyForm($comment->id)" }}'>{{ __("Reply To This Comment ⤴") }}</x-secondary-button>
                    </div>

                </div>

                <div>
                    <form id="reply-form-{{ $comment->id }}" class="rounded" style="overflow: hidden; display: none;" method="post" action="{{ route('blog.comment') }}">
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
                <div id="comment-{{ $reply->id }}" class="mb-4 mt-4">
                    <div class="mb-4 px-4 py-4 bg-gray-100 rounded">
                        <div class="mb-4" style="display: flex; justify-content: space-between">
                            <div>
                                <a href="{{ route('profile.show', $reply->user->id) }}" style="color: #58CCBD">{{ $reply->user->name }}</a>
                                <small>{{ $reply->date_created }}</small>
                            </div>

                            <div>
                                @if (Auth::user() == $reply->user)
                                    <x-secondary-button onclick='{{ "showUpdateForm($reply, `$csrfToken`)" }}'>✏️</x-secondary-button>
                                    &nbsp;&nbsp;
                                    <x-danger-button
                                        x-data=""
                                        x-on:click.prevent="$dispatch('open-modal', 'confirm-blog-deletion-{{ $reply->id }}')"
                                    >☠️</x-danger-button>
            
                                    <x-modal name="confirm-blog-deletion-{{ $reply->id }}" :show="$errors->userDeletion->isNotEmpty()" focusable>
                                        <form method="post" action="{{ route('comment.delete') }}" class="p-6">
                                            @csrf
                                            @method('delete')
                                            <input type="hidden" name="id" value="{{ $reply->id }}">
            
                                            <h2 class="text-lg font-medium text-gray-900">
                                                {{ __('Are you sure you want to delete this comment?') }}
                                            </h2>
            
                                            <div class="mt-6 flex justify-end">
                                                <x-secondary-button x-on:click="$dispatch('close')">
                                                    {{ __('Cancel') }}
                                                </x-secondary-button>
            
                                                <x-danger-button class="ml-3">
                                                    {{ __('Delete Comment') }}
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
                        <br>

                        <div style="display: flex; justify-content: space-between;">
                            @if (Auth::user())
                                @if ($reply->isLiked())
                                <form method="post" action="{{ route('comment.unlike', $reply->id) }}">
                                    @csrf
                                    @method('delete')
                                    <x-secondary-submit-button>{{ __('💔 Unlike') }}</x-secondary-submit-button>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    {{ $reply->getLikesCount() }} likes
                                </form>
    
                                @else
                                <form method="post" action="{{ route('comment.like', $reply->id) }}">
                                    @csrf
                                    <x-secondary-submit-button>{{ __('❤️ Like') }}</x-secondary-submit-button>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    {{ $reply->getLikesCount() }} likes
                                </form>
                                @endif
    
                            @else
                                <div>{{ $reply->getLikesCount() }} likes</div>
                            @endif
    
                            <x-secondary-button class="show-reply-form" id="show-reply-form-{{ $reply->id }}" onclick='{{ "showReplyForm($reply->id)" }}'>{{ __("Reply To This Comment ⤴") }}</x-secondary-button>
                        </div>

                    </div>

                    <div>
                        <form id="reply-form-{{ $reply->id }}" class="rounded" style="overflow: hidden; display: none;" method="post" action="{{ route('blog.comment') }}">
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
                    <div id="comment-{{ $reply->id }}" class="rounded px-2" style="border-left: 2px solid #A5B7A5">
                        <div class="mb-4 px-4 py-4 bg-gray-100 rounded">
                            <div class="mb-4" style="display: flex; justify-content: space-between">
                                <div>
                                    <a href="{{ route('profile.show', $reply->user->id) }}" style="color: #58CCBD">{{ $reply->user->name }}</a>
                                    <small>{{ $reply->date_created }}</small>
                                </div>

                                <div>
                                    @if (Auth::user() == $reply->user)
                                        <x-secondary-button onclick='{{ "showUpdateForm($reply, `$csrfToken`)" }}'>✏️</x-secondary-button>
                                        &nbsp;&nbsp;
                                        <x-danger-button
                                            x-data=""
                                            x-on:click.prevent="$dispatch('open-modal', 'confirm-comment-deletion-{{ $reply->id }}')"
                                        >☠️</x-danger-button>

                                        <x-modal name="confirm-comment-deletion-{{ $reply->id }}" :show="$errors->userDeletion->isNotEmpty()" focusable>
                                            <form method="post" action="{{ route('comment.delete') }}" class="p-6">
                                                @csrf
                                                @method('delete')
                                                <input type="hidden" name="id" value="{{ $reply->id }}">

                                                <h2 class="text-lg font-medium text-gray-900">
                                                    {{ __('Are you sure you want to delete this comment?') }}
                                                </h2>

                                                <div class="mt-6 flex justify-end">
                                                    <x-secondary-button x-on:click="$dispatch('close')">
                                                        {{ __('Cancel') }}
                                                    </x-secondary-button>

                                                    <x-danger-button class="ml-3">
                                                        {{ __('Delete Comment') }}
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
                            <br>

                            @if (Auth::user())
                                @if ($reply->isLiked())
                                <form method="post" action="{{ route('comment.unlike', $reply->id) }}">
                                    @csrf
                                    @method('delete')
                                    <x-secondary-submit-button>{{ __('💔 Unlike') }}</x-secondary-submit-button>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    {{ $reply->getLikesCount() }} likes
                                </form>

                                @else
                                <form method="post" action="{{ route('comment.like', $reply->id) }}">
                                    @csrf
                                    <x-secondary-submit-button>{{ __('❤️ Like') }}</x-secondary-submit-button>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    {{ $reply->getLikesCount() }} likes
                                </form>
                                @endif

                            @else
                                <div>{{ $reply->getLikesCount() }} likes</div>
                            @endif

                        </div>
                    </div>

                    @endforeach
                </div>

                @endforeach
        </div>
        @endforeach
    </div>

</section>

<script>
    let showReplyForm = function (id) {
        document.querySelector('#show-reply-form-'+id).style.display = 'none';
        document.querySelector('#reply-form-'+id).style.display = 'block';
    }

    let showUpdateForm = function (comment, csrfToken) {
        let form = `
            <div id="update-form-${comment.id}">
                <form class="rounded" style="overflow: hidden" method="post" action="/comment/update">
                    <input type="hidden" name="_token" value=${csrfToken}>
                    <input type="hidden" name="_method" value="patch">
                    <input type="hidden" name="id" value=${comment.id}>
                    <input type="hidden" name="blog_id" value=${comment.blog_id}>
                    <input type="hidden" name="parent_id" value=${comment.parent_id}>
                    <div>
                        <textarea placeholder="Write a reply" rows="2" id="body" name="body" class="block w-full shadow border-gray-100" required autofocus autocomplete="body" >${comment.body}</textarea>
                    </div>

                    <div class="flex items-center">
                        <button type="submit" style="display: block; width: 100%; background-color: #91D0C6; color: white;" class="py-1">Update Comment</button>
                        <button type="button" style="display: block; width: 100%; background-color: #F3F3F3; color: gray;" class="py-1" onclick="cancelUpdate(${comment.id})">Cancel</button>
                    </div>
                </form>
            </div>`
        document.querySelector('#comment-' + comment.id + '>div').style.display = 'none'
        document.querySelector('#comment-' + comment.id).innerHTML += form
    }

    let cancelUpdate = function (id) {
        document.querySelector('#comment-' + id + '>div').style.display = 'block'
        document.querySelector('#update-form-' + id).remove()
    }
</script>
