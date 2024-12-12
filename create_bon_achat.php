<?php
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Étape 1 : Récupérer les données du formulaire
    $fournisseur_id = $_POST['fournisseur_id'];
    $noms = $_POST['nom'];
    $references = $_POST['reference'];
    $categories = $_POST['categorie'];
    $descriptions = $_POST['description'];
    $marques = $_POST['marque_fournisseur'];
    $quantites = $_POST['quantite'];
    $prix = $_POST['prix'];
    $dates_expiration = $_POST['date_expiration'];
    $is_protheses = $_POST['is_prothese'] ?? []; // Prothèse cochée

    // Étape 2 : Calcul du montant total
    $montant_total = 0;
    foreach ($quantites as $key => $quantite) {
        $montant_total += $quantite * $prix[$key];
    }

    // Étape 3 : Insertion du bon d'achat
    $sql_bon = "INSERT INTO bon_achat (fournisseur_id, montant_total) VALUES ('$fournisseur_id', '$montant_total')";
    if ($conn->query($sql_bon) === TRUE) {
        $bon_id = $conn->insert_id; // Récupérer l'ID du bon d'achat ajouté

        // Étape 4 : Insertion des articles associés
        $sql_article = $conn->prepare("
            INSERT INTO article_bon 
            (bon_achat_id, nom, reference, categorie, description, marque_fournisseur, quantite, prix_unitaire, total, date_expiration, is_prothese) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");

        foreach ($noms as $key => $nom) {
            $reference = $references[$key];
            $categorie = $categories[$key];
            $description = $descriptions[$key];
            $marque = $marques[$key];
            $quantite = $quantites[$key];
            $prix_unitaire = $prix[$key];
            $total = $quantite * $prix_unitaire;
            $date_expiration = $dates_expiration[$key] ? $dates_expiration[$key] : NULL;
            $is_prothese = isset($is_protheses[$key]) ? 1 : 0;

            $sql_article->bind_param("isssssiddsi", $bon_id, $nom, $reference, $categorie, $description, $marque, $quantite, $prix_unitaire, $total, $date_expiration, $is_prothese);
            $sql_article->execute();
        }

        echo "Bon d'achat créé avec succès ! Numéro : $bon_id";
    } else {
        echo "Erreur lors de la création du bon d'achat : " . $conn->error;
    }
}
?>
