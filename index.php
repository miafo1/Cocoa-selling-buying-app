<!DOCTYPE html>
<!-- saved from url=(0052)https://getbootstrap.com/docs/4.1/examples/carousel/ -->
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="images/10.webp">

  <title>Cocoa|web</title>
  
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

  <!-- Optional theme -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">

  <!-- Latest compiled and minified JavaScript -->
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>

  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

  <link rel="canonical" href="https://getbootstrap.com/docs/4.1/examples/carousel/">

  <!-- Bootstrap core CSS -->
  <link href="./Carousel Template for Bootstrap_files/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="./Carousel Template for Bootstrap_files/carousel.css" rel="stylesheet">
  
  <!-- fontawesome CDN -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">

  <style type="text/css">
    .carousel-control-prev:hover, .carousel-control-next:hover{
      background-color: rgba(0,0,0,0.3);
    }
  </style>
  
</head>
<body>

  <header>
    <?php
      include'navbar.php';
    ?>
  </header>

  <main role="main" class="container-fluid">

    <div id="myCarousel" class="carousel slide" data-ride="carousel" style="margin-top: 64px;">
      <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
        <li data-target="#myCarousel" data-slide-to="3"></li>
        <li data-target="#myCarousel" data-slide-to="4"></li>
        <li data-target="#myCarousel" data-slide-to="5"></li>
        

      </ol>
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img class="first-slide" src="images/1.webp" alt="First slide">
        </div>
        <div class="carousel-item">
          <img class="second-slide" src="images/7.jpg" alt="Second slide">
        </div>
        <div class="carousel-item">
          <img class="third-slide" src="images/3.jpg" alt="Third slide">
        </div>
        <div class="carousel-item">
          <img class="fouth-slide" src="images/4.jpg" alt="Third slide">
        </div>
        <div class="carousel-item">
          <img class="fith-slide" src="images/2.jpg" alt="Third slide">
        </div>
        <div class="carousel-item">
          <img class="sixth-slide" src="images/8.jpg" alt="Third slide">
        </div>
      </div>
      <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
    </div>


      
          <!-- START THE FEATURETTES -->

          <hr class="featurette-divider">

          <div class="row featurette">
            <div class="col-md-7">
              <h2 class="featurette-heading">Briefing</h2>
              <p class="lead"> L'application Cocoa est une plateforme en ligne qui facilite la gestion des réservations et des collaborations dans le secteur du cacao. Elle rassemble différents acteurs pour promouvoir l'échange de produits et la formation dans ce domaine. Voici les rôles et actions possibles pour chaque utilisateur de la plateforme</p>
            </div>
            <div class="col-md-5" style="overflow-x: hidden;">
              <img class="featurette-image mx-auto" data-src="holder.js/500x500/auto" alt="500x500" style="width: 700px; height: 500px;" src="images\admin2.jpg" data-holder-rendered="true">
            </div>
          </div>

          <hr class="featurette-divider">

          <div class="row featurette">
            <div class="col-md-7 order-md-2">
              <h2 class="featurette-heading">Acheteur</h2>
              <p class="lead">L'acheteur peut visualiser toutes les coopératives (corporations) disponibles sur la plateforme.
Il peut réserver des stocks de cacao mis en vente par les coopératives.
L'acheteur peut également envoyer des messages aux délégués des coopératives pour organiser des échanges ou demander des informations supplémentaires sur les produits. </p>
            </div>
            <div class="col-md-5 order-md-1" style="overflow-x: hidden;">
              <img class="featurette-image mx-auto" data-src="holder.js/500x500/auto" alt="500x500" src="images\cocoabag.jpg" data-holder-rendered="true" style="width: 700px; height: 500px;">
            </div>
          </div>

          <hr class="featurette-divider">

          <div class="row featurette">
            <div class="col-md-7">
              <h2 class="featurette-heading">Formateur</h2>
              <p class="lead">Le formateur peut créer un compte et fournir des ressources (fichiers, dossiers, vidéos) pour aider les membres des coopératives à améliorer la qualité de leurs produits.
              Il peut télécharger et organiser des formations en ligne à destination des membres des coopératives.</p>
            </div>
            <div class="col-md-5" style="overflow-x: hidden;">
              <img class="featurette-image mx-auto" data-src="holder.js/500x500/auto" alt="500x500" src="images\format.jpg" data-holder-rendered="true" style="width: 700px; height: 500px;">
            </div>
          </div>

           <hr class="featurette-divider">

          <div class="row featurette">
            <div class="col-md-7 order-md-2">
              <h2 class="featurette-heading">Délégué de Coopérative (Delegué Corp)</h2>
              <p class="lead">Le délégué représente et gère une coopérative spécifique.
Il peut ajouter, mettre à jour et supprimer les membres de sa coopérative.
Il publie les stocks de cacao disponibles avec des informations détaillées (quantité, prix, localisation).
Le délégué reçoit et gère les messages envoyés par les acheteurs et peut y répondre via la plateforme.</p>
            </div>
            <div class="col-md-5" style="overflow-x: hidden;">
              <img class="featurette-image mx-auto" data-src="holder.js/500x500/auto" alt="500x500" src="images\delegate.jpg" data-holder-rendered="true" style="width: 700px; height: 500px;">
            </div>
          </div>

          <hr class="featurette-divider">

          <!-- /END THE FEATURETTES -->

        </div><!-- /.container -->


      </main>
        <!-- FOOTER -->
        <?php
          include'footer.php';
        ?>
        

<!--<svg xmlns="http://www.w3.org/2000/svg" width="500" height="500" viewBox="0 0 500 500" preserveAspectRatio="none" style="display: none; visibility: hidden; position: absolute; top: -100%; left: -100%;"><defs><style type="text/css"></style></defs><text x="0" y="25" style="font-weight:bold;font-size:25pt;font-family:Arial, Helvetica, Open Sans, sans-serif">500x500</text></svg></body></html>-->
