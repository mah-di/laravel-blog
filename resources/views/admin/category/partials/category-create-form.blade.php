<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Create A New Blogging Category') }}
        </h2>
    </header>

    <form method="post" action="{{ route('category.store') }}" class="mt-6 space-y-6">
        @csrf
        
        <div>
            <x-input-label for="category" :value="__('Category Name')" />
            <x-text-input id="category" name="category" type="text" class="mt-1 block w-full" :value="old('category')" required autofocus autocomplete="category" />
            <x-input-error class="mt-2" :messages="$errors->get('category')" />
        </div>
        
        <div>
            <x-input-label for="sub_categories" :value="__('Sub Categories | Differentiate Using Commas (,)')" />
            <x-text-input id="sub_categories" name="sub_categories" type="text" class="mt-1 block w-full" :value="old('sub_categories')" autofocus autocomplete="sub_categories" />
            <x-input-error class="mt-2" :messages="$errors->get('sub_categories')" />
        </div>
        
        <div class="flex items-center">
            <x-primary-button>{{ __('Save') }}</x-primary-button>
        </div>
    </form>

</section>