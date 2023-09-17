<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Edit Blog') }}
        </h2>
    </header><br>

    @if(isset($categories))
    <form method="post" action="{{ route('blog.category.update', $blog->id) }}">
        @csrf
        @method('patch')

        <select name="category" class="rounded">
            <option value="">Select a Category</option>
            @foreach ($categories as $category)
            <option
                value="{{ $category->id }}|{{ $category->name }}"
                @if($category->id == $blog->category->id)
                selected
                @endif
            >{{ $category->name }}</option>
            @endforeach
        </select><br><br>

        <div class="flex items-center">
            <x-primary-button>{{ __('Update Category') }}</x-primary-button>
        </div>
    </form>

    @elseif(isset($subCategories))
    <div><small class="bg-gray-100 rounded px-1 py-1">{{ $categoryName }}</small></div><br>
    <form method="post" action="">
        @csrf
        @method('patch')

        <input type="hidden" name="category" value="{{ $category }}">
        <select name="subCategory" class="rounded">
            <option value="">Select a Sub Category (Optional)</option>
            @foreach ($subCategories as $subCategory)
            <option
                value="{{ $subCategory->id }}|{{ $subCategory->name }}"
                @if($blog->sub_category && $subCategory->id == $blog->sub_category->id)
                selected
                @endif
            >{{ $subCategory->name }}</option>
            @endforeach
        </select><br><br>

        <div class="flex items-center">
            <x-primary-button>{{ __('Update Sub Category') }}</x-primary-button>
        </div>
    </form>

    @else
    <div style="display:flex">
        @if($categoryName)
            <span class="bg-gray-100 rounded px-1 py-1">
                {{ $categoryName }}
            </span>
            @if($subCategoryName)
            → 
            <span class="bg-gray-100 rounded px-1 py-1">
                {{ $subCategoryName }}
            </span>
            @endif

        @else
            <span class="bg-gray-100 rounded px-1 py-1">
                {{ $blog->category->name }}
            </span>
            @if($blog->sub_category)
            → 
            <span class="bg-gray-100 rounded px-1 py-1">
                {{ $blog->sub_category->name }}
            </span>
            @endif
        @endif
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <a href="{{ route('blog.category.edit', $blog->id) }}"><x-primary-button>{{ __('Change Category/Sub Category') }}</x-primary-button></a>
    </div><br>

    <div>
        <img style="max-height: 300px; width: 100%" src="{{ $blog->cover_image_url }}" alt="cover image"><br>
        
        @if (env('DEFAULT_COVER_IMAGE') !== $blog->cover_image)
        <form method="post" action="{{ route('cover.image.delete', $blog->id) }}">
            @csrf
            @method('delete')
            <x-primary-button>{{ __('Delete Cover Image') }}</x-primary-button>
        </form><br>Or,<br>
        @endif
    </div>
    
    <form method="post" action="{{ route('blog.update', $blog->id) }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <input
            type="hidden"
            name="category"
            value="{{ ($category) ? $category : $blog->category->id }}"
        >
        <input
            type="hidden"
            name="subCategory"
            value="{{ ($category) ? $subCategory : (($blog->sub_category) ? $blog->sub_category->id : null) }}"
        >
        <div>
            <x-input-label for="cover_image" :value="__('Upload Cover Image')" />
            <x-text-input id="cover_image" name="cover_image" type="file" class="mt-1 block w-full border-gray-100" autofocus autocomplete="cover_image" />
            <x-input-error class="mt-2" :messages="$errors->get('cover_image')" />
        </div>
        
        <div>
            <x-input-label for="title" :value="__('Edit Title')" />
            <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title', $blog->title)" required autofocus autocomplete="title" />
            <x-input-error class="mt-2" :messages="$errors->get('title')" />
        </div>
        <div>
            <x-input-label for="body" :value="__('Edit Body')" />
            <textarea rows="20" id="body" name="body" class="mt-1 block w-full rounded shadow border-gray-100" required autofocus autocomplete="body" >{{old('body', $blog->body)}}</textarea>
            <x-input-error class="mt-2" :messages="$errors->get('body')" />
        </div>

        <div class="flex items-center">
            <x-primary-button>{{ __('Update') }}</x-primary-button>
        </div>
    </form>
    @endif

</section>
