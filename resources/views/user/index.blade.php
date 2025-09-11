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
            <h5 class="float-start">Data User</h5>
            <button type="button" class="btn btn-sm btn-primary float-end" data-bs-toggle="modal" data-bs-target="#modal_add_user"><i class='bx bxs-plus-circle'></i> Tambah Data</button>              
          </div>
          
          <div class="card-body">

            <div class="table-responsive">
                <table class="table table-sm text-center" width="100%" id="table">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Nama</th>
                      <th>Username</th>
                      <th>Jenis</th>
                      <th>Aktif</th>
                      <th>Aksi</th>
                  </tr>
                  </thead>
                  <tbody>
                    @php
                        $i = 1;
                    @endphp
                    @foreach ($user as $d)
                        <tr>
                          <td>{{ $i++ }}</td>
                          <td>{{ $d->name }}</td>
                          <td>{{ $d->username }}</td>
                          <td>{{ $d->jenisUser->nm_jenis }}</td>
                          <td>{{ $d->aktif ? 'Aktif' : 'non-aktif' }}</td>
                          <td><button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modal_edit_user{{ $d->id}}"><i class='bx bxs-message-square-edit'></i></button></td>
                        </tr>
                    @endforeach
                  </tbody>
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

  <form method="POST" action="{{ route('addUser') }}">
    @csrf
    <div class="modal fade" id="modal_add_user" tabindex="-1" aria-labelledby="modal_add_userLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered ">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="modal_add_userLabel">Tambah User</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div class="row">

                <div class="col-12 mb-2">
                    <div class="form-group">
                        <label for="">Nama</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                </div>

                <div class="col-12 mb-2">
                  <div class="form-group">
                      <label for="">Username</label>
                      <input type="text" name="username" class="form-control" required>
                  </div>
                </div> 
                
                <div class="col-12 mb-2">
                  <div class="form-group">
                      <label for="">Jenis/</label>
                      <select name="jenis_user_id" class="form-control" required>
                        <option value="">Pilih Jenis</option>
                        @foreach ($jenis_user as $d)
                        <option value="{{ $d->id }}">{{ $d->nm_jenis }}</option>
                        @endforeach
                      </select>
                  </div>
                </div> 

                <div class="col-12 mb-2">
                  <div class="form-group">
                      <label for="">Password</label>
                      <input type="password" name="password" class="form-control" required>
                  </div>
                </div> 

                <div class="col-12 mb-2">
                  <div class="form-group">
                      <label for="">Confirmasi Password</label>
                      <input type="password" name="password_confirmation" class="form-control" required>
                  </div>
                </div>

                <div class="col-12 mt-3"><h4><b>Akses Proses</b></h4></div>
                
                @foreach ($proses as $p)
                    <div class="col-6">
                      <label for="{{ $p->nm_proses.$p->id }}"><input id="{{ $p->nm_proses.$p->id }}" type="checkbox" value="{{ $p->id }}" name="proses_id[]" > {{ $p->nm_proses }}</label>
                    </div>
                @endforeach

                
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary" id="btn_edit_user">Save</button>
            </div>
          </div>
        </div>
      </div>
  </form>


  @foreach ($user as $u)
  <form method="POST" action="{{ route('editUser') }}">
    @csrf
    <div class="modal fade" id="modal_edit_user{{ $u->id}}" tabindex="-1" aria-labelledby="modal_add_userLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered ">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="modal_add_userLabel">Edit User</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div class="row">

                <input type="hidden" name="id" value="{{ $u->id }}">
                <div class="col-12 mb-2">
                    <div class="form-group">
                        <label for="">Nama</label>
                        <input type="text" name="name" class="form-control" value="{{ $u->name }}" required>
                    </div>
                </div>

                
                <div class="col-12 mb-2">
                  <div class="form-group">
                      <label for="">Jenis</label>
                      <select name="jenis_user_id" class="form-control" required>
                        @foreach ($jenis_user as $r)
                        <option value="{{ $r->id }}" {{ $r->id == $u->jenis_user_id ? 'selected' : '' }}>{{ $r->nm_jenis }}</option>
                        @endforeach
                      </select>
                  </div>
                </div>

                <div class="col-12 mt-3"><h4><b>Akses Menu</b></h4></div>

                @php
                    $dtProses = [];
                @endphp
                @if ($u->aksesProses)
                  @foreach ($u->aksesProses as $a)
                    @php
                        $dtProses [] = $a->proses_id
                    @endphp
                  @endforeach
                @endif

                
                @foreach ($proses as $s)
                    <div class="col-6">
                      <label for="{{ $s->nm_proses.$s->id.$u->id }}"><input id="{{ $s->nm_proses.$s->id.$u->id }}" type="checkbox" value="{{ $s->id }}" name="proses_id[]" {{ in_array($s->id, $dtProses) ? 'checked' : '' }} > {{ $s->nm_proses }}</label>
                    </div>
                @endforeach


                
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary" id="btn_edit_user">Save</button>
            </div>
          </div>
        </div>
      </div>
  </form>
  @endforeach





  @section('script')

  <script src="{{ asset('js') }}/qrcode.js" type="text/javascript"></script>

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

      <?php if(session('error_kota')): ?>
      Swal.fire({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                icon: 'error',
                title: "{{ session('error_kota') }}"
              });            
      <?php endif; ?>

      <?php if($errors->any()): ?>
      Swal.fire({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                icon: 'error',
                title: ' Ada data yang tidak sesuai, periksa kembali'
              });            
      <?php endif; ?>


        
    });

    

  </script>
  @endsection
@endsection

