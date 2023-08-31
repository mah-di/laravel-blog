<section>

    <div style="display: flex; justify-content: space-evenly;">
        <div>
            <h2 class="font-semibold">Users Overview</h2><br><hr><br>
            <p>Total Users: <b>{{ $userCount }}</b></p>
            <p>New Users In Last 7 Days : <b>{{ $newUsers7Days }}</b></p>
            <p>New Users In Last 30 Days : <b>{{ $newUsers30Days }}</b></p>
            <br>
            <p><b>New Users</b></p>
            @foreach($newUsers as $user)
            <small><b><a href="{{ route('profile.show', $user->id) }}">{{ $user->name }}</a></b> | {{ $user->email }} | Date Joined : {{ $user->date_joined }}</small><br>
            @endforeach
        </div>
        
        <div>
            <h2 class="font-semibold">Blogs Overview</h2><br><hr><br>
            <p>Total Blogs : <b>{{ $blogCount }}</b></p>
            <p>Blogs Posted In Last 7 Days : <b>{{ $newBlogs7Days }}</b></p>
            <p>Blogs Posted In Last 30 Days : <b>{{ $newBlogs30Days }}</b></p>
            <br>
            <p><b>Latest Blogs</b></p>
            @foreach($newBlogs as $blog)
                <small><b><a href="{{ route('blog.show', $blog->id) }}">{{ $blog->title }}</a></b> | Date Posted : {{ $blog->date_created }}</small><br>
            @endforeach
        </div>
    </div>

</section>