@extends('template.master')

@section('content')


<!-- Content -->



<div class="container-xxl flex-grow-1 container-p-y">
  <div class="row">

    <div class="col-12 mb-4 order-0">
      
      <div class="card">
          <div class="card-header">
              <h5 class="float-start">Cari Berkas</h5>
              
          </div>
          
          <div class="card-body">

            <form id="form_informasi_berkas">
              <div class="row">

                <div class="col-6">
                  <div class="row">
                    <div class="col-4"><label class="float-end" for="kecamatan_id">Kecamatan</label></div>
                    <div class="col-8">
                      <select class="form-control" name="kecamatan_id" id="kecamatan_id" onchange="getKelurahan(this);" required>
                        <option value="">Pilih Kecamatan</option>
                        @foreach ($kecamatan as $k)
                            <option value="{{ $k->id }}">{{ $k->nm_kecamatan }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>
  
                <div class="col-6">
                    <div class="row">
                      <div class="col-4"><label class="float-end" for="kelurahan_id">Kelurahan</label></div>
                      <div class="col-8">
                        <select class="form-control select2bs4" name="kelurahan_id" id="kelurahan_id" onchange="getKecamatan(this);" required>
                          <option value="">Pilih kelurahan</option>
                          @foreach ($kelurahan as $kl)
                              <option value="{{ $kl->id }}|{{ $kl->kecamatan_id }}">{{ $kl->nm_kelurahan }} ({{ $kl->kecamatan->nm_kecamatan }})</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                </div>
  
                <div class="col-6 mt-3">
                  <div class="row">
                    <div class="col-4"><label class="float-end" for="jenis_hak_id">Jenis Hak</label></div>
                    <div class="col-8">
                      <select class="form-control" name="jenis_hak_id" id="jenis_hak" required>
                        <option value="">Pilih jenis hak</option>
                        @foreach ($jenis_hak as $k)
                            <option value="{{ $k->id }}">{{ $k->nm_hak }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>
  
                <div class="col-6 mt-3">
                    <div class="row">
                      <div class="col-4"><label class="float-end" for="no_hak">Nomor Hak</label></div>
                      <div class="col-8">
                        <input type="number" name="no_hak"  class="form-control" id="no_hak" required>
                      </div>
                    </div>
                </div>

              <div class="col-6"></div>
  
                <div class="col-6">
                  
                  <div class="row">
                    {{-- <div class="col-5">
                      <div class="form-check form-switch mt-4 float-end">
                        <input class="form-check-input" name="percepatan" id="pecepatan" value="1" type="checkbox">
                        <label for="pecepatan">Urgent</label>
                      </div>
                    </div> --}}
    
                    <div class="col-12"><button type="submit" class="btn btn-sm btn-primary float-end mt-4" id="btn_info_berkas"><i class="bx bx-search-alt"></i> Cari</button></div>
                  </div>
                  
                </div>
  
              </div>
            </form>

          </div>
          
        </div>

        <div class="card mt-3">
          <div class="card-header">
              <h5 class="float-start">Data Berkas</h5>
              
          </div>
          <div class="card-body" id="table_info_berkas">

          </div>
          {{-- <div class="card-footer">
            <button type="button" id="btn_input_data" class="btn btn-sm btn-primary float-end"><i class='bx bx-send'></i> Kirim</button>
          </div> --}}
        </div>


    </div>

    <!-- Total Revenue -->

    <!--/ Total Revenue -->
    
  </div>

</div>
<!-- / Content -->

    

  <!-- Modal -->



  <div class="modal fade" id="modal_sudah" tabindex="-1" aria-labelledby="modal_sudahLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modal_sudahLabel">Pengecekan</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <h4><b>Berkas sedang / sudah dialih media!</b></h4>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>







  @section('script')

  <script src="{{ asset('js') }}/qrcode.js" type="text/javascript"></script>

  <script>
    function getKecamatan(data){
              const dt_kecamatan_id = data.value;
              if (dt_kecamatan_id == '') {
                $('#kecamatan_id').val('');
              } else {
                const kecamatan_id = dt_kecamatan_id.split("|");
                $('#kecamatan_id').val(kecamatan_id[1]);
              }
              
            }

    function getKelurahan(kecamatan_id){
      $('#kelurahan_id').html('');
      const d_kecamatan_id = kecamatan_id.value == '' ? 0 : kecamatan_id.value;
      $.get('getKelurahan/'+d_kecamatan_id, function (data) {        
          $('#kelurahan_id').html(data);
      });
    }


  </script>

      <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });

        $(document).ready(function () {


          $(document).on('submit', '#form_informasi_berkas', function(event) {
                event.preventDefault();

                    $('#btn_info_berkas').attr('disabled',true);
                    $('#btn_info_berkas').html('Loading..');
                    $('#table_info_berkas').html('<div class="spinner-border text-danger" role="status"><span class="visually-hidden">Loading...</span></div>');

                    $.ajax({
                        url:"{{ route('dtInfoBerkas') }}",
                        method: 'POST',
                        data: new FormData(this),
                        contentType: false,
                        processData: false,
                        success: function(data) {

                            
                            $('#table_info_berkas').html(data);
                            $("#btn_info_berkas").removeAttr("disabled");
                            $('#btn_info_berkas').html('<i class="bx bx-search-alt"></i> Cari'); //tombol
                                                        
                        },
                        error: function (data) { //jika error tampilkan error pada console
                                    console.log('Error:', data);
                                    $("#btn_info_berkas").removeAttr("disabled");
                                    $('#btn_info_berkas').html('<i class="bx bx-search-alt"></i> Cari'); //tombol
                                }
                    });

                });



                $(document).on('click', '#btn_tutup_berkas', function() {

                  if (confirm("Apakah anda yakin ingin menutup berkas?") == true) {
                    var berkas_id = $(this).attr('berkas_id');
                    $('#btn_tutup_berkas').attr('disabled',true);
                      $('#btn_tutup_berkas').html('Loading..');
                      
                    $.get('tutupBerkas/' + berkas_id, function (data) {

                      
                      

                      Swal.fire({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        icon: 'success',
                        title: 'Berkas berhasil ditutup'
                      });

                        $('#table_info_berkas').html('<div class="spinner-border text-danger" role="status"><span class="visually-hidden">Loading...</span></div>');
                        $.get('dtInfoBerkasGet/' + berkas_id, function (data) {
                          $('#table_info_berkas').html(data);
                        });

                    });
                  }

                  

                });

        });

        

      </script>
  @endsection
@endsection

