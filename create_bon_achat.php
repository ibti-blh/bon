<?php
include 'db-conne.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Étape 1 : Récupérer les données du formulaire
    $fournisseur_id = $_POST['fournisseur_id'];
    $noms = $_POST['nom'];
    $references = $_POST['reference'];
    $categories = $_POST['categorie'];
    $descriptions = $_POST['description'];
    $quantites = $_POST['quantite'];
    $prix = $_POST['prix'];
    $dates_expiration = $_POST['date_expiration'];
    $is_protheses = $_POST['is_prothese'] ?? []; // Prothèse cochée

    // Étape 2 : Calcul du montant total
    $montant_total = 0;
    foreach ($quantites as $key => $quantite) {
        $montant_total += $quantite * $prix[$key];
    }

    // Étape 3 : Générer un numéro unique pour le bon d'achat
    $numero_bon = 'BON_' . date('YmdHis') . rand(1000, 9999);

    // Étape 4 : Insertion du bon d'achat avec une requête préparée
    $sql_bon = $conn->prepare("INSERT INTO bon_achat (numero_bon, fournisseur_id, montant_total) VALUES (?, ?, ?)");
    $sql_bon->bind_param("sii", $numero_bon, $fournisseur_id, $montant_total); // 's' pour string, 'i' pour int
    if ($sql_bon->execute()) {
        $bon_id = $conn->insert_id; // Récupérer l'ID du bon d'achat ajouté

        // Étape 5 : Insertion des articles associés
        $sql_article = $conn->prepare("
            INSERT INTO article_bon 
            (bon_achat_id, nom, reference, categorie, description, quantite, prix_unitaire, total, date_expiration, is_prothese) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        
        // Boucle pour insérer chaque article
        foreach ($noms as $key => $nom) {
            $reference = $references[$key];
            $categorie = $categories[$key];
            $description = $descriptions[$key];
            $quantite = $quantites[$key];
            $prix_unitaire = $prix[$key];
            $total = $quantite * $prix_unitaire;
            $date_expiration = $dates_expiration[$key] ? $dates_expiration[$key] : NULL;
            $is_prothese = isset($is_protheses[$key]) ? 1 : 0;

            // Binding des paramètres
            $sql_article->bind_param("isssssidds", $bon_id, $nom, $reference, $categorie, $description, $quantite, $prix_unitaire, $total, $date_expiration, $is_prothese);
            $sql_article->execute();
        }

        echo "Bon d'achat créé avec succès ! Numéro : $numero_bon";
    } else {
        echo "Erreur lors de la création du bon d'achat : " . $conn->error;
    }
}
?>
