<?php
include 'connection.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM utilisateurs WHERE id = " . $id;

    if ($conn->query($sql) === TRUE) {
        echo "suppression réussie.";
    } else {
        echo "Erreur lors de la suppression : " . $conn->error;
    }

    $conn->close();
    header("Location: liste_users.php");
    exit();
}
?>
