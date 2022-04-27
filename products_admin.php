<!--

    Description: Generates a page with list of products for an admin role.

-->

<?php
    require('connect.php');
    // Add authentication script
    require 'authenticate.php';
    // Sorting algorithms.
    if (isset($_POST['product_name'])) {
        $query = "SELECT * FROM products ORDER BY product_name";
        $color_product_name = "active";
        $color_product_created_date = "";
        $color_product_updated_date = "";
    }   elseif (isset($_POST['product_created_date'])) {
            $query = "SELECT * FROM products ORDER BY product_created_date";
            $color_product_name = "";
            $color_product_created_date = "active";
            $color_product_updated_date = "";
        }   elseif (isset($_POST['product_updated_date'])) {
            $query = "SELECT * FROM products ORDER BY product_updated_date DESC";
            $color_product_name = "";
            $color_product_created_date = "";
            $color_product_updated_date = "active";
            }   else {
                    $query = "SELECT * FROM products";
                }
    $statement = $db->prepare($query);
    $statement->execute();
    $products = $statement->fetchAll();

    include('header.php');
?>
        <h3 class="font-weight-bold text-muted">Edit Products</h3>
        <form id="sort_products" action="products_admin.php" method="post">
            <div>
                <div class="text-secondary font-weight-bold">Sort by:</div>
                <button type="submit" class="btn btn-outline-primary btn-sm my-2 mr-1 <?= $color_product_name ?>" name="product_name">Product Name</button>
                <button type="submit" class="btn btn-outline-primary btn-sm my-2 mr-1 <?= $color_product_created_date ?>" name="product_created_date">Created Date</button>
                <button type="submit" class="btn btn-outline-primary btn-sm my-2 <?= $color_product_updated_date ?>" name="product_updated_date">Updated Date</button>
            </div>
        </form>

        <div class="list-group">
            <!-- Loop through the retrieved rows -->
            <?php foreach($products as $product): ?>
                <a href="edit_product.php?product_id=<?= $product['product_id'] ?>" class="list-group-item list-group-item-action"><?= $product['product_name'] ?></a>
            <?php endforeach ?>
        </div>
        <p>
            <a href="create_product.php" class="btn btn-primary btn-sm mr-sm-2 mt-3" role="button" aria-pressed="true">New Product</a>
        </p>
    </main>
</body>
</html>