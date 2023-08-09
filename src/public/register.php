<?php
declare(strict_types=1);

session_start();

if (empty($_POST)) {
    // 1 - Afficher le formulaire

    include 'public/view/layout/header.views.php';
    include 'public/view/layout/register.view.php';
    include 'public/view/layout/footer.views.php';
} else {
    try {
        // 2 - Connexion à la DB
        require_once 'public/db/connection.php';

        // 3 - Vérification des données
        // 3.1 - Pas vides ?
        if (empty($_POST['username']) || empty($_POST['email']) || empty($_POST['password'])) {
            throw new Exception('Formulaire non complet');
        }

        // 3.2 - Pas d'injection SQL ?
        $username = htmlspecialchars($_POST['username']);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

        // 4 - Hasher le mot de passe
        $passwordHash = password_hash($_POST['password'], PASSWORD_DEFAULT);

        // 5 - Ajout à la base de données
        $stmt = $pdo->prepare("
            INSERT INTO users (username, email, password) 
            VALUES (:username, :email, :password)"
        );
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $passwordHash);

        $stmt->execute();

        // 6 - Connexion automatique
        $_SESSION['user'] = [
            'id' => $pdo->lastInsertId(),
            'username' => $username,
            'email' => $email
        ];

        // Redirect to home page
        http_response_code(302);
        header('location: index.php');
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}