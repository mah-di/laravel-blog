<section>
    <header>
        <h2 class="text-lg font-semibold">
            List of all blogging categories and their associated sub categories
        </h2>
        <b>
            <x-input-error class="mt-2" :messages="$errors->get('sub_category')" />
        </b>
    </header><br><br>

    @foreach($categories as $category)
    <div class="bg-gray-100 rounded px-2 py-4">
        <div style="display: flex; justify-content: space-between;">
            <div>
                <div style="display: flex; justify-content: space-between; margin: 4px;">
                    <a href="{{ route('category.blogs.show', $category->id) }}">
                        <b>{{ $category->name }}</b>
                    </a>
                    <p>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;</p>
                        <small><a href="{{ route('category.update', $category->id) }}"><button style="background-color:skyblue; color:whitesmoke; cursor: pointer;" class="rounded px-1 py-1">update</button></a></small>
                    <p>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;</p>
                    <form method="post" action="{{ route('category.delete', $category->id) }}" onsubmit="(e) => {e.preventDefault();confirm('Are you sure about that?')}">
                        @csrf
                        @method('delete')
                        <small><input style="background-color:crimson; color:whitesmoke; cursor: pointer;" class="rounded px-1 py-1" type="submit" value="delete"></small>
                    </form>
                </div>
            </div>

            <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>

            <div >
                @foreach($category->sub_categories as $sub_category)
                <div style="display: inline-block;">
                    <div style="display: flex; margin: 4px;" class="bg-white px-1 py-1 rounded">
                        <small>
                            <a href="{{ route('subCategory.blogs.show', $sub_category->id) }}" style="color: yellowgreen">
                                {{ $sub_category->name }}
                            </a>
                            &nbsp;&nbsp;
                        </small>
                        
                        <form style="margin-bottom: -5px;" action="{{ route('subCategory.delete', $sub_category->id) }}" method="post">
                            @csrf
                            @method('delete')
        
                            <button  type="submit" class="inline-flex items-center border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-gray-100 hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                <svg width="15px" height="15px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M16 8L8 16M12 12L16 16M8 8L10 10" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
    
            </div>
        </div><br>

        <form action="{{ route('subCategory.create') }}" method="post">
            @csrf
            <input type="hidden" name="category_id" value="{{ $category->id }}">
            <div style="display: flex; justify-content: space-around">
                <x-text-input placeholder="Add a Sub Category for {{ $category->name }}" name="sub_category" type="text" class="mt-1 block w-full" required autofocus autocomplete="sub_category" />
                <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
                <x-primary-button>&nbsp;&nbsp;{{ __('ADD') }}&nbsp;&nbsp;</x-primary-button>
            </div>
        </form>
    </div>
    <br><br>
    @endforeach

    <div>
        <a href="{{ route('category.create') }}">
            <div style="text-align: center;" class="bg-gray-100 rounded px-2 py-4">Add New Category</div>
        </a>
    </div>

</section>