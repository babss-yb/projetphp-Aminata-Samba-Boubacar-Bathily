<?php
include 'connection.php';


if (!$conn) {
    die("Erreur de connexion : " . mysqli_connect_error());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des utilisateurs</title>
    <link rel="stylesheet" href="style2.css"> 
    <style>
        .icon {
            width: 20px;
            height: 20px;
            margin: 0 5px;
        }
        .profile-pic {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
        }
    </style>
</head>
<body>
    <nav>
        <a href="liste_users.php">Répertoire des utilisateurs</a>
        <a href="usersadd.html">Page d'inscription</a>
    </nav>

    <div class="container">
        <div class="content">
            <h2>Profils inscrits</h2>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Login</th>
                        <th>Profile</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Requête SQL
                    $sql = "SELECT id, nom, prenom, login, profile FROM utilisateurs"; 
                    $result = mysqli_query($conn, $sql);

                    if ($result && mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            
                            $photo = !empty($row["profile"]) ? $row["profile"] : "photos/default.png";

                            
                            if (!file_exists($photo)) {
                                $photo = "photos/default.png"; 
                            }

                            
                            echo "<tr>
                                    <td>{$row["id"]}</td>
                                    <td>" . ucfirst(htmlspecialchars($row["nom"])) . "</td>
                                    <td>" . ucfirst(htmlspecialchars($row["prenom"])) . "</td>
                                    <td>{$row["login"]}</td>
                                    <td><img src='" . htmlspecialchars($photo) . "' class='profile-pic' alt='Photo'></td>
                                    <td>
                                        <a href='modifier_utilisateurs.php?id={$row["id"]}'>
                                            <img src='https://cdn-icons-png.flaticon.com/512/1159/1159633.png' alt='Modifier' class='icon'>
                                        </a>
                                        |
                                        <a href='delete_utilisateurs.php?id={$row["id"]}' 
                                           onclick='return confirm(\"Voulez-vous vraiment supprimer cet utilisateur ?\");'>
                                            <img src='https://cdn-icons-png.flaticon.com/512/6861/6861362.png' alt='Supprimer' class='icon'>
                                        </a>
                                    </td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>Aucun utilisateur trouvé</td></tr>";
                    }
                    mysqli_close($conn);
                    ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>