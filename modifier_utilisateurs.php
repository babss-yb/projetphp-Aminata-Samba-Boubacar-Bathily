<?php
include 'connection.php';

if (isset($_GET['id'])) {
    $id = ($_GET['id']); 
    $sql = $conn->prepare("SELECT * FROM utilisateurs WHERE id = ?");
    $sql->bind_param("i", $id);
    $sql->execute();
    $result = $sql->get_result();
    $user = $result->fetch_assoc();

    if (!$user) {
        echo "Utilisateur non trouvé.";
        exit();
    }
} else {
    echo "ID invalide.";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Modifier utilisateur</title>
</head>
<body>

<nav>
    <a href="liste_users.php">Repertoire des utilisateurs</a>
    <a href="usersadd.html">Page d'inscription</a>
</nav>

<div class="container">
    <div class="content">
        <h2>Modifier les informations</h2>
        <form action="update_utilisateurs.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= htmlspecialchars($user['id']) ?>">

            <div class="form-group">
                <label for="nom">Nom</label>
                <input type="text" id="nom" name="nom" value="<?= htmlspecialchars($user['nom']) ?>" required>
            </div>

            <div class="form-group">
                <label for="prenom">Prénom</label>
                <input type="text" id="prenom" name="prenom" value="<?= htmlspecialchars($user['prenom']) ?>" required>
            </div>

            <div class="form-group">
                <label for="login">Login</label>
                <input type="text" id="login" name="login" value="<?= htmlspecialchars($user['login']) ?>" required>
            </div>

            <div class="form-group">
                <label for="profile">Profile</label>
                <input type="file" id="profile" name="profile" required>
            </div>

             <div class="form-group">
                <label for="profile">Photo actuelle</label>
                <img src="<?= $user['profile'] ?>" width="100" alt="Photo actuelle"><br>
            </div>


            <button type="submit">Mettre à jour</button>
        </form>
    </div>
</div>

</body>
</html>