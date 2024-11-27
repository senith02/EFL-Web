<?php
$conn = new mysqli('localhost', 'root', '', 'web_assignment');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$result = $conn->query("SELECT * FROM products");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_id'])) {
    $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    $stmt->bind_param("i", $_POST['delete_id']);
    $stmt->execute();
    $stmt->close();
    header("Location: products_list.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="styles.css">
    <title>Products</title>
</head>
<body>
<div class="container">
    <h2>Products</h2>
    <a href="add_product.php">Add Product</a>
    <table>
        <tr>
            <th>Name</th>
            <th>Category</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Description</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) : ?>
            <tr>
                <td><?= $row['name'] ?></td>
                <td><?= $row['category'] ?></td>
                <td><?= $row['price'] ?></td>
                <td><?= $row['quantity'] ?></td>
                <td><?= $row['description'] ?></td>
                <td>
                    <a href="edit_product.php?id=<?= $row['id'] ?>">Edit</a>
                    <form method="post" style="display:inline;">
                        <input type="hidden" name="delete_id" value="<?= $row['id'] ?>">
                        <button type="submit" onclick="return confirm('Delete this product?');">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</div>
</body>
</html>
