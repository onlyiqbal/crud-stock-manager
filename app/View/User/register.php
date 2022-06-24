<!doctype html>
<html lang="id">

<head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1,shrink-to-fit=no">
     <title><?= $model['title'] ?></title>
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>

<body>

     <div class="container">
          <div class="row">
               <div class="col-12 col-md-8 col-lg-6 py-4">
                    <h1 class="h2 mr-auto"><a class="text-info" href="/users/register">Register User</a></h1>

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
                    <!-- Form untuk proses insert -->
                    <form action="/users/register" method="post">
                         <div class="form-group">
                              <label for="username">Id</label>
                              <small> (minimal 5 karakter angka atau huruf) </small>
                              <input type="text" class="form-control" name="id" value="<?= $_POST['id'] ?? "" ?>">
                         </div>

                         <div class="form-group">
                              <label for="username">Username</label>
                              <small> (minimal 5 karakter angka atau huruf) </small>
                              <input type="text" class="form-control" name="username" value="<?= $_POST['username'] ?? "" ?>">
                         </div>

                         <div class="form-group">
                              <label for="password">Password</label>
                              <small> (minimal 6 karakter, harus terdapat angka dan huruf) </small>
                              <input type="password" class="form-control" name="password">
                         </div>

                         <div class="form-group">
                              <label for="ulangi_password">Ulangi Password</label>
                              <input type="password" class="form-control" name="ulangi_password">
                         </div>

                         <div class="form-group">
                              <label for="email">Email</label>
                              <input type="text" class="form-control" name="email" value="<?= $_POST['email'] ?? "" ?>">
                         </div>
                         <input type="submit" class="btn btn-primary" value="Daftar">
                         <a href="/users/login" class="btn btn-danger">Batal</a>
                    </form>

               </div>
          </div>
     </div>

     <!-- FOOTER -->
     <footer id="main-footer" class="py-4">
          <div class="container">
               <div class="row">
                    <div class="col-12">
                         <small>
                              <?php
                              $tanggal = new DateTime('now');
                              echo "Copyright © " . $tanggal->format("Y") . " Iqbal";
                              ?>
                         </small>
                    </div>
               </div>
          </div>
     </footer>
     <!-- END FOOTER -->

     <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
     <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>

</html>