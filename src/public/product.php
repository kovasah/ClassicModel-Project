<?php
declare(strict_types=1);

session_start();

try {
    // 1 - Connexion à la DB
    require_once 'public/db/connection.php';

    // 2 - Récupérer le produit

    $stmt = $pdo->prepare("SELECT * FROM products WHERE productCode = :code");
    $stmt->bindParam(":code", $_GET['productCode']);
    $stmt->execute();

    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if (empty($product)) {
        echo '404 - no product found';
        die;
    }

    // 3 - Afficher la page
    include 'public/view/layout/header.views.php';
    include 'public/view/layout/singleProduct.views.php';
    include 'public/view/layout/footer.views.php';

} catch (Exception $e) {
    print_r($e->getMessage());
}