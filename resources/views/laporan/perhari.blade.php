@extends('template.master')

@section('content')


<!-- Content -->
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


<div class="container-xxl flex-grow-1 container-p-y">
  <div class="row">

    <div class="col-12 mb-4 order-0">
      
      <div class="card">
          <div class="card-header">
              <h5 class="float-start">Laporan Perhari</h5>
              
          </div>
          
          <div class="card-body ">

            <div class="scrollme">
                <table class="table table-sm table-bordered" style="font-size: 12px;">
                    <thead>
                        <tr>
                            <th class="bg-white" style="font-size: 12px;">Petugas</th>
                            @foreach ($periode as $d)
                                <th class="bg-white text-center" style="font-size: 12px;">{{ date("d/m", strtotime($d->date)) }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dt_laporan as $d)
                            <tr>
                                <td>{{ $d['nm_user'] }}</td>
                                @foreach ($d['dt_history'] as $h)
                                    <td class="text-center"><a class="btn_info" data-bs-toggle="modal" href="#modal_info" user_id="{{ $d['user_id'] }}" tgl="{{ $h['tgl'] }}">{{ $h['jml'] }}</a></td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

          </div>
          
        </div>


    </div>

    <!-- Total Revenue -->

    <!--/ Total Revenue -->
    
  </div>

</div>
<!-- / Content -->

    

  <!-- Modal -->



  <div class="modal fade" id="modal_info" tabindex="-1" aria-labelledby="modal_infoLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modal_infoLabel">Pengecekan</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="table_info">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>







  @section('script')

  <script src="{{ asset('js') }}/qrcode.js" type="text/javascript"></script>

  {{-- <script>
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


  </script> --}}

      <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });

        $(document).ready(function () {

        $(document).on('click', '.btn_info', function() {

            var tgl = $(this).attr('tgl');
            var user_id = $(this).attr('user_id');
            $('#table_info').html('<div class="spinner-border text-danger" role="status"><span class="visually-hidden">Loading...</span></div>');
            $.get('getPekerjaanPerhari/' + user_id + '/' + tgl, function (data) {
                $('#table_info').html(data);
            });

        });


        //   $(document).on('submit', '#form_informasi_berkas', function(event) {
        //         event.preventDefault();

        //             $('#btn_info_berkas').attr('disabled',true);
        //             $('#btn_info_berkas').html('Loading..');
        //             $('#table_info_berkas').html('<div class="spinner-border text-danger" role="status"><span class="visually-hidden">Loading...</span></div>');

        //             $.ajax({
        //                 url:"{{ route('dtInfoBerkas') }}",
        //                 method: 'POST',
        //                 data: new FormData(this),
        //                 contentType: false,
        //                 processData: false,
        //                 success: function(data) {

                        
        //                     $('#table_info_berkas').html(data);
        //                     $("#btn_info_berkas").removeAttr("disabled");
        //                     $('#btn_info_berkas').html('<i class="bx bx-search-alt"></i> Cari'); //tombol
                                                    
        //                 },
        //                 error: function (data) { //jika error tampilkan error pada console
        //                             console.log('Error:', data);
        //                             $("#btn_info_berkas").removeAttr("disabled");
        //                             $('#btn_info_berkas').html('<i class="bx bx-search-alt"></i> Cari'); //tombol
        //                         }
        //             });

        //         });

        });

        

      </script>
  @endsection
@endsection

