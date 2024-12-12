<?php
include 'db_conn.php';

// Récupérer les bons d'achat
$sql = "SELECT bon_achat.id, bon_achat.numero_bon, bon_achat.montant_total, bon_achat.date_creation, fournisseur.nom AS fournisseur_nom 
        FROM bon_achat 
        JOIN fournisseur ON bon_achat.fournisseur_id = fournisseur.id 
        ORDER BY bon_achat.date_creation DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1'>
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
                <td>{$row['montant_total']}</td>
                <td>{$row['date_creation']}</td>
                <td><a href='details_bon.php?id={$row['id']}'>Voir</a></td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "Aucun bon d'achat trouvé.";
}
?>
