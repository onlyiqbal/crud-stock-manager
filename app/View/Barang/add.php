<div class="container">
     <div class="row">
          <div class="col-6 py-4">
               <h1 class="h2 mr-auto"><a class="text-info" href="/products/add">Tambah Barang</a></h1>

               <?php if (isset($model['error'])) { ?>
                    <div id="divPesanError">
                         <div class="mx-auto">
                              <div class="alert alert-danger" role="alert">
                                   <ul class="mb-0">
                                        <li><?= $model['error'] ?></li>
                                   </ul>
                              </div>
                         </div>
                    </div>
               <?php } ?>

               <!-- Form untuk proses insert -->
               <form method="post">
                    <div class="form-group">
                         <label for="nama_barang">Nama Barang</label>
                         <input type="text" class="form-control" name="name" value="<?= $_POST['name'] ?? "" ?>">
                    </div>
                    <div class="form-group">
                         <label for="jumlah_barang">Jumlah</label>
                         <input type="text" class="form-control" name="quantity" value="<?= $_POST['quantity'] ?? "" ?>">
                    </div>
                    <div class="form-group">
                         <label for="harga_barang">Harga</label>
                         <input type="text" class="form-control" name="price" value="<?= $_POST['price'] ?? "" ?>">
                    </div>
                    <input type="submit" class="btn btn-primary" value="Tambah">
               </form>

          </div>
     </div>
</div>