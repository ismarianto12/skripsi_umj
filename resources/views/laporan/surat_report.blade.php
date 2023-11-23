{{-- @dd($columndua); --}}

<style>
    table,
    th,
    td {
        border: 0.1px solid black;
    }

    th,
    td {
        padding: 15px;
        text-align: left;
    }

</style>



<table>
    <thead>

        @foreach ($column as $key)
            <tr>

                <th>No</th>
                <th>{{ Str::ucfirst(str_replace(['Tmsuratmaster.', 'tmp_surat.', '_', '*'], ' ', $key)) }}</th>
            </tr>
        @endforeach

    </thead>
    <tbody>
        @php
            $n = 0;
        @endphp

        @foreach ($data as $datas => $val)
            <tr>
                @foreach ($column as $key)
                    <td>{{ $n }}</td>

                    @php
                        $kl = str_replace(['tmp_surat.', 'tmsurat_master.'], '', $key);
                    @endphp
                    <td>{{ isset($val->$kl) ? $val->$kl : '' }}</td>
                @endforeach
            </tr>
        @endforeach


    </tbody>
</table>
