<?php
$servername = "data"; // Nom du service MariaDB dans Docker
$username = "root";
$password = "password"; // Changez-le selon votre configuration
$dbname = "testdb";

// Connexion à MariaDB
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Créer une table si elle n'existe pas
$sql = "CREATE TABLE IF NOT EXISTS visitors (id INT AUTO_INCREMENT PRIMARY KEY, name VARCHAR(255), visit_time TIMESTAMP)";
$conn->query($sql);

// Insérer une nouvelle ligne à chaque rafraîchissement
$name = "Visiteur " . rand(1, 1000);
$sql = "INSERT INTO visitors (name, visit_time) VALUES ('$name', NOW())";
$conn->query($sql);

// Lire les 5 dernières entrées
$sql = "SELECT * FROM visitors ORDER BY visit_time DESC LIMIT 5";
$result = $conn->query($sql);

// Afficher les résultats
echo "<h2>Dernières visites :</h2>";
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "ID: " . $row["id"]. " - Name: " . $row["name"]. " - Visit Time: " . $row["visit_time"]. "<br>";
    }
} else {
    echo "0 résultats";
}

$conn->close();
?>
