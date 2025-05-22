<!DOCTYPE html>
<html>
<head>
    <title>Data Barang</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
</head>
<body>

    <h2>Data Barang</h2>
    <table id="barang-table" class="display">
        <thead>
            <tr>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Harga Beli</th>
                <th>Harga Jual</th>
                <th>Harga Member</th>
                <th>Grosir 1</th>
                <th>Grosir 2</th>
                <th>Grosir 3</th>
                <th>User</th>
            </tr>
        </thead>
    </table>

    <script>
    $(document).ready(function () {
        $('#barang-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('barang.index') }}",
            columns: [
                { data: 'kode_barang', name: 'kode_barang' },
                { data: 'nama_barang', name: 'nama_barang' },
                { data: 'harga_beli', name: 'harga_beli' },
                { data: 'harga_jual', name: 'harga_jual' },
                { data: 'harga_member', name: 'harga_member' },
                { data: 'grosir1', name: 'grosir1' },
                { data: 'grosir2', name: 'grosir2' },
                { data: 'grosir3', name: 'grosir3' },
                { data: 'user', name: 'user' },
            ]
        });
    });
    </script>

</body>
</html>
