<!--

    Description: Generates Home Page with list of products.

-->

<?php
    require('connect.php');
    // Build and prepare SQL string.
    // A PDO::Statement is prepared from the query.
    // Execution on the DB server
    $query = "SELECT * FROM products";
    $statement = $db->prepare($query);
    $statement->execute();
    $products = $statement->fetchAll();

    include('header.php');
?>
        <h3 class=" font-weight-bold text-muted">Products</h3>
        <div class="list-group">
            <!-- Loop through the retrieved rows -->
            <?php foreach($products as $product): ?>
                <a href="show_product.php?product_id=<?= $product['product_id'] ?>" class="list-group-item list-group-item-action"><?= $product['product_name'] ?></a>
            <?php endforeach ?>
        </div>
    </main>
</body>
</html>