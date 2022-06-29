<!doctype html>
<html lang="id">

<head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1,shrink-to-fit=no">
     <title><?= $model['title'] ?></title>
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>

<body>
     <div class="container pt-5">
          <?php if (isset($model['error'])) { ?>
               <div class="row">
                    <div class="col-10 col-sm-8 col-md-6 col-lg-5 col-xl-4 mx-auto">
                         <div class="alert alert-danger" role="alert">
                              <ul class="mb-0">
                                   <li><?= $model['error'] ?></li>
                              </ul>
                         </div>
                    </div>
               </div>
          <?php } ?>
          <div class="row">
               <div class="col-10 col-sm-8 col-md-6 col-lg-5 col-xl-4 mx-auto">
                    <div class="card">
                         <div class="card-header">
                              <h4>Account Login</h4>
                         </div>
                         <div class="card-body">
                              <form method="post" action="/users/login" autocomplete="off">
                                   <div class="form-group">
                                        <label for="username">Username</label>
                                        <input type="username" class="form-control" name="username" value="<?= $_POST['username'] ?? "" ?>">
                                   </div>
                                   <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password" class="form-control" name="password">
                                   </div>
                                   <input type="submit" class="btn btn-info btn-block" value="Login">
                              </form>
                              <p class="mt-2 text-center">
                                   <small class="text-center">Belum terdaftar? Silahkan
                                        <a href="/users/register">register</a> terlebih dahulu
                                   </small>
                              </p>
                         </div>
                    </div>
               </div>
          </div>
     </div>

     <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
     <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>

</html>