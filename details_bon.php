<?php
include 'db-conne.php';

$bon_id = $_GET['id']; // Récupérer l'ID du bon d'achat

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
       
        <th>Modifier Quantité</th>
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
           
            <td>
                <!-- Boutons pour AJAX -->
                <button class="modify-quantity" data-id="<?= $article['id'] ?>" data-operation="add">+</button>
                <button class="modify-quantity" data-id="<?= $article['id'] ?>" data-operation="subtract">-</button>
            </td>
        </tr>
    <?php } ?>
</table>
<script>
// Attendre que le DOM soit chargé avant d'ajouter les événements
document.addEventListener('DOMContentLoaded', function() {
    const buttons = document.querySelectorAll('.modify-quantity');

    buttons.forEach(button => {
        button.addEventListener('click', function() {
            const articleId = this.getAttribute('data-id');
            const operation = this.getAttribute('data-operation');

            // Créer un objet de données pour l'envoi
            const data = new FormData();
            data.append('article_id', articleId);
            data.append('operation', operation);

            // Initialiser la requête AJAX
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'update_quantity.php', true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // Réponse en JSON avec la nouvelle quantité
                    const response = JSON.parse(xhr.responseText);

                    if (response.success) {
                        // Mettre à jour la quantité affichée dans le tableau
                        const row = document.getElementById('article-' + articleId);
                        row.querySelector('.quantity').textContent = response.new_quantity;
                    } else {
                        alert('Erreur: ' + response.message);
                    }
                }
            };

            // Envoyer la requête
            xhr.send(data);
        });
    });
});
</script>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
          <link rel="stylesheet" href="details.css">