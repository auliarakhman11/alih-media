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
                <th class="bg-white">Keterangan</th>
                <th class="bg-white">Petugas</th>
            </tr>
        </thead>
        <tbody>
            @php
                $i = 1;
            @endphp
            @foreach ($dt_berkas as $d)
                <tr>
                    <td>{{ $i++ }}</td>
                    <td>{{ $d->berkas->kecamatan->nm_kecamatan }}</td>
                    <td>{{ $d->berkas->kelurahan->nm_kelurahan }}</td>
                    <td>{{ $d->berkas->jenis_hak->kode_hak }}-{{ $d->berkas->no_hak }}</td>
                    <td>{{ $d->berkas->jenis_peta ? $d->berkas->jenis_peta->nm_jenis_peta : '' }}-{{ $d->berkas->no_peta }}-{{ $d->berkas->tahun_peta }}</td>
                    <td>{{ $d->berkas->nib }}</td>
                    <td>{{ date("d/m/Y", strtotime($d->berkas->created_at)) }}</td>
                    <td>{{ $d->ket }}</td>
                    <td>{{ $d->petugas ? $d->petugas->name : '' }}</td>
                </tr>
            @endforeach
        </tbody>      
    </table>
</div>