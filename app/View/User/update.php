<!doctype html>
<html lang="id">

<head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1,shrink-to-fit=no">
     <title><?= $model['title'] ?></title>
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
     <link rel="stylesheet" href="styles.css">
</head>

<body>

     <!-- NAVBAR -->
     <nav id="main-navbar" class="navbar navbar-expand-md navbar-dark bg-dark py-0">
          <div class="container">
               <span class="navbar-brand">
                    Hello, <?php echo $model["name"]; ?>
               </span>
               <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
               </button>

               <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ml-auto">
                         <li class="nav-item">
                              <a class="nav-link p-3" href="/products">Tabel Barang</a>
                         </li>
                         <li class="nav-item">
                              <a class="nav-link p-3" href="/users/profile">My Profile</a>
                         </li>
                         <li class="nav-item">
                              <a class="nav-link p-3" href="/users/logout">Logout</a>
                         </li>
                    </ul>
               </div>
          </div>
     </nav>

     <div class="container" class="py-5">
          <div class="row">
               <div class="col-12 py-4 mx-auto">
                    <h1 class="h2 text-center">Ubah Password Berhasil!</h1>
                    <p class="text-center">Silahkan lanjut ke <a href="/products">tabel barang</a>
                         atau <a href="/users/logout">logout</a></p>
               </div>
          </div>
     </div>

     <footer id="main-footer" class="py-4">
          <div class="container">
               <div class="row">
                    <div class="col-12">
                         <small>
                              <?php
                              $tanggal = new DateTime('now');
                              echo "Copyright © " . $tanggal->format("Y") . " Duniailkom";
                              ?>
                         </small>
                    </div>
               </div>
          </div>
     </footer>

     <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
     <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>

</html>