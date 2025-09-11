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
              <h5 class="float-start">List Berkas Tunggakan</h5>
              <button type="button" class="btn btn-sm btn-rounded btn-primary float-end" id="btn_refresh"><i class='bx bx-refresh'></i></button>
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
                      <th style="font-size: 10px;">SU/GU</th>
                      <th style="font-size: 10px;">NIB</th>
                      <th style="font-size: 10px;">Tanggal</th>
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

    <div class="modal fade" id="modal_info_tunggakan" tabindex="-1" aria-labelledby="modal_info_tunggakanLabel" aria-hidden="true">
      <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modal_info_tunggakanLabel">Informasi Berkas</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body" id="table_info_tunggakan">
    
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
                    url: "{{ route('getListTunggakan') }}",
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
                        data: 'dt_hak',
                        name: 'dt_berkas.dt_hak'
                    },
                    {
                        data: 'dt_peta',
                        name: 'dt_berkas.dt_peta'
                    },
                    {
                        data: 'nib',
                        name: 'nib'
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

            $(document).on('click', '.btn_info_tunggakan', function() {

              var berkas_id = $(this).attr('berkas_id');
              $('#table_info_tunggakan').html('<div class="spinner-border text-danger" role="status"><span class="visually-hidden">Loading...</span></div>');
              $.get('dtInfoTunggakan/' + berkas_id, function (data) {
                  $('#table_info_tunggakan').html(data);
              });

            });


            




        });

        

      </script>
  @endsection
@endsection

