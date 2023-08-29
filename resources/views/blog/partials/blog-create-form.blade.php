<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Write A Blog') }}
        </h2>
    </header>

    <form method="post" action="{{ route('blog.create') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        
        <div>
            <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title')" required autofocus autocomplete="title" />
            <x-input-error class="mt-2" :messages="$errors->get('title')" />
        </div>
        <div>
            <textarea id="body" name="body" class="mt-1 block w-full" required autofocus autocomplete="body" >{{old('body')}}</textarea>
            <x-input-error class="mt-2" :messages="$errors->get('body')" />
        </div>
        <div>
            <x-text-input id="cover_image" name="cover_image" type="file" class="mt-1 block w-full" autofocus autocomplete="cover_image" />
            <x-input-error class="mt-2" :messages="$errors->get('cover_image')" />
        </div>
        
        <div class="flex items-center">
            <x-primary-button>{{ __('Save') }}</x-primary-button>
        </div>
    </form>

</section>
