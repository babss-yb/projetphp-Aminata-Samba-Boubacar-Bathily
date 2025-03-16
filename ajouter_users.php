<?php 
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST["name"];
    $prenom = $_POST["prenom"];
    $mdp = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $login = $_POST["login"];
    
    $photo = "photos/fleur-de-lys-blanc.jpg"; 

    if (!empty($_FILES["profile"]["name"])) {
        $target_dir = "photos/";
        $target_file = $target_dir . basename($_FILES["profile"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        
        $check = getimagesize($_FILES["profile"]["tmp_name"]);
        if ($check !== false) {
            if (move_uploaded_file($_FILES["profile"]["tmp_name"], $target_file)) {
                $photo = $target_file;
            }
        }
    }

    $sql = "INSERT INTO utilisateurs (id, nom, prenom, login, password, profile) 
            VALUES (UUID(), '$nom', '$prenom', '$login', '$mdp', '$photo')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Utilisateur ajouté avec succès !'); window.location.href='usersadd.html';</script>";
    } else {
        echo "Erreur lors de l'ajout de l'utilisateur : " . $conn->error;
    }

    $conn->close();
}
?>