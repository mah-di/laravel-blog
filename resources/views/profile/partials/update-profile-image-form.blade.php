<section>
    <header>
    <div style="display:flex; justify-content:center;">
        <img height="256px" width="256px" src="{{ $user->profile_image_url }}" style="border: 4px solid limegreen;border-radius: 50%; display:block;" alt="profile image">
    </div>
        
    <div style="display:flex; justify-content:center;">
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Image') }}
        </h2>
    </div>
    </header>


    <form method="post" action="{{ route('profile.image.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')
        
        <div>
            <x-input-label for="profile_image" :value="__('Update Profile Image')" />
            <x-text-input id="profile_image" name="profile_image" type="file" class="mt-1 block w-full" :value=" old('profile_image', '') " required autofocus autocomplete="profile_image" />
            <x-input-error class="mt-2" :messages="$errors->get('profile_image')" />
        </div>
        
        <div class="flex items-center">
            <x-primary-button>{{ __('Save') }}</x-primary-button>
            
            @if (session('status') === 'profile-image-updated')
            <p
            x-data="{ show: true }"
            x-show="show"
            x-transition
            x-init="setTimeout(() => show = false, 2000)"
            class="text-sm ml-4 text-gray-600"
            >{{ __('Profile Image Updated.') }}</p>
            
            @elseif (session('status') === 'profile-image-deleted')
            <p
            x-data="{ show: true }"
            x-show="show"
            x-transition
            x-init="setTimeout(() => show = false, 2000)"
            class="text-sm ml-4 text-gray-600"
            >{{ __('Profile Image Removed.') }}</p>
            @endif
        </div>
    </form>

    @if ($user->profile_image != env('DEFAULT_PROFILE_IMAGE'))
    <form method="post" action="{{ route('profile.image.delete') }}" class="mt-3 space-y-6">
        @csrf
        @method('delete')

        <div class="flex items-center">
            <x-primary-button>{{ __('Remove') }}</x-primary-button>
        </div>
    </form>
    @endif

</section>
