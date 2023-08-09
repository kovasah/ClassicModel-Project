<?php
declare(strict_types=1);


//connexion a la DB

try {
    $pdo = new PDO(
        'mysql:host=' . getenv('DB_HOST') . ';
        dbname=' . getenv('DB_DATABASE'),
        getenv('DB_USERNAME'),
        getenv('DB_PASSWORD')
    );

    $sql = "SELECT * FROM products LIMIT 20";

    $stmt = $pdo->query($sql);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (Exception $e) {
    print_r($e->getMessage());
}

//afficher les produits
include 'public/view/layout/header.views.php';

include 'public/view/layout/footer.views.php';

include 'public/view/layout/index.views.php';

include 'public/view/layout/singleProduct.views.php';