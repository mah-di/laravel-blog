<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Contact Number') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your contact number.") }}
        </p>
    </header>

    <form method="post" action="{{ route('contact.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')
        
        <div>
            <x-input-label for="contact_number" :value="__('Contact Number')" />
            <x-text-input id="contact_number" name="contact_number" type="text" class="mt-1 block w-full" :value="$user->contact_number" required autofocus autocomplete="contact_number" />
            <x-input-error class="mt-2" :messages="$errors->get('contact_number')" />
        </div>
        
        <div class="flex items-center">
            <x-primary-button>{{ __('Save') }}</x-primary-button>
            
            @if (session('status') === 'contact-updated')
            <p
            x-data="{ show: true }"
            x-show="show"
            x-transition
            x-init="setTimeout(() => show = false, 2000)"
            class="text-sm ml-4 text-gray-600"
            >{{ __('Contact Updated.') }}</p>
            
            @elseif (session('status') === 'contact-deleted')
            <p
            x-data="{ show: true }"
            x-show="show"
            x-transition
            x-init="setTimeout(() => show = false, 2000)"
            class="text-sm ml-4 text-gray-600"
            >{{ __('Contact Removed.') }}</p>
            @endif
        </div>
    </form>

    @if ($user->contact_number)
    <form method="post" action="{{ route('contact.delete') }}" class="mt-3 space-y-6">
        @csrf
        @method('delete')

        <div class="flex items-center">
            <x-primary-button>{{ __('Remove') }}</x-primary-button>
        </div>
    </form>
    @endif

</section>
