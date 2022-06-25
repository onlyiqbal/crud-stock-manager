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