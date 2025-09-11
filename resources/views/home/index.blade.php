@extends('template.master')

@section('content')
    <!-- Content -->

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
      <div class="col-lg-12 mb-4 order-0">
        <div class="card">
          <div class="d-flex align-items-end row">
            <div class="col-12">
              <div class="card-header">
                <div class="row">

                  <div class="col-md-12 col-12"><h4 class="text-primary">Home</h4></div>

                  {{-- <div class="col-md-6 col-12">
                    <div class="navbar-nav align-items-center">
                      <div class="nav-item d-flex align-items-center">
                        <i class="bx bx-search fs-4 lh-0"></i>
                        <input
                          type="text"
                          class="form-control border-0 shadow-none"
                          placeholder="Search..."
                          aria-label="Search..."
                          id="search_field"
                        />
                      </div>
                    </div>
                  </div> --}}

                </div>
                
                
               
              </div>

              <div class="row">

                
              </div>

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


<form id="form_input_penilaian">
  <div class="modal fade" id="input_penilaian" tabindex="-1" aria-labelledby="input_penilaianLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="input_penilaianLabel">Input Penilaian <span id="nm_pegawai_input"></span></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
  
          
  
          
  
          {{-- <div class="card overflow-hidden mb-4" style="height: 300px">
            <h5 class="card-header">Vertical Scrollbar</h5>
            <div class="card-body" id="vertical-example">
  
              <ul class="list-group list-group-flush">
                <li class="list-group-item">Cras justo odio</li>
                <li class="list-group-item">Dapibus ac facilisis in</li>
                <li class="list-group-item">Vestibulum at eros</li>
              </ul>
  
            </div>
          </div> --}}
          
          
  
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" id="btn_simpan_penilaian">Simpan</button>
        </div>
      </div>
    </div>
  </div>
</form>





  @section('script')
      <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });

        $(document).ready(function () {

            <?php if(session('success')): ?>
            Swal.fire({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            icon: 'success',
            title: '<?= session('success'); ?>'
            });            
            <?php endif; ?>

            <?php if(session('error')): ?>
            Swal.fire({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            icon: 'error',
            title: '<?= session('error'); ?>'
            });            
            <?php endif; ?>

        });

        

      </script>
  @endsection
@endsection

