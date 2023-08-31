<section>

    <h2 style="text-align: center;" class="font-semibold text-xl">Top Blogger Chart</h2><br>
    <div style="display: flex; justify-content: space-evenly;">
        <div>
            <table class=" table-auto">
                <caption>
                    <b>All Time Chart</b>
                </caption>
                <br>
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border border-slate-300 p-4">#</th>
                        <th class="border border-slate-300 p-4">Blogger</th>
                        <th class="border border-slate-300 p-4">Email</th>
                        <th class="border border-slate-300 p-4">Blogs</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($topBloggers as $place => $blogger)
                    <tr>
                        <td class="border border-slate-300 p-4">{{ $place+1 }}</td>
                        <td class="border border-slate-300 p-4"><a href="{{ route('profile.show', $blogger->user_id) }}">{{ $blogger->user->name }}</a></td>
                        <td class="border border-slate-300 p-4">{{ $blogger->user->email }}</td>
                        <td class="border border-slate-300 p-4">{{ $blogger->user->blogs->count() }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <br>
    <br>

    <div style="display: flex; justify-content: space-evenly;">
        <div>
            <table class=" table-auto">
                <caption>
                    <b>Last 7 Days Chart</b>
                </caption>
                <br>
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border border-slate-300 p-4">#</th>
                        <th class="border border-slate-300 p-4">Blogger</th>
                        <th class="border border-slate-300 p-4">Email</th>
                        <th class="border border-slate-300 p-4">Blogs</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($topBloggers7Days as $place => $blogger)
                    <tr>
                        <td class="border border-slate-300 p-4">{{ $place+1 }}</td>
                        <td class="border border-slate-300 p-4"><a href="{{ route('profile.show', $blogger->user_id) }}">{{ $blogger->user->name }}</a></td>
                        <td class="border border-slate-300 p-4">{{ $blogger->user->email }}</td>
                        <td class="border border-slate-300 p-4">{{ $blogger->user->blogs_seven_days_count }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div>
            <table class=" table-auto">
                <caption>
                    <b>Last 30 Days Chart</b>
                </caption>
                <br>
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border border-slate-300 p-4">#</th>
                        <th class="border border-slate-300 p-4">Blogger</th>
                        <th class="border border-slate-300 p-4">Email</th>
                        <th class="border border-slate-300 p-4">Blogs</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($topBloggers30Days as $place => $blogger)
                    <tr>
                        <td class="border border-slate-300 p-4">{{ $place+1 }}</td>
                        <td class="border border-slate-300 p-4"><a href="{{ route('profile.show', $blogger->user_id) }}">{{ $blogger->user->name }}</a></td>
                        <td class="border border-slate-300 p-4">{{ $blogger->user->email }}</td>
                        <td class="border border-slate-300 p-4">{{ $blogger->user->blogs_thirty_days_count }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</section>