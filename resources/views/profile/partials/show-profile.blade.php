<section>
    <div style="display: flex; justify-content: space-evenly; align-items: end;">
        <div>
            <img height="256px" width="256px" src="{{ $user->profile_image_url }}" style="border: 4px solid limegreen;border-radius: 50%; display:block;" alt="profile image">
            <div style="display:flex; justify-content:center; margin-top:20px">
                <h2 class="text-lg font-medium text-gray-900">
                    {{ $user->name }}
                </h2>
            </div>
        </div>

        <div>
            <p>Date Joined - <i>{{ $user->date_joined }}</i></p>
            <p>Email - <i>{{ $user->email }}</i></p>
        </div>
    </div>

</section>
