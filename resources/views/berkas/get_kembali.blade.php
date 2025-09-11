<div class="row">
    <input type="hidden" name="berkas_id" value="{{ $berkas_id }}">
    <input type="hidden" name="kecamatan_id" value="{{ $berkas->kecamatan_id }}">
    <input type="hidden" name="kelurahan_id" value="{{ $berkas->kelurahan_id }}">
    <input type="hidden" name="percepatan" value="{{ $berkas->percepatan }}">
    <div class="col-12 col-md-4">
        <div class="form-group">
            <label for="">Proses</label>
            <p><b>Alih Media Induk</b></p>
        </div>
    </div>

    <div class="col-6 col-md-4">
        <div class="form-group">
            <label for="">Kecamatan</label>
            <p><b>{{ $berkas->kecamatan->nm_kecamatan }}</b></p>
        </div>
    </div>

    <div class="col-6 col-md-4">
        <div class="form-group">
            <label for="">Kelurahan</label>
            <p><b>{{ $berkas->kelurahan->nm_kelurahan }}</b></p>
        </div>
    </div>

    <div class="col-6 col-md-4 mt-2">
        <div class="form-group">
            <label for="">Jenis Hak</label>
            <select name="jenis_hak_id" class="form-control" required>
                @foreach ($jenis_hak as $d)
                    <option value="{{ $d->id }}">{{ $d->nm_hak }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-6 col-md-4 mt-2">
        <div class="form-group">
            <label for="">Nomor Hak</label>
            <input type="number" name="no_hak" class="form-control" required>
        </div>
    </div>

    <div class="col-12 col-md-4 mt-2">
        <div class="form-group">
            <label for="">Jenis Perolehan</label>
            <input type="text" name="ket" class="form-control" required>
        </div>
    </div>

    <div class="col-12 col-md-4 mt-2">
        <div class="form-group">
            <label for="">Nomor SU/GS</label>
            <input type="number" name="no_peta" class="form-control" required>
        </div>
    </div>

    <div class="col-12 col-md-4 mt-2">
        <div class="form-group">
            <label for="">Tahun</label>
            <input type="number" name="tahun_peta" class="form-control" required>
        </div>
    </div>

    <div class="col-12 col-md-4 mt-2">
        <div class="form-group">
            <label for="">NIB</label>
            <input type="number" name="nib" class="form-control" required>
        </div>
    </div>

    <div class="col-12 col-md-4 mt-2">
        <div class="form-group">
            <label for="">Jenis Peta</label>
            <div class="row">

                <div class="col-4">
                  <div class="form-check">
                    <input name="jenis_peta_id" class="form-check-input" type="radio" value="1" id="su" checked="">
                    <label class="form-check-label" for="su">
                      SU
                    </label>
                  </div>
                </div>

                <div class="col-4">
                  <div class="form-check">
                    <input name="jenis_peta_id" class="form-check-input" type="radio" value="2" id="gs">
                    <label class="form-check-label" for="gs">
                      GS
                    </label>
                  </div>
                </div>

                <div class="col-4">
                  <div class="form-check">
                    <input name="jenis_peta_id" class="form-check-input" type="radio" value="3" id="sus">
                    <label class="form-check-label" for="sus">
                      SUS
                    </label>
                  </div>
                </div>

            </div>
        </div>
    </div>

    
</div>