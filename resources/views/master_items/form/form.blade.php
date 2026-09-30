<form method="POST" enctype="multipart/form-data">
    @csrf

    @if($method == 'edit')
        <div class="form-group">
            <label>Kode Barang</label>
            <input
                type="text"
                class="form-control"
                name="kode_barang"
                required
                readonly
                value="{{ $item->kode ?? '' }}"
            >
        </div>
    @endif

    <div class="form-group">
        <label>Foto</label>
        <input
            type="file"
            class="form-control"
            name="foto"
            accept="image/*"
        >
    </div>

    <div class="form-group">
        <label>Nama</label>
        <input
            type="text"
            class="form-control"
            name="nama"
            required
            value="{{ $item->nama ?? '' }}"
        >
    </div>

    <div class="form-group">
        <label>Harga Beli</label>
        <input
            type="number"
            class="form-control"
            name="harga_beli"
            required
            value="{{ $item->harga_beli ?? '' }}"
        >
    </div>

    <div class="form-group">
        <label>Laba (dalam persen)</label>
        <input
            type="number"
            class="form-control"
            name="laba"
            required
            value="{{ $item->laba ?? '' }}"
        >
    </div>

    <div class="form-group">
        <label>Supplier</label>

        @php
            $selected = $item->supplier ?? '';
        @endphp

        <select class="form-control" required name="supplier">
            <option value="">--Pilih--</option>
            <option value="Tokopaedi" @selected($selected == 'Tokopaedi')>Tokopaedi</option>
            <option value="Bukulapuk" @selected($selected == 'Bukulapuk')>Bukulapuk</option>
            <option value="TokoBagas" @selected($selected == 'TokoBagas')>TokoBagas</option>
            <option value="E Commurz" @selected($selected == 'E Commurz')>E Commurz</option>
            <option value="Blublu" @selected($selected == 'Blublu')>Blublu</option>
        </select>
    </div>

    <div class="form-group">
        <label>Jenis</label>

        @php
            $selected = $item->jenis ?? '';
        @endphp

        <select class="form-control" required name="jenis">
            <option value="">--Pilih--</option>
            <option value="Obat" @selected($selected == 'Obat')>Obat</option>
            <option value="Alkes" @selected($selected == 'Alkes')>Alkes</option>
            <option value="Matkes" @selected($selected == 'Matkes')>Matkes</option>
            <option value="Umum" @selected($selected == 'Umum')>Umum</option>
            <option value="ATK" @selected($selected == 'ATK')>ATK</option>
        </select>
    </div>

    <div class="form-group">
        <label>Category</label>

        @foreach ($categories as $category)
            <div class="form-check">
                <input
                    type="checkbox"
                    class="form-check-input"
                    name="categories[]"
                    value="{{ $category->id }}"
                    id="category_{{ $category->id }}"
                    @if($method == 'edit' && $item->categories->contains('id', $category->id))
                        checked
                    @endif
                >

                <label
                    class="form-check-label"
                    for="category_{{ $category->id }}"
                >
                    {{ $category->nama }}
                </label>
            </div>
        @endforeach
    </div>

    <button type="submit" class="btn btn-primary mt-3">
        Submit
    </button>
</form>