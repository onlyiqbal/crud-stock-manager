<div class="container">
     <div class="row">
          <div class="col-12">
               <div class="py-4 d-flex justify-content-end align-items-center">
                    <h1 class="h2 mr-auto">
                         <a class="text-info" href="/products">Tabel Barang</a>
                    </h1>
                    <a href="/products/add" class="btn btn-primary">Tambah Barang</a>
               </div>
               <!-- Tabel barang -->
               <table class="table table-striped">
                    <thead>
                         <tr>
                              <th>ID</th>
                              <th>Nama Barang</th>
                              <th>Jumlah</th>
                              <th>Harga (Rp.)</th>
                              <th>Tanggal Update</th>
                              <th>Action</th>
                         </tr>
                    </thead>
                    <tbody>
                         <?php
                         foreach ($model['products'] as $product) {
                              echo "<tr>";
                              echo "<th>$product[id]</th>";
                              echo "<td>$product[name]</td>";
                              echo "<td>$product[quantity]</td>";
                              echo "<td>" . number_format($product['price'], 0, ',', '.') . "</td>";
                              echo "<td>$product[update_at]</td>";
                              echo "<td>";
                              echo "<a href='/products/edit/$product[id]' class='btn btn-info'>Edit</a>";
                              echo "<a href='/products/delete/$product[id]' class='btn btn-danger'>Hapus</a>";
                              echo "</td>";
                              echo "</tr>";
                         }
                         ?>
                    </tbody>
               </table>
          </div>
     </div>
</div>