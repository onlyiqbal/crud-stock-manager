<div class="container">
     <div class="row">
          <div class="col-6 py-4">
               <h1 class="h2 mr-auto"><a class="text-info" href="/products/edit/">Edit Barang</a></h1>

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

               <!-- Form untuk proses update -->
               <form method="POST">

                    <div class="form-group">
                         <label for="nama_barang">ID Barang</label>
                         <input type="text" class="form-control" name="product_id" disabled value="<?= $model['product']->id ?>">
                         <small class="d-block">*ID Barang tidak bisa diubah</small>
                    </div>

                    <div class="form-group">
                         <label for="nama_barang">Nama Barang</label>
                         <input type="text" class="form-control" name="product_name" value="<?= $model['product']->name ?? $_POST['product_name'] ?>">
                    </div>

                    <div class="form-group">
                         <label for="jumlah_barang">Jumlah</label>
                         <input type="text" class="form-control" name="quantity" value="<?= $model['product']->quantity ?? $_POST['quantity'] ?>">
                    </div>

                    <div class="form-group">
                         <label for="harga_barang">Harga</label>
                         <input type="text" class="form-control" name="price" value="<?= $model['product']->price ?? $_POST['price'] ?>">
                    </div>

                    <input type="submit" class="btn btn-primary" value="Update">
                    <a href="/products" class="btn btn-secondary">Cancel</a>

               </form>

          </div>
     </div>
</div>