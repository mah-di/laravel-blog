<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Update Blogging Category') }}
        </h2>
    </header>

    <form method="post" action="{{ route('category.update', $category->id) }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')
        
        <div>
            <x-input-label for="category" :value="__('Category Name')" />
            <x-text-input id="category" name="category" type="text" class="mt-1 block w-full" :value="old('category', $category->name)" required autofocus autocomplete="category" />
            <x-input-error class="mt-2" :messages="$errors->get('category')" />
        </div>
        
        <div class="flex items-center">
            <x-primary-button>{{ __('Save') }}</x-primary-button>
        </div>
    </form>

</section>