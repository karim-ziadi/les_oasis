<?php require_once 'config.php'; ?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="/docs/4.0/assets/img/favicons/favicon.ico">

  <title>Les Oasis</title>

  <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/pricing/">

  <!-- Bootstrap core CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="pricing.css" rel="stylesheet">
</head>

<body>

  <nav class="navbar navbar-expand-lg bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand text-white" href="#">Navbar</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active text-white" aria-current="page" href="#">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white" href="#">Link</a>
          </li>

          <li class="nav-item">
            <a class="nav-link disabled text-white">Disabled</a>
          </li>
        </ul>
        <?php if (!isset($_SESSION["user"])) : ?>
          <!-- <div class="dropdown ms-3"> -->
          <ul class="navbar-nav  mb-2 mb-lg-0">
            <li class="nav-item">
              <a href="<?php echo BURL . 'inscription.php'; ?>" class="nav-link  text-white">Inscription</a>
            </li>

          </ul>
          <!-- </div> -->
        <?php else : ?>
          <div class="dropdown ms-3">
            <button class="btn btn-bd-light dropdown-toggle text-light" id="bd-versions" data-bs-toggle="dropdown" aria-expanded="false" data-bs-display="static">
              <span class="d-none d-lg-inline text-light">Bienvenu </span> <?php echo $_SESSION['user']["nom"] ?>
            </button>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="bd-versions">
              <li>
                <a href="<?php echo BURL . 'logout.php'; ?>" class="dropdown-header text-decoration-none">Deconnecsion</a>
              </li>
              <!-- <?php if ($_SESSION['user']["type"] != 'user') : ?>
                <li>
                  <a href="<?php echo BURLA . 'index.php'; ?>" class="dropdown-header text-decoration-none">Dashboard</a>
                </li>
              <?php endif; ?> -->
            </ul>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </nav>


  <!-- Bootstrap core JavaScript
    ================================================== -->
  <!-- Placed at the end of the document so the pages load faster -->
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script>
    window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')
  </script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../../assets/js/vendor/holder.min.js"></script>
  <script>
    Holder.addTheme('thumb', {
      bg: '#55595c',
      fg: '#eceeef',
      text: 'Thumbnail'
    });
  </script>
</body>

</html>