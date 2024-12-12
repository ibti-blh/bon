<?php
include 'db_conn.php';

$bon_id = $_GET['id'];

// Informations du bon d'achat
$sql_bon = "SELECT bon_achat.numero_bon, bon_achat.montant_total, bon_achat.date_creation, fournisseur.nom AS fournisseur_nom 
            FROM bon_achat 
            JOIN fournisseur ON bon_achat.fournisseur_id = fournisseur.id 
            WHERE bon_achat.id = $bon_id";
$result_bon = $conn->query($sql_bon);
$bon = $result_bon->fetch_assoc();

// Articles du bon d'achat
$sql_articles = "SELECT * FROM article_bon WHERE bon_achat_id = $bon_id";
$result_articles = $conn->query($sql_articles);
?>

<h2>Détails du Bon d'Achat</h2>
<p><strong>Numéro :</strong> <?= $bon['numero_bon'] ?></p>
<p><strong>Fournisseur :</strong> <?= $bon['fournisseur_nom'] ?></p>
<p><strong>Montant Total :</strong> <?= $bon['montant_total'] ?> €</p>
<p><strong>Date :</strong> <?= $bon['date_creation'] ?></p>

<h3>Articles</h3>
<table border="1">
    <tr>
        <th>Nom</th>
        <th>Référence</th>
        <th>Catégorie</th>
        <th>Description</th>
        <th>Quantité</th>
        <th>Prix Unitaire</th>
        <th>Total</th>
        <th>Prothèse</th>
    </tr>
    <?php while ($article = $result_articles->fetch_assoc()) { ?>
        <tr>
            <td><?= $article['nom'] ?></td>
            <td><?= $article['reference'] ?></td>
            <td><?= $article['categorie'] ?></td>
            <td><?= $article['description'] ?></td>
            <td><?= $article['quantite'] ?></td>
            <td><?= $article['prix_unitaire'] ?> €</td>
            <td><?= $article['total'] ?> €</td>
            <td><?= $article['is_prothese'] ? 'Oui' : 'Non' ?></td>
        </tr>
    <?php } ?>
</table>
