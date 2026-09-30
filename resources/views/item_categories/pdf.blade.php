<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">

    <title>Daftar Item - {{ $category->nama }}</title>

    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        h2 {
            margin-bottom: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
        }

        th {
            text-align: left;
        }
    </style>
</head>

<body>

    <h2>Daftar Master Item</h2>

    <div>
        Category: <strong>{{ $category->nama }}</strong>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Nama</th>
                <th>Jenis</th>
                <th>Harga Beli</th>
                <th>Laba</th>
                <th>Supplier</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($category->masterItems as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->kode }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->jenis }}</td>
                    <td>{{ $item->harga_beli }}</td>
                    <td>{{ $item->laba }}%</td>
                    <td>{{ $item->supplier }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">
                        Tidak ada item pada category ini.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>