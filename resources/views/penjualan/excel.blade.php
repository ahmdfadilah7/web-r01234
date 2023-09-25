<table style="width: 100%; border: 2px solid #000;">
    <thead>
        <tr>
            @if($kategori == 'barang')
                <th colspan="7" style="font-size: 13px; font-weight: bold; text-align:center;">Laporan Penjualan Barang {{ date('d M Y', strtotime($dari)).' - '.date('d M Y', strtotime($sampai)) }}</th>
            @else
                <th colspan="7" style="font-size: 13px; font-weight: bold; text-align:center;">Laporan Penjualan Aksesoris {{ date('d M Y', strtotime($dari)).' - '.date('d M Y', strtotime($sampai)) }}</th>                
            @endif
        </tr>
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