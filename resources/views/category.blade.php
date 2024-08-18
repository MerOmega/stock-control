<x-layout title="Categoria">

    <ul>
        @foreach($categories as $category)
            <li>
                <a>
                    {{ $category->name }}
                </a>
            </li>
        @endforeach
    </ul>

    <!-- Add pagination links -->
    <div class="mt-4">
        <p>
            Showing {{ $categories->firstItem() }} to {{ $categories->lastItem() }} of {{ $categories->total() }} items
            (Page {{ $categories->currentPage() }} of {{ $categories->lastPage() }})
        </p>

        <!-- Pagination Links -->
        {{ $categories->links() }}
    </div>

</x-layout>
