<table style="width: 100%; border: 2px solid #000;">
    <thead>
        <tr>
            <th colspan="9" style="font-size: 13px; font-weight: bold; text-align:center;">Laporan Penyewaan Barang {{ date('d M Y', strtotime($dari)) }}</th>            
        </tr>
        <tr>
            <th>No</th>
            <th>Dari</th>
            <th>Sampai</th>
            <th>Nama Penyewa</th>
            <th>No Telepon</th>
            <th>Nama Barang</th>
            <th>Jumlah</th>
            <th>Status</th>
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
                <td>
                    @if($value->status == '0')
                        Belum Diambil
                    @elseif ($value->status == '1')
                        Sudah Diambil
                    @elseif ($value->status == '2')
                        Selesai
                    @elseif ($value->status == '3')
                        Dibatalkan
                    @endif    
                </td>
                <td>{{ \AllHelper::rupiah($value->total) }}</td>
            </tr>
        @endforeach
        <tr>
            <th colspan="8" style="text-align:center">Total</th>
            <th>{{ \AllHelper::rupiah(array_sum($total)) }}</th>
        </tr>
    </tbody>
</table>