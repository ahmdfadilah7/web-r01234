<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @if($kategori == 'barang')
        <title>Laporan Penjualan Barang {{ date('d M Y', strtotime($dari)).' - '.date('d M Y', strtotime($sampai)) }}</title>
    @else
        <title>Laporan Penjualan Aksesoris {{ date('d M Y', strtotime($dari)).' - '.date('d M Y', strtotime($sampai)) }}</title>        
    @endif
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <center>
        <h5>
            @if($kategori == 'barang')
                Laporan Penjualan Barang {{ date('d M Y', strtotime($dari)).' - '.date('d M Y', strtotime($sampai)) }}
            @else
                Laporan Penjualan Aksesoris {{ date('d M Y', strtotime($dari)).' - '.date('d M Y', strtotime($sampai)) }}        
            @endif
        </h5>
    </center>
    <table class="table table-bordered" style="width: 100%;">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Nama Pembeli</th>
                @if($kategori=='barang')
                    <th>Nama Barang</th>
                @else
                    <th>Nama Aksesoris</th>            
                @endif
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($penjualan as $no => $value)
                @php
                    $total[] = $value->total;
                @endphp
                <tr>
                    <td>{{ ++$no }}</td>
                    <td>{{ date('Y-m-d', strtotime($value->created_at)) }}</td>
                    <td>{{ $value->nama_pembeli }}</td>
                    @if($kategori=='barang')
                        <td>{{ $value->nama_barang }}</td>
                    @else
                        <td>{{ $value->nama_aksesoris }}</td>
                    @endif
                    <td>{{ \AllHelper::rupiah($value->harga) }}</td>
                    <td>{{ $value->jumlah }}</td>
                    <td>{{ \AllHelper::rupiah($value->total) }}</td>
                </tr>
            @endforeach
            <tr>
                <th colspan="6" style="text-align:center">Total</th>
                <th>{{ \AllHelper::rupiah(array_sum($total)) }}</th>
            </tr>
        </tbody>
    </table>
</body>
</html>