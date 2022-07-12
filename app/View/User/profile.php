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

     <div class="container">
          <div class="row">
               <div class="col-12 col-sm-10 col-md-8 col-lg-6 py-4">
                    <h1 class="h2 mr-auto">
                         <a class="text-info" href="/users/profile">User Profile</a>
                    </h1>
                    <?php if (isset($model['error'])) { ?>
                         <div id="divPesanError">
                              <div class="mx-auto">
                                   <div class="alert alert-danger" role="alert">
                                        <ul class="mb-0">
                                             <?= $model['error'] ?>
                                        </ul>
                                   </div>
                              </div>
                         </div>
                    <?php } ?>
                    <!-- Form untuk proses update -->
                    <p>
                         <?php echo $model['user']->username . " (" . $model['user']->email . ")"; ?>
                    </p>

                    <p>
                         <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#formPassword">Ubah Password</button>
                    </p>

                    <form method="POST" action="/users/profile" id="formPassword" class="collapse <?php if (!empty($_POST)) {
                                                                                                         echo "show";
                                                                                                    } ?>">

                         <div class="form-group">
                              <label for="old">Password Lama</label>
                              <input type="password" class="form-control" name="old">
                         </div>

                         <div class="form-group">
                              <label for="new">Password Baru</label>
                              <small> (minimal 6 karakter, harus terdapat angka dan huruf) </small>
                              <input type="password" class="form-control" name="new">
                         </div>

                         <div class="form-group">
                              <label for="repeat_new">Ulangi Password Baru</label>
                              <input type="password" class="form-control" name="repeat_new">
                         </div>

                         <input type="submit" class="btn btn-primary" value="Update">

                    </form>

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