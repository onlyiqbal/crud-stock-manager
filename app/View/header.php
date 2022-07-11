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