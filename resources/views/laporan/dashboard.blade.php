@extends('template.master')

@section('chart')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.6.2/chart.min.js" integrity="sha512-tMabqarPtykgDtdtSqCL3uLVM0gS1ZkUAVhRFu1vSEFgvB73niFQWJuvviDyBGBH22Lcau4rHB5p2K2T0Xvr6Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endsection

@section('content')


<!-- Content -->



<div class="container-xxl flex-grow-1 container-p-y">
  <div class="row">

    <div class="col-12 mb-4 order-0">
      
      <div class="card">
          <div class="card-header">
              <h5 class="float-start">Grafik Performa Alih Media</h5>
              
          </div>
          
          <div class="card-body ">

            <canvas id="performa" width="400" height="180" class="bg-light"></canvas>

          </div>
          
        </div>

        <div class="card">
          <div class="card-header">
              <h5 class="float-start">Persentase Pengelesaian Alih Media</h5>
              
          </div>
          
          <div class="card-body ">

            <canvas id="persentase" width="300" height="300" class="bg-light"></canvas>

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
          <h5 class="modal-title" id="modal_infoLabel">Tunggakan Perproses</h5>
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

  <div class="modal fade" id="modal_info_pelayanan" tabindex="-1" aria-labelledby="modal_info_pelayananLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modal_info_pelayananLabel">Tunggakan Perproses</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="table_info_pelayanan">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>







  @section('script')

  <script>
        var cData = JSON.parse(`<?php echo $chart; ?>`);
        var periode = JSON.parse(`<?php echo $periode; ?>`);
        const ctx = document.getElementById('performa');
        const myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: periode,
                datasets: cData
            }
        });
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


        });

        

      </script>
  @endsection
@endsection

