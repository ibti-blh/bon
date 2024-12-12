<?php
include 'db-conne.php'; 

// Récupérer les fournisseurs dans un tableau
$fournisseurs = [];
$result = $conn->query("SELECT id, nom FROM fournisseur");
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $fournisseurs[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un Bon d'Achat</title>
     <!-- font awesome cdn link  -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- bootstrap cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.1/css/bootstrap.min.css">
    <!-- custom css file link  -->
          <link rel="stylesheet" href="bon.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: flex-start; /* Alignement du contenu en haut */
            height: 100vh;
            padding-top: 180px; /* Ajout d'une marge pour déplacer le formulaire vers le bas */
        }
        .form-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 800px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        label {
            font-weight: bold;
        }
        .input-group {
            margin-bottom: 15px;
        }
        .input-group input,
        .input-group select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
        .input-group select {
            cursor: pointer;
        }
        .input-group input[type="checkbox"] {
            width: auto;
            display: inline-block;
        }
        .add-article-btn {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
        }
        .add-article-btn:hover {
            background-color: #218838;
        }
        .submit-btn {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
        }
        .submit-btn:hover {
            background-color: #0056b3;
        }
        .total-section {
            margin-top: 30px;
            font-size: 18px;
            text-align: right;
        }
    </style>
</head>
<body>
    <!-- Side Navigation -->

<div id="side-nav" class="side-nav">
  <div class="user">
  <!-- Icône utilisateur -->
  <i class="fas fa-user-circle user-icon"></i>
  <!-- Image utilisateur -->
  <img src="image/midoune.jpg" alt="Utilisateur" class="user-img">
  <div>
    <h2>midoune</h2>
    <p>midoune@gmail.com</p>
  </div>
</div>
  <a href="javascript:void(0)" class="close-btn" onclick="closeSideNav()">&times;</a>
 
  <a href="../client/index.php">
    <i class="fas fa-users"></i> Page de clients
  </a>
  <a href="./index.php">
    <i class="fas fa-box-open"></i> Pages de produits
  </a>
  <a href="products.php">
    <i class="fas fa-tooth"></i> Pages de prothèses
  </a>
  <a href="../fournisseur/suppliers.php">
    <i class="fas fa-truck"></i> Fournisseur
  </a>
  <a href="bonds.php">
    <i class="fas fa-file-invoice-dollar"></i> Bon d'achat
  </a>
  <a href="logout.php">
    <i class="fas fa-sign-out-alt"></i> Déconnexion
  </a>


 
</div>


<!-- Overlay -->
<div id="overlay" class="overlay" onclick="closeSideNav()"></div>


  <header class="header fixed-top">

    <div class="container">

      <div class="row align-items-center justify-content-between">
        <div><img src="tooth.png" alt="logo">

          <a href="#home" class="logo">Cabinet<span>Plus</span></a>
        </div>

        <nav class="nav">
          <a href="#home">Accueil</a>
          <a href="#about">About</a>
          <a href="#review">Revues</a>
          <a href="../page-dent/Calendrier/calendrier/calendar.html">Caldenrier</a>
          <a href="#contact">Contact</a>
        
        </nav>
        <button class="link-btn">Connexion</button>
        
        </div>
      <!-- Icone du menu hamburger -->
      <span class="open-btn" onclick="openSideNav()">&#9776;</span>
      </div>
  </header>
  <!-- header section ends -->

    <div class="form-container">
        <h1>Créer un Bon d'Achat</h1>
        <form method="POST" action="create_bon_achat.php">
                        <!-- Fournisseur principal -->
                        <div class="input-group">
                            <label for="fournisseur">Fournisseur Principal :</label>
                            <select name="fournisseur_id" required>
                                <option value="">-- Sélectionnez un fournisseur principal --</option>
                                <?php foreach ($fournisseurs as $fournisseur): ?>
                                    <option value="<?= htmlspecialchars($fournisseur['id']) ?>">
                                        <?= htmlspecialchars($fournisseur['nom']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

            <!-- Articles -->
            <div id="articles">
                <div class="article">
                    <div class="input-group">
                        <label for="nom">Nom du Produit :</label>
                        <input type="text" name="nom[]" placeholder="Nom du Produit" required>
                    </div>
                    <div class="input-group">
                        <label for="reference">Référence :</label>
                        <input type="text" name="reference[]" placeholder="Référence">
                    </div>
                    <div class="input-group">
                        <label for="categorie">Catégorie :</label>
                        <select name="categorie[]" required>
                            <option value="">-- Sélectionnez une catégorie --</option>
                            <option value="prothese">Prothèse</option>
                            <option value="outils">Outils Dentaires</option>
                            <option value="materiel">Matériel Médical</option>
                        </select>
                    </div>
                    <div class="input-group">
                        <label for="description">Description :</label>
                        <input type="text" name="description[]" placeholder="Description">
                    </div>
                    <div class="input-group">
                        <label for="quantite">Quantité :</label>
                        <input type="number" name="quantite[]" placeholder="Quantité" required oninput="calculateTotal()">
                    </div>
                    <div class="input-group">
                        <label for="prix">Prix Unitaire :</label>
                        <input type="number" step="0.01" name="prix[]" placeholder="Prix Unitaire" required oninput="calculateTotal()">
                    </div>
                    <div class="input-group">
                        <label for="date_expiration">Date d'Expiration :</label>
                        <input type="date" name="date_expiration[]">
                    </div>
                    
                     <!-- Liste déroulante pour le fournisseur spécifique -->
                     <div class="input-group">
                        <label for="fournisseur_article">Fournisseur :</label>
                        <select name="fournisseur_article[]">
                            <option value="">-- Sélectionnez un fournisseur --</option>
                            <?php foreach ($fournisseurs as $fournisseur): ?>
                                <option value="<?= htmlspecialchars($fournisseur['id']) ?>">
                                    <?= htmlspecialchars($fournisseur['nom']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>

            <button type="button" class="add-article-btn" onclick="addArticle()">Ajouter un Article</button>

           

            <!-- Section Paiement -->
            <div class="input-group">
                <label for="mode_paiement">Mode de Paiement :</label>
                <select name="mode_paiement" required>
                    <option value="">-- Sélectionnez un mode de paiement --</option>
                    <option value="carte_bancaire">Carte Bancaire</option>
                    <option value="virement">Virement</option>
                    <option value="cheque">Chèque</option>
                </select>
            </div>

            <div class="input-group">
                <label for="montant_paiement">Montant Total :</label>
                <input type="number" step="0.01" name="montant_paiement" id="montant_paiement" required readonly>
            </div>

            <!-- Validation -->
            <button type="submit" class="submit-btn">Créer Bon d'Achat</button>
        </form>
    </div>

    <script>
        function addArticle() {
            const articlesDiv = document.getElementById('articles');
            const newArticle = document.querySelector('.article').cloneNode(true);
            newArticle.querySelectorAll('input, select').forEach(input => input.value = '');
            articlesDiv.appendChild(newArticle);
        }

        // Fonction pour calculer le montant total
        function calculateTotal() {
            const quantites = document.querySelectorAll('input[name="quantite[]"]');
            const prixUnitaires = document.querySelectorAll('input[name="prix[]"]');
            let total = 0;

            for (let i = 0; i < quantites.length; i++) {
                const quantite = parseFloat(quantites[i].value) || 0;
                const prixUnitaire = parseFloat(prixUnitaires[i].value) || 0;
                total += quantite * prixUnitaire;
            }

            // Afficher le montant total
            document.getElementById('total').textContent = `Montant Total: ${total.toFixed(2)}`;
            document.getElementById('montant_paiement').value = total.toFixed(2);
        }
    </script>
    <!-- Script Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
            integrity="sha384-YvpcrYf0/Yosjhf5VxqfGgI2T3Ybh+GkJt6+8zFgfYJ9UpqYjzMxBdXquHv8xNjw7" 
            crossorigin="anonymous"></script>
      </main>
      <script src="bon.js"></script>
</body>
</html>
