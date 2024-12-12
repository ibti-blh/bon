<?php
include 'db-conne.php';

// Récupérer les bons d'achat
$sql = "SELECT bon_achat.id, bon_achat.numero_bon, bon_achat.montant_total, bon_achat.date_creation, fournisseur.nom AS fournisseur_nom 
        FROM bon_achat 
        JOIN fournisseur ON bon_achat.fournisseur_id = fournisseur.id 
        ORDER BY bon_achat.date_creation DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1' class='table'>
            <tr>
                <th>Numéro</th>
                <th>Fournisseur</th>
                <th>Montant Total</th>
                <th>Date de Création</th>
                <th>Détails</th>
            </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['numero_bon']}</td>
                <td>{$row['fournisseur_nom']}</td>
                <td>{$row['montant_total']} €</td>
                <td>{$row['date_creation']}</td>
                <td><a href='details_bon.php?id={$row['id']}' class='btn btn-info'>Voir</a></td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<p>Aucun bon d'achat trouvé.</p>";
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Bons d'Achat</title>
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Bootstrap CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.1/css/bootstrap.min.css">
    <!-- Custom CSS file link -->
    <link rel="stylesheet" href="bon.css">
</head>
<body>

<!-- Side Navigation -->
<div id="side-nav" class="side-nav">
  <div class="user">
    <i class="fas fa-user-circle user-icon"></i>
    <img src="image/midoune.jpg" alt="Utilisateur" class="user-img">
    <div>
      <h2>midoune</h2>
      <p>midoune@gmail.com</p>
    </div>
  </div>
  <a href="javascript:void(0)" class="close-btn" onclick="closeSideNav()">&times;</a>
  <a href="../client/index.php"><i class="fas fa-users"></i> Page de clients</a>
  <a href="./index.php"><i class="fas fa-box-open"></i> Pages de produits</a>
  <a href="products.php"><i class="fas fa-tooth"></i> Pages de prothèses</a>
  <a href="../fournisseur/suppliers.php"><i class="fas fa-truck"></i> Fournisseur</a>
  <a href="bonds.php"><i class="fas fa-file-invoice-dollar"></i> Bon d'achat</a>
  <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Déconnexion</a>
</div>

<!-- Overlay -->
<div id="overlay" class="overlay" onclick="closeSideNav()"></div>

<!-- Header Section -->
<header class="header fixed-top">
  <div class="container">
    <div class="row align-items-center justify-content-between">
      <div>
        <img src="tooth.png" alt="logo">
        <a href="#home" class="logo">Cabinet<span>Plus</span></a>
      </div>
      <nav class="nav">
        <a href="#home">Accueil</a>
        <a href="#about">About</a>
        <a href="#review">Revues</a>
        <a href="../page-dent/Calendrier/calendrier/calendar.html">Calendrier</a>
        <a href="#contact">Contact</a>
      </nav>
      <button class="link-btn">Connexion</button>
    </div>
    <span class="open-btn" onclick="openSideNav()">&#9776;</span>
  </div>
</header>

<!-- Bootstrap and Custom JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0/Yosjhf5VxqfGgI2T3Ybh+GkJt6+8zFgfYJ9UpqYjzMxBdXquHv8xNjw7" crossorigin="anonymous"></script>
<script src="bon.js"></script>
</body>
</html>
