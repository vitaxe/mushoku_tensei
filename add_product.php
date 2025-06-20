<?php
session_start();

if (empty($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require_once 'db_functions.php';

$userId = $_SESSION['user_id'];
$rows = dbSelect("SELECT role FROM users WHERE id = :id LIMIT 1", [':id' => $userId]);

if (empty($rows) || $rows[0]['role'] !== 'admin') {
    header("Location: account.php");
    exit;
}

$sqlProducts = "SELECT * FROM products";
$products = dbSelect($sqlProducts);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_product'])) {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $price = floatval($_POST['price']);
    $imageUrl = trim($_POST['image_url']);

    if (!empty($name) && !empty($description) && $price > 0 && !empty($imageUrl)) {
        if (!empty($_POST['product_id'])) {
            $productId = (int)$_POST['product_id'];
            dbQuery("UPDATE products SET name = :name, description = :description, price = :price, image_url = :image_url WHERE id = :id", [
                ':name' => $name,
                ':description' => $description,
                ':price' => $price,
                ':image_url' => $imageUrl,
                ':id' => $productId
            ]);
        } else {
            dbInsert("INSERT INTO products (name, description, price, image_url) VALUES (:name, :description, :price, :image_url)", [
                ':name' => $name,
                ':description' => $description,
                ':price' => $price,
                ':image_url' => $imageUrl
            ]);
        }

        header("Location: add_product.php");
        exit;
    } else {
        $error = "Пожалуйста, заполните все поля корректно.";
    }
}

$editProduct = null;
if (isset($_GET['id'])) {
    $editProduct = dbSelect("SELECT * FROM products WHERE id = :id LIMIT 1", [':id' => (int)$_GET['id']]);
    $editProduct = $editProduct ? $editProduct[0] : null;
}

if (isset($_GET['delete_id'])) {
    dbQuery("DELETE FROM products WHERE id = :id", [':id' => (int)$_GET['delete_id']]);
    header("Location: add_product.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добавить товар</title>
    <!-- Подключение Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEJr+MQX0r4HU2v8wP5g8cFf8Xg+7JfbT0OryhpmVEn7E5Cxw6cxH2kmYfqJb" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500&family=Mak:wght@700&display=swap" rel="stylesheet">
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="./index.php"><img src="./image/logo.svg" alt="логотип сайта" height="40"></a>
                
                <!-- Навигационное меню -->
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="add-books.php">Добавить книгу</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="users.php">Управление пользователями</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="add-story.php">Добавить серию</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="add_product.php">Добавить товар</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="add-orders.php">Обработка заказов</a>
                    </li>
                </ul>

                <div class="account">
                    <a href="./account.php"><img src="./image/account.svg" alt="аккаунт" height="30"></a>
                </div>
            </div>
        </nav>
    </header>
<main class="container mt-5">
    <h1 class="mb-4"><?= isset($editProduct) ? 'Редактировать товар' : 'Добавить товар' ?></h1>

    <section class="mb-5">
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form method="POST">
            <?php if (isset($editProduct)): ?>
                <input type="hidden" name="product_id" value="<?= $editProduct['id'] ?>">
            <?php endif; ?>
            <div class="mb-3">
                <label class="form-label">Название</label>
                <input type="text" name="name" class="form-control" value="<?= $editProduct['name'] ?? '' ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Описание</label>
                <textarea name="description" class="form-control" rows="4" required><?= $editProduct['description'] ?? '' ?></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Цена</label>
                <input type="number" step="0.01" name="price" class="form-control" value="<?= $editProduct['price'] ?? '' ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Ссылка на изображение</label>
                <input type="url" name="image_url" class="form-control" value="<?= $editProduct['image_url'] ?? '' ?>" required>
            </div>
            <button type="submit" class="btn btn-primary" name="add_product"><?= isset($editProduct) ? 'Сохранить' : 'Добавить' ?></button>
        </form>
    </section>

    <section>
        <h2 class="h4 mb-3">Список товаров</h2>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Название</th>
                    <th>Описание</th>
                    <th>Цена</th>
                    <th>Изображение</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?= htmlspecialchars($product['name']) ?></td>
                        <td><?= htmlspecialchars($product['description']) ?></td>
                        <td><?= number_format($product['price'], 2) ?> ₽</td>
                        <td><img src="<?= htmlspecialchars($product['image_url']) ?>" width="80"></td>
                        <td>
                            <a href="?id=<?= $product['id'] ?>" class="btn btn-warning btn-sm">Редактировать</a>
                            <a href="?delete_id=<?= $product['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Удалить товар?')">Удалить</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
