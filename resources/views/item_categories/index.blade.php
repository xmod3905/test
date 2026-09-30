<h1>Item Categories</h1>
<a
    href="{{ route('item-categories.pdf', $category->id) }}"
    class="btn btn-danger btn-sm"
    target="_blank"
>
    PDF
</a>
<form method="POST" action="{{ url('item-categories') }}">
    @csrf

    <input type="text" name="nama" placeholder="Nama Category">

    <button type="submit">
        Simpan
    </button>
</form>

<hr>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Aksi</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($categories as $category)
            <tr>
                <td>{{ $category->id }}</td>
                <td>{{ $category->nama }}</td>
                <td>
                    <form method="POST"
                          action="{{ url('item-categories/' . $category->id) }}">
                        @csrf
                        @method('DELETE')

                        <button type="submit">
                            Hapus
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>