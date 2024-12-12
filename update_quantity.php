<?php
include 'db-conne.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer l'ID de l'article et l'opération (add ou subtract)
    $article_id = $_POST['article_id'];
    $operation = $_POST['operation'];

    // Récupérer la quantité actuelle de l'article
    $sql = "SELECT quantite FROM article_bon WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $article_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $article = $result->fetch_assoc();

    if ($article) {
        $current_quantity = $article['quantite'];

        // Calculer la nouvelle quantité
        if ($operation == 'add') {
            $new_quantity = $current_quantity + 1;
        } elseif ($operation == 'subtract' && $current_quantity > 0) {
            $new_quantity = $current_quantity - 1;
        } else {
            // Si la quantité est déjà 0 et qu'on veut soustraire
            echo json_encode(['success' => false, 'message' => 'La quantité ne peut pas être inférieure à zéro.']);
            exit();
        }

        // Mettre à jour la base de données avec la nouvelle quantité
        $update_sql = "UPDATE article_bon SET quantite = ? WHERE id = ?";
        $stmt = $conn->prepare($update_sql);
        $stmt->bind_param("ii", $new_quantity, $article_id);
        $stmt->execute();

        // Retourner la réponse en JSON
        echo json_encode(['success' => true, 'new_quantity' => $new_quantity]);
    } else {
        // Si l'article n'existe pas
        echo json_encode(['success' => false, 'message' => 'Article introuvable.']);
    }
}
?>
