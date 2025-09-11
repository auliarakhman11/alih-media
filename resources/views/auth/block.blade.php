<!DOCTYPE html>
<html lang="id" dir="ltr">

<head>
     <meta charset="utf-8" />
     <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
     <meta name="description" content="" />
     <meta name="author" content="" />

     <!-- Title -->
     <title>403 forbidden access is denied</title>
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />
     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous" />
</head>

<style>
    #footer{
     text-align: center;
     position: fixed;
     margin-left: 530px;
     bottom: 0px
}
</style>

<body class="bg-dark text-white py-5">
     <div class="container py-5">
          <div class="row justify-content-center">
               <div class="col-md-2 text-center">
                    <p><i class="fa fa-exclamation-triangle fa-5x"></i><br/>Status Code: 403</p>
               </div>
               <div class="col-md-4">
                    <h3>OPPSSS!!!! Maaf...</h3>
                    <p>Akses anda ke halaman ini belum tersedia.<br/>Silahkan tekan tombol kembali.</p>
                    <a class="btn btn-danger" href="{{ route('logout') }}">Logout</a>
               </div>
          </div>
     </div>

     <div id="footer" class="text-center">
     <strong>Copyright &copy; 2024 <a href="">PT CHAROEN POKHPAND INDONESIA PLANT BANDUNG</a>.</strong>
    All rights reserved.
     </div>
</body>

</html>