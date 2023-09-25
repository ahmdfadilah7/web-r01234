<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penyewaan Barang {{ date('d M Y', strtotime($dari)) }}</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <center>
        <h5>
            Laporan Penyewaan Barang {{ date('d M Y', strtotime($dari)) }}
        </h5>
    </center>
    <p>Status : <b>{{ $status }}</b></p>
    <table class="table table-bordered" style="width: 100%;">
        <thead>
            <tr>
                <th>No</th>
                <th>Dari</th>
                <th>Sampai</th>
                <th>Nama Penyewa</th>
                <th>No Telepon</th>
                <th>Nama Barang</th>
                <th>Jumlah</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($penyewaan as $no => $value)
                @php
                    $total[] = $value->total;
                @endphp
                <tr>
                    <td>{{ ++$no }}</td>
                    <td>{{ date('Y-m-d', strtotime($value->dari)) }}</td>
                    <td>{{ date('Y-m-d', strtotime($value->sampai)) }}</td>
                    <td>{{ $value->nama_penyewa }}</td>
                    <td>{{ $value->no_telp }}</td>
                    <td>{{ $value->nama_barang }}</td>
                    <td>{{ $value->jumlah }}</td>
                    <td>{{ \AllHelper::rupiah($value->total) }}</td>
                </tr>
            @endforeach
            <tr>
                <th colspan="7" style="text-align:center">Total</th>
                <th>{{ \AllHelper::rupiah(array_sum($total)) }}</th>
            </tr>
        </tbody>
    </table>
</body>
</html>