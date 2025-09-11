<div class="row">
    <div class="col-12">
        <div class="form-group">
            <div class="form-floating">
                <input type="hidden" name="history_id" value="{{ $history_id }}">
                <textarea class="form-control" placeholder="Masukan keterangan disini" name="ket">{{ $dt_history->ket }}</textarea>
                <label for="floatingTextarea">Keterangan</label>
              </div>
            {{-- <label for="">Keterangan</label>
            <input type="hidden" name="history_id" value="{{ $history_id }}">
            <textarea name="ket" cols="30" rows="10">{{ $dt_history->ket }}</textarea> --}}
        </div>
    </div>

    <div class="col-12 mt-2">
        <h4>List Keterangan</h4>
        <table class="table table-sm mt-2">
            <thead>
                <tr>
                    <th>Proses</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dt_berkas as $d)
                    <tr>
                        <td>{{ $d->proses->nm_proses }}</td>
                        <td>{{ $d->ket }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>