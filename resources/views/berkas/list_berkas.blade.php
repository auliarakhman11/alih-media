@extends('template.master')

@section('content')


<!-- Content -->

<style>
    .blink {
        animation: blink 1.5s linear infinite;
    }

    @keyframes blink {
        0% {
            background-color: #ffa8b8;
            color: black;
        }
        50% {
            background-color: #f7d8c3;
            color: black;
        }
        100% {
            background-color: #fae187;
            color: black;
        }
    }

</style>



<div class="container-xxl flex-grow-1 container-p-y">
  <div class="row">

    <div class="col-12 mb-4 order-0">
      
      <div class="card">
          <div class="card-header">
              <h5 class="float-start">List Berkas</h5>
              <button type="button" class="btn btn-sm btn-rounded btn-primary float-end mt-2" id="btn_refresh"><i class='bx bx-refresh'></i></button>
              <a href="{{ route('exportExcel') }}" class="btn btn-sm btn-rounded btn-primary float-end mt-2" id="btn_refresh"><i class='bx bxs-download'></i></a>
          </div>
          
          <div class="card-body">

            <div class="table-responsive">
                <table class="table table-sm text-center" width="100%" id="table_berkas" style="font-size: 12px;">
                  <thead>
                    <tr>
                      <th style="font-size: 10px;">#</th>
                      <th style="font-size: 10px;">Kecamatan</th>
                      <th style="font-size: 10px;">Kelurahan</th>
                      <th style="font-size: 10px;">Hak</th>
                      <th style="font-size: 10px;">Pelayanan</th>
                      <th style="font-size: 10px;">Pe mohon</th>
                      <th style="font-size: 10px;">SU/GS</th>
                      <th style="font-size: 10px;">NIB</th>
                      <th style="font-size: 10px;">Proses</th>
                      <th style="font-size: 10px;">Tanggal</th>
                      <th style="font-size: 10px;">Keterangan</th>
                      <th style="font-size: 10px;">Berkas<br>Dari</th>
                      <th style="font-size: 10px;">Aksi</th>
                  </tr>
                  </thead>
                  <tbody></tbody>
                </table>
              </div>

          </div>
          
        </div>

        {{-- <div class="card mt-3">
          <div class="card-header">
              <h5 class="float-start">Kirim Berkas</h5>
              
          </div>
          <div class="card-body" id="cart">

          </div>
          <div class="card-footer">
            <button type="button" id="btn_input_data" class="btn btn-sm btn-primary float-end"><i class='bx bx-send'></i> Kirim</button>
          </div>
        </div> --}}


    </div>

    <!-- Total Revenue -->

    <!--/ Total Revenue -->
    
  </div>

</div>
<!-- / Content -->

    

  <!-- Modal -->

    <div class="modal fade" id="modal_loading" tabindex="-1" aria-labelledby="modal_loadingLabel" aria-hidden="true" >
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          {{-- <div class="modal-header">
            <h5 class="modal-title" id="modal_loadingLabel">loading Berkas</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div> --}}
          <div class="modal-body" >
            <div class="spinner-border text-danger" role="status"><span class="visually-hidden">Loading...</span></div> Loading...
          </div>

        </div>
      </div>
    </div>
  

  <form id="form_kembali_berkas">
    @csrf
    <div class="modal fade" id="modal_kembali" tabindex="-1" aria-labelledby="modal_kembaliLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modal_kembaliLabel">Digitalisasi Induk</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body" id="table_kembali">
    
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="btn_kembali">Kirim</button>
          </div>
        </div>
      </div>
    </div>
  </form>

  <form id="form_nibel">
    @csrf
    <div class="modal fade" id="modal_nibel" tabindex="-1" aria-labelledby="modal_nibelLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modal_nibelLabel">Data NIBEL</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-12">
                <div class="form-group">
                    <label for="">NIBEL</label>
                    <input type="hidden" name="history_id" id="history_id_nibel">
                    <input type="hidden" name="berkas_id" id="berkas_id_nibel">
                    <input type="text" name="nibel" class="form-control mt-2" required placeholder="Masukan data NIBEL..">
                </div>
            </div>
            </div>
    
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="btn_nibel">Kirim</button>
          </div>
        </div>
      </div>
    </div>
  </form>


  <form id="form_keterangan_berkas">
    @csrf
    <div class="modal fade" id="modal_keterangan" tabindex="-1" aria-labelledby="modal_keteranganLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modal_keteranganLabel">Keterangan</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body" id="table_keterangan">
    
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="btn_keterangan">Simpan</button>
          </div>
        </div>
      </div>
    </div>
  </form>


    <div class="modal fade" id="modal_upload" tabindex="-1" aria-labelledby="modal_uploadLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modal_uploadLabel">upload</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body" id="table_upload">
            <img src="">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>


    <div class="modal fade" id="modal_sudah" tabindex="-1" aria-labelledby="modal_sudahLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modal_sudahLabel">Pengecekan</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <h4><b>Berkas Induk sedang / sudah dialih media!</b></h4>
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

            $('#table_berkas').DataTable({
                processing: true,
                serverSide: true, //aktifkan server-side 
                ajax: {
                    url: "{{ route('getListBerkas') }}",
                    type: 'GET'
                },
                columns: [
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'nm_kecamatan',
                        name: 'dt_berkas.nm_kecamatan'
                    },
                    {
                        data: 'nm_kelurahan',
                        name: 'dt_berkas.nm_kelurahan'
                    },
                    {
                        data: 'dt_hak',
                        name: 'dt_berkas.dt_hak'
                    },
                    {
                        data: 'nm_pelayanan',
                        name: 'dt_berkas.nm_pelayanan'
                    },
                    {
                        data: 'nm_pemohon',
                        name: 'dt_berkas.nm_pemohon'
                    },
                    {
                        data: 'dt_peta',
                        name: 'dt_berkas.dt_peta'
                    },
                    {
                        data: 'nib',
                        name: 'dt_berkas.nib'
                    },
                    {
                        data: 'proses.nm_proses',
                        name: 'proses.nm_proses'
                    },
                    {
                        data: 'tanggal',
                        name: 'dt_berkas.tanggal'
                    },
                    {
                        data: 'ket',
                        name: 'ket'
                    },
                    {
                        data: 'user.name',
                        name: 'user.name'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },
                ],
                order: [],
                columnDefs: [ 
                {
                "targets": 0,
                "orderable": false
                },
                { "searchable": false, "targets": 0 }
               ],
            });

            function reload(){
                var oTable = $('#table_berkas').dataTable(); //inialisasi datatable
                oTable.fnDraw(false); //reset datatable
            }

            $(document).on('click', '#btn_refresh', function() {
                reload();
            });


            $(document).on('click', '.kirim', function() {

              if (confirm("Apakah anda yakin ingin mengirim berkas??") == true) {
                var berkas_id = $(this).attr('berkas_id');
                // $('#berkas_id').val(berkas_id);
                var jenis = $(this).attr('jenis');
                var history_id = $(this).attr('history_id');
                var proses_id = $(this).attr('proses_id');
                // $('#proses_id').val(proses_id);
                
                // $('#modal_loading').modal('show');
                
                $(this).attr('disabled',true);
                $(this).html('<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span><span class="visually-hidden">Loading...</span>');
                $.get('krimBerkas/' + jenis+'/'+history_id+'/'+berkas_id+'/'+proses_id, function (data) {
                reload();
                // $('#modal_loading').modal('hide');
                  Swal.fire({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    icon: 'success',
                    title: 'Data berhasil dikirim'
                  });

                  

                });
              }

              
              
            });

            


            $(document).on('click', '.kembali', function() {

              var berkas_id = $(this).attr('berkas_id');
              $('#table_kembali').html('<div class="spinner-border text-danger" role="status"><span class="visually-hidden">Loading...</span></div>');
              $.get('getKembali/' + berkas_id, function (data) {
                  $('#table_kembali').html(data);
              });

            });


            $(document).on('submit', '#form_kembali_berkas', function(event) {
                event.preventDefault();
                    $('#btn_kembali').attr('disabled',true);
                    $('#btn_kembali').html('Loading...');
                    $.ajax({
                        url:"{{ route('kembaliBerkas') }}",
                        method: 'POST',
                        data: new FormData(this),
                        contentType: false,
                        processData: false,
                        success: function(data) {

                            if(data){
                                
                                
                                $('#modal_kembali').modal('hide');

                                reload();

                                Swal.fire({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                icon: 'success',
                                title: 'Data berhasil dikirim'
                                });
                            }else{
                              $('#modal_kembali').modal('hide');
                              $('#modal_sudah').modal('show');
                              reload();
                            }

                            $("#btn_kembali").removeAttr("disabled");
                            $('#btn_kembali').html('Kirim'); //tombol simpan
                            
                        },
                        error: function (data) { //jika error tampilkan error pada console
                                    console.log('Error:', data);
                                    Swal.fire({
                                      toast: true,
                                      position: 'top-end',
                                      showConfirmButton: false,
                                      timer: 3000,
                                      icon: 'error',
                                      title: 'Ada masalah'
                                    });
                                    $('#btn_kembali').html('Kirim');
                                    $("#btn_kembali").removeAttr("disabled");
                          }
                    });

            });

            $(document).on('click', '.keterangan', function() {

              var berkas_id = $(this).attr('berkas_id');
              var history_id = $(this).attr('history_id');
              $('#table_keterangan').html('<div class="spinner-border text-danger" role="status"><span class="visually-hidden">Loading...</span></div>');
              $.get('getKeterangan/' + berkas_id + '/' + history_id, function (data) {
                  $('#table_keterangan').html(data);
              });

            });


            $(document).on('submit', '#form_keterangan_berkas', function(event) {
                event.preventDefault();
                    $('#btn_keterangan').attr('disabled',true);
                    $('#btn_keterangan').html('Loading...');
                    $.ajax({
                        url:"{{ route('keteranganBerkas') }}",
                        method: 'POST',
                        data: new FormData(this),
                        contentType: false,
                        processData: false,
                        success: function(data) {

                            if(data){
                                $("#btn_keterangan").removeAttr("disabled");
                                $('#btn_keterangan').html('Simpan'); //tombol simpan
                                
                                $('#modal_keterangan').modal('hide');

                                reload();

                                Swal.fire({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                icon: 'success',
                                title: 'Data berhasil dikirim'
                                });
                            }else{
                                Swal.fire({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                icon: 'error',
                                title: 'Ada masalah'
                                });
                                $('#btn_keterangan').html('Simpan');
                                $("#btn_keterangan").removeAttr("disabled");
                            }   
                            
                        },
                        error: function (data) { //jika error tampilkan error pada console
                                    console.log('Error:', data);
                                    Swal.fire({
                                      toast: true,
                                      position: 'top-end',
                                      showConfirmButton: false,
                                      timer: 3000,
                                      icon: 'error',
                                      title: 'Ada masalah'
                                    });
                                    $('#btn_keterangan').html('Simpan');
                                    $("#btn_keterangan").removeAttr("disabled");
                          }
                    });

            });


            $(document).on('click', '.file_name', function() {

              var url = "{{ asset('scan') }}/";
              var file_name = $(this).attr('file_name');
              var jenis_file = file_name.split(".");

              if (jenis_file[1] == 'pdf') {      
              var pdf = '<object data="'+url+file_name+'" type="application/pdf" width="750" height="500"></object>';
              $("#table_upload").html(pdf);
              }else{
                var image = '<img src="'+url+file_name+'" class="img-fluid">';
                $("#table_upload").html(image);
              }

            });


            $(document).on('click', '.kunci', function() {

              if (confirm("Apakah anda yakin ingin mengunci berkas?") == true) {
                var history_id = $(this).attr('history_id');
                $.get('kunciBerkas/' + history_id, function (data) {
                reload();
                // $('#modal_loading').modal('hide');
                  Swal.fire({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    icon: 'success',
                    title: 'Data berhasil dikunci'
                  });

                  

                });
              }
            });

            // $(document).on('click', '.buka_kunci', function() {

            //   if (confirm("Apakah anda yakin ingin membuka berkas?") == true) {
            //     var history_id = $(this).attr('history_id');
            //     $.get('bukaBerkas/' + history_id, function (data) {
            //     reload();
            //     // $('#modal_loading').modal('hide');
            //       Swal.fire({
            //         toast: true,
            //         position: 'top-end',
            //         showConfirmButton: false,
            //         timer: 3000,
            //         icon: 'success',
            //         title: 'Data berhasil dibuka'
            //       });

                  

            //     });
            //   }
            // });


            $(document).on('click', '.nibel', function() {

                var berkas_id = $(this).attr('berkas_id');
                var history_id = $(this).attr('history_id');

                $("#berkas_id_nibel").val(berkas_id);
                $("#history_id_nibel").val(history_id);

            });


            $(document).on('submit', '#form_nibel', function(event) {
                event.preventDefault();
                    $('#btn_nibel').attr('disabled',true);
                    $('#btn_nibel').html('Loading...');
                    $.ajax({
                        url:"{{ route('pengesahanBt') }}",
                        method: 'POST',
                        data: new FormData(this),
                        contentType: false,
                        processData: false,
                        success: function(data) {
                                
                                
                                $('#modal_nibel').modal('hide');
                                $('#form_nibel').trigger("reset");

                                reload();

                                Swal.fire({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                icon: 'success',
                                title: 'Data berhasil dikirim'
                                });
                            

                            $("#btn_nibel").removeAttr("disabled");
                            $('#btn_nibel').html('Kirim'); //tombol simpan
                            
                        },
                        error: function (data) { //jika error tampilkan error pada console
                                    console.log('Error:', data);
                                    Swal.fire({
                                      toast: true,
                                      position: 'top-end',
                                      showConfirmButton: false,
                                      timer: 3000,
                                      icon: 'error',
                                      title: 'Ada masalah'
                                    });
                                    $('#btn_nibel').html('Kirim');
                                    $("#btn_nibel").removeAttr("disabled");
                          }
                    });

            });




        });

        

      </script>
  @endsection
@endsection

