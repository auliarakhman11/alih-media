@if ($berkas)
<div class="row">
    <div class="col-12 col-md-6 mt-2">
        <table width="100%">
            <tr>
                <td><b>Kecamatan</b></td>
                <td><b>:</b></td>
                <td><b>{{ $berkas->kecamatan->nm_kecamatan }}</b></td>
            </tr>
            <tr>
                <td><b>Kelurahan</b></td>
                <td><b>:</b></td>
                <td><b>{{ $berkas->kelurahan->nm_kelurahan }}</b></td>
            </tr>
            <tr>
                <td><b>Nomor Hak</b></td>
                <td><b>:</b></td>
                <td><b>{{ $berkas->jenis_hak->kode_hak }} - {{ $berkas->no_hak }}</b></td>
            </tr>
            <tr>
                <td><b>Peta</b></td>
                <td><b>:</b></td>
                <td><b> 
                    @if ($berkas->jenis_peta)
                    {{ $berkas->jenis_peta->nm_jenis_peta }} - {{ $berkas->no_peta }}/{{ $berkas->tahun_peta }}
                    @else
                        -
                    @endif
                    
                </b></td>
            </tr>
            <tr>
                <td><b>NIB</b></td>
                <td><b>:</b></td>
                <td><b>{{ $berkas->nib ? $berkas->nib : '-' }}</b></td>
            </tr>
            <tr>
                <td colspan="3">
                    @if ($berkas->selesai != 2 && Auth::id() == 1 || Auth::id() == 29)
                    
                    <button class="btn btn-primary mt-2" id="btn_tutup_berkas" berkas_id="{{ $berkas->id }}" type="button">Tutup Berkas</button>
                    @else
                    <p class="text-danger"><strong>Berkas Sudah Ditutup!</strong></p>
                    @endif
                    
                </td>
            </tr>
        </table>
    </div>

    <div class="col-12 col-md-6 mt-2">
        @php
            $dtProses
        @endphp
        @foreach ($berkas->history as $a)
        @php
            $dtProses [] = $a->proses_id
        @endphp
        @endforeach
        <table class="table table-sm" width="100%">
            <thead>
                <tr class="text-center">
                    <th><b>Proses</b></th>
                    <th><b>Status</b></th>
                    <th><b>Petugas</b></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dt_proses as $p)
                <tr>
                    <td>{{ $p['nm_proses'] }}</td>
                    <td>
                        @if ($p['ada'] && $p['selesai'])
                        <button type="button" class="btn-success btn-xs btn-rounded"><i class='bx bxs-check-circle'></i> Selesai</button>
                        @elseif ($p['ada'] && !$p['selesai'])
                        <button type="button" class="btn-warning btn-xs btn-rounded"><i class='bx bx-loader'></i> Proses</button>
                        @else
                        <button type="button" class="btn-primary btn-xs btn-rounded"><i class='bx bxs-x-circle'></i> Belum</button>
                        @endif
                    </td>
                    <td>{{ $p['petugas'] }}</td>
                </tr>
                @endforeach
            </tbody>
            
        </table>
    </div>

</div>
@else
    <h3>Berkas tidak ditemukan</h3>
@endif