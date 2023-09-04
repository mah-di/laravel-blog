<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Write A Blog') }}
        </h2>
    </header>

    <form method="post" action="{{ route('blog.store.step'.$step) }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf

        @if($step == 1)
        <select name="category" class="rounded">
            <option value="">Select a Category</option>
            @foreach ($categories as $category)
            <option value="{{ $category->id }}|{{ $category->name }}">{{ $category->name }}</option>
            @endforeach
        </select>
        
        @elseif($step == 2)
        <div><small class="bg-gray-100 rounded px-1 py-1">{{ $category_name }}</small></div>
        <input type="hidden" name="category" value="{{ $category }}">
        <select name="sub_category" class="rounded">
            <option value="44|dfg">Select a Sub Category (Optional)</option>
            @foreach ($sub_categories as $sub_category)
            <option value="{{ $sub_category->id }}|{{ $sub_category->name }}">{{ $sub_category->name }}</option>
            @endforeach
        </select>
        
        @elseif($step == 3)
        <div>
            <small class="bg-gray-100 rounded px-1 py-1">{{ $category_name }}</small>
            @if($sub_category)
             → 
            <small class="bg-gray-100 rounded px-1 py-1">{{ $sub_category_name }}</small>
            @endif
        </div>

        <input type="hidden" name="category" value="{{ $category }}">
        <input type="hidden" name="sub_category" value="{{ $sub_category }}">
        <div>
            <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title')" required autofocus autocomplete="title" />
            <x-input-error class="mt-2" :messages="$errors->get('title')" />
        </div>
        <div>
            <textarea rows="20" id="body" name="body" class="mt-1 block w-full rounded shadow border-gray-100" required autofocus autocomplete="body" >{{old('body')}}</textarea>
            <x-input-error class="mt-2" :messages="$errors->get('body')" />
        </div>
        <div>
            <x-text-input id="cover_image" name="cover_image" type="file" class="mt-1 block w-full border-gray-100" autofocus autocomplete="cover_image" />
            <x-input-error class="mt-2" :messages="$errors->get('cover_image')" />
        </div>
        @endif
        
        <div class="flex items-center">
            <x-primary-button>{{ __('Save') }}</x-primary-button>
        </div>
    </form>

</section>
