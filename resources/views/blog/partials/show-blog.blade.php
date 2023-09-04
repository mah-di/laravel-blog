<section>
    <div>
        <div>
            <img style="max-height: 300px; width: 100%" src="{{ $blog->cover_image_url }}" alt="cover image">
            <div style="margin-top:20px">
                <h2 class="text-lg font-medium text-gray-900">
                    {{ $blog->title_upper }}
                </h2><br>
                <small><i>Author: <b><a href="{{ route('profile.show', $blogger->id) }}">{{ $blogger->name }}</a></b></i></small><br>
                <small><i>Posted at: {{ $blog->date_created }}</i></small><br>
                @if($blog->category)
                <small>
                    <i>Posted in:</i>&nbsp;&nbsp;
                    <span class="px-1 py-1 bg-gray-100 rounded">{{ $blog->category->name }}</span>
                    @if($blog->sub_category)
                     → 
                    <span class="px-1 py-1 bg-gray-100 rounded">{{ $blog->sub_category->name }}</span>
                    @endif
                </small><br>
                @endif
            </div>
        </div><br>

        <div>
            <p>{!! nl2br($blog->body) !!}</p>
        </div>

        
    </div>
    
</section>
