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
                    <!-- Form untuk proses register -->
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
                              <small> (minimal 8 karakter, harus terdapat angka dan huruf) </small>
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