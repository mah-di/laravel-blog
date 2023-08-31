<section>
    <header>
        <h2>
            List of all blogging categories and their associated sub categories
        </h2>
    </header><br><br>

    @foreach($categories as $category)
    <div style="display: flex; justify-content: space-between;">
        <div>
            <div style="display: flex; justify-content: space-between;">
                <a href="{{ route('category.update', $category->id) }}"><b>{{ $category->name }}</b></a>
                <p>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;</p>
                <form method="post" action="{{ route('category.delete', $category->id) }}" onsubmit="(e) => {e.preventDefault();confirm('Are you sure about that?')}">
                    @csrf
                    @method('delete')
                    <small><input style="background-color:crimson; color:whitesmoke; cursor: pointer;" class="rounded px-1 py-1" type="submit" value="delete"></small>
                </form>
            </div>
        </div>
        <div>
            @foreach($category->sub_categories as $sub_category)
            <small class="bg-gray-100 px-1 py-1 rounded">{{ $sub_category->name }}</small>
            @endforeach
        </div>
    </div><br>
    @endforeach

</section>