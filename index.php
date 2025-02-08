<?php
require 'db.php';

// Handle create operation
if (isset($_POST['add'])) {
    $id = $_POST['id'];
    $nom = $_POST['nom'];

    $stmt = $conn->prepare("INSERT INTO data (id, nom) VALUES (:id, :nom)");
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':nom', $nom);
    $stmt->execute();
}

// Handle delete operation
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    
    // Confirmation de la suppression
    echo "<script>";
    echo "if(confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')) {";
    echo "  window.location.href='index.php?confirmed_delete=$id';";
    echo "} else {";
    echo "  window.location.href='index.php';";
    echo "}";
    echo "</script>";
}

// Supprimer l'utilisateur confirmé
if (isset($_GET['confirmed_delete'])) {
    $id = $_GET['confirmed_delete'];
    $stmt = $conn->prepare("DELETE FROM data WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
}

// Handle update operation
if (isset($_POST['update'])) {
    $old_id = $_POST['old_id'];
    $new_id = $_POST['id'];
    $nom = $_POST['nom'];

    $stmt = $conn->prepare("UPDATE data SET id = :new_id, nom = :nom WHERE id = :old_id");
    $stmt->bindParam(':new_id', $new_id);
    $stmt->bindParam(':old_id', $old_id);
    $stmt->bindParam(':nom', $nom);
    $stmt->execute();
}

// Retrieve all users
// $stmt = $conn->prepare("SELECT * FROM data");
// $stmt->execute();
// $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
// ?>

<!DOCTYPE html>
<html>
<head>
    <title>Administration des utilisateurs</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 20px;
        }
        h1 {
            color: #333;
        }
        form {
            margin-bottom: 20px;
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        form input[type="text"], form button {
            padding: 10px;
            margin: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        form button {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        form button:hover {
            background-color: #45a049;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        table, th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        td a {
            text-decoration: none;
            color: #007BFF;
            padding: 5px 10px;
            border: 1px solid #007BFF;
            border-radius: 5px;
        }
        td a:hover {
            background-color: #007BFF;
            color: white;
        }
        .edit-form {
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h1>Administration des utilisateurs</h1>
    
    <h2>Ajout d'utilisateur</h2>
    <form method="POST" action="index.php">
        <input type="text" name="id" placeholder="ID" maxlength="10" required>
        <input type="text" name="nom" placeholder="Nom" required>
        <button type="submit" name="add">ajouter</button>
    </form>
    
    <h2>Liste des utilisateur</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>OPTIONS</th>
        </tr>
        <?php foreach ($users as $user): ?>
        <tr>
            <td><?php echo $user['id']; ?></td>
            <td><?php echo $user['nom']; ?></td>
            <td>
                <a href="index.php?edit=<?php echo $user['id']; ?>">modifier</a>
                <a href="index.php?delete=<?php echo $user['id']; ?>">supprimer</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    
    <?php if (isset($_GET['edit'])): 
        $id = $_GET['edit'];
        $stmt = $conn->prepare("SELECT * FROM data WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    ?>
    <h2>Edit User</h2>
    <form method="POST" action="index.php">
        <input type="hidden" name="old_id" value="<?php echo $user['id']; ?>">
        <input type="text" name="id" value="<?php echo $user['id']; ?>" placeholder="ID" maxlength="10" required>
        <input type="text" name="nom" value="<?php echo $user['nom']; ?>" placeholder="Nom" required>
        <
        <button type="submit" name="update">confirmer</button>
    </form>
    <?php endif; ?>
</body>
</html>
