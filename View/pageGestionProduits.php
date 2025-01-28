<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Produits</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            text-align: center;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }
        .container h1 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }
        .container button {
            display: block;
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            font-size: 18px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .btn-add {
            background-color: #4CAF50;
            color: white;
        }
        .btn-add:hover {
            background-color: #45a049;
        }
        .btn-update {
            background-color: #FFA500;
            color: white;
        }
        .btn-update:hover {
            background-color: #e69500;
        }
        .btn-delete {
            background-color: #F44336;
            color: white;
        }
        .btn-delete:hover {
            background-color: #d32f2f;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Gestion des Produits</h1>
    <form action="pageCreationProduit.php" method="get">
        <button type="submit" class="btn-add">Ajouter un produit</button>
    </form>
    <form action="pageModifProduit.php" method="get">
        <button type="submit" class="btn-update">Modifier un produit</button>
    </form>
    <form action="pageSuppProduit.php" method="get">
        <button type="submit" class="btn-delete">Supprimer un produit</button>
    </form>
</div>
</body>
</html>
