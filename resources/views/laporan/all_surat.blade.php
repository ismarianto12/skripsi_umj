<table id="datatable" class="display table table-striped table-hover">
    <thead>
        <tr>
            <th>#</th>
            <th>id</th>
            <th>remark</th>
            <th>site_id</th>
            <th>site_name</th>
            <th>nomor_pks</th>
            <th>alamat_site</th>
            <th>pic_pemilik_lahan</th>
            <th>nilai_sewa_tahun</th>
            <th>periode_sewa_awal</th>
            <th>periode_sewa_akhir</th>
            <th>nama_negosiator</th>
            <th>email_negosiator</th>
            <th>nomor_hp_negosiator</th>
            <th>revenue_3_bulan</th>
            <th>revenue_2_bulan</th>
            <th>revenue_1_bulan</th>
            <th>harga_patokan</th>
            <th>download</th>
            <th>jenis</th>
            <th>user_id</th>
            <th>created_at</th>
            <th>updated_at</th>
            <th>tgl_download</th>
        </tr>
    </thead>
    <tbody>

        @php
            $j = 1;
        @endphp
        @foreach ($data as $datas)
            <tr>
                <td>
                    {{ $j }}
                </td>
                <td>{{ $datas->remark }}</td>
                <td>{{ $datas->site_id }}</td>
                <td>{{ $datas->site_name }}</td>
                <td>{{ $datas->nomor_pks }}</td>
                <td>{{ $datas->alamat_site }}</td>
                <td>{{ $datas->pic_pemilik_lahan }}</td>
                <td>{{ $datas->nilai_sewa_tahun }}</td>
                <td>{{ $datas->periode_sewa_awal }}</td>
                <td>{{ $datas->periode_sewa_akhir }}</td>
                <td>{{ $datas->nama_negosiator }}</td>
                <td>{{ $datas->email_negosiator }}</td>
                <td>{{ $datas->nomor_hp_negosiator }}</td>
                <td>{{ $datas->revenue_3_bulan }}</td>
                <td>{{ $datas->revenue_2_bulan }}</td>
                <td>{{ $datas->revenue_1_bulan }}</td>
                <td>{{ $datas->harga_patokan }}</td>
                <td>{{ $datas->download }}</td>
                <td>{{ $datas->jenis }}</td>
                <td>{{ $datas->user_id }}</td>
                <td>{{ $datas->created_at }}</td>
                <td>{{ $datas->updated_at }}</td>
                <td>{{ $datas->tgl_download }}</td>
            </tr>
            @php
                $j++;
            @endphp
        @endforeach
    </tbody>
</table>
