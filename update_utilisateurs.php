<?php
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = intval($_POST['id']);
    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];
    $login = $_POST["login"];

    
    if (!empty($_FILES["profile"]["name"])) {
        $target_dir = "photos/"; 
        $target_file = $target_dir . basename($_FILES["profile"]["name"]);

        // Vérifier et déplacer l’image
        if (move_uploaded_file($_FILES["profile"]["tmp_name"], $target_file)) {
            $profile = $target_file;
        } else {
            echo "Erreur lors de l’upload.";
            exit();
        }
    } else {
        
        $sql = $conn->prepare("SELECT profile FROM utilisateurs WHERE id = ?");
        $sql->bind_param("i", $id);
        $sql->execute();
        $result = $sql->get_result();
        $row = $result->fetch_assoc();
        $profile = $row['profile'];
    }

    
    $sql = $conn->prepare("UPDATE utilisateurs SET nom = ?, prenom = ?,login = ?, profile = ? WHERE id = ?");
    $sql->bind_param("ssssi", $nom, $prenom, $login , $profile, $id);

    if ($sql->execute()) {
        echo "<script>alert('Mise à jour réussie !'); window.location.href='liste_users.php';</script>";
    } else {
        echo "Erreur lors de la mise à jour : " . $conn->error;
    }

    $sql->close();
    $conn->close();
}
?>