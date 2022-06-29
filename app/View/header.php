<!doctype html>
<html lang="id">

<head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1,shrink-to-fit=no">
     <title>ILKOOM Inventory</title>
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
     <style>
          /* NAVBAR */
          #main-navbar .nav-link {
               border-bottom: 5px solid #343a40;
               color: #eed3d3;
          }

          #main-navbar .nav-link:hover,
          #main-navbar a.active {
               border-bottom: 5px solid #117a8b;
               color: white;
          }

          /* TABLE - agar teks berada di tengah secara vertikal */
          table,
          th,
          td {
               vertical-align: middle !important;
          }
     </style>
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
                              <a class="nav-link p-3 <?php echo basename($_SERVER['PHP_SELF'])
                                                            == "tampil_barang.php" ? "active" : ""; ?>" href="tampil_barang.php">
                                   Tabel Barang</a>
                         </li>
                         <li class="nav-item">
                              <a class="nav-link p-3 <?php echo basename($_SERVER['PHP_SELF'])
                                                            == "profile.php" ? "active" : ""; ?>" href="profile.php">
                                   My Profile</a>
                         </li>
                         <li class="nav-item">
                              <a class="nav-link p-3" href="logout.php">Logout</a>
                         </li>
                    </ul>
               </div>
          </div>
     </nav>