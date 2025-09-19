<style>
    .scrollme {
    overflow-y: auto;
    height: 600px;
    }

    th {
    position: sticky;
    top: 0px;  /* 0px if you don't have a navbar, but something is required */
    background: white;
    }
</style>
<div class="table-responsive scrollme">
    <table class="table table-sm">
        <thead>
            <tr>
                <th class="bg-white">#</th>
                <th class="bg-white">Kecamatan</th>
                <th class="bg-white">Kelurahan</th>
                <th class="bg-white">Hak</th>
                <th class="bg-white">SU/GS</th>
                <th class="bg-white">NIB</th>
                <th class="bg-white">Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @php
                $i = 1;
            @endphp
            @foreach ($dt_berkas as $d)
                <tr>
                    <td>{{ $i++ }}</td>
                    <td>{{ $d->kecamatan->nm_kecamatan }}</td>
                    <td>{{ $d->kelurahan->nm_kelurahan }}</td>
                    <td>{{ $d->jenis_hak->kode_hak }}-{{ $d->no_hak }}</td>
                    <td>{{ $d->jenis_peta ? $d->jenis_peta->nm_jenis_peta : '' }}-{{ $d->no_peta }}-{{ $d->tahun_peta }}</td>
                    <td>{{ $d->nib }}</td>
                    <td>{{ date("d/m/Y", strtotime($d->created_at)) }}</td>
                </tr>
            @endforeach
        </tbody>      
    </table>
</div>