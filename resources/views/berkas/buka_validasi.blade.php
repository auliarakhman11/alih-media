@extends('template.master')

@section('content')


<!-- Content -->

<style>
    /* .blick {
        background-color: #ed1a3a;
    }
    .blink-soft {
        animation: blinker 1.5s linear infinite;
    }
    @keyframes blinker {
        50% {
            opacity: 0;
        }
    } */

    .blink {
        animation: blink 1.5s linear infinite;
    }

    @keyframes blink {
        0% {
            background-color: red;
            color: white;
        }
        50% {
            background-color: orange;
            color: white;
        }
        100% {
            background-color: rgb(223, 195, 9);
            color: white;
        }
    }

</style>



<div class="container-xxl flex-grow-1 container-p-y">
  <div class="row">

    <div class="col-12 mb-4 order-0">
      
      <div class="card">
          <div class="card-header">
              <h5 class="float-start">List Berkas Buka Validasi</h5>
              <button type="button" class="btn btn-sm btn-rounded btn-primary float-end" id="btn_refresh"><i class='bx bx-refresh'></i></button>
          </div>
          
          <div class="card-body">

            <div class="table-responsive">
                <table class="table table-sm text-center" width="100%" id="table_berkas" style="font-size: 13px;">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Kecamatan</th>
                      <th>Kelurahan</th>
                      <th>Jenis Hak</th>
                      <th>No Hak</th>
                      <th>Nama Pemohonan</th>
                      <th>Peoses</th>
                      <th>Dari</th>
                      <th>Tanggal</th>
                      <th>Aksi</th>
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
  <form action="">
    @csrf
    <div class="modal fade" id="modal_kirim" tabindex="-1" aria-labelledby="modal_kirimLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modal_kirimLabel">Kirim Berkas</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
    
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="btn_kirim">Kirim</button>
          </div>
        </div>
      </div>
    </div>
  </form>





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
                    url: "{{ route('getListBukaValidasi') }}",
                    type: 'GET'
                },
                columns: [
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'kecamatan.nm_kecamatan',
                        name: 'kecamatan.nm_kecamatan'
                    },
                    {
                        data: 'kelurahan.nm_kelurahan',
                        name: 'kelurahan.nm_kelurahan'
                    },
                    {
                        data: 'jenis_hak.nm_hak',
                        name: 'jenis_hak.nm_hak'
                    },
                    {
                        data: 'no_hak',
                        name: 'no_hak'
                    },
                    {
                        data: 'nm_pemohon',
                        name: 'nm_pemohon'
                    },
                    {
                        data: 'proses.nm_proses',
                        name: 'proses.nm_proses'
                    },
                    {
                        data: 'asal_berkas',
                        name: 'dt_berkas.asal_berkas'
                    },
                    {
                        data: 'tanggal',
                        name: 'dt_berkas.tanggal'
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

            $(document).on('click', '.buka', function() {

                if (confirm('Apakah anda yakin ingin mebuka validasi?')) {
                    var berkas_id = $(this).attr('berkas_id');
                    var seksi_id = $(this).attr('seksi_id');
                    $.get('bukaValidasiBerkas/' + berkas_id + '/'+ seksi_id, function (data) {
                        var oTable = $('#table_berkas_naik').dataTable(); //inialisasi datatable
                            oTable.fnDraw(false); //reset datatable

                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            icon: 'success',
                            title: 'Data berhasil dihapus'
                            });

                            reload();
                    });
                }  

                
            });

            


        });

        

      </script>
  @endsection
@endsection

