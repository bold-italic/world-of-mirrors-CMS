<!--

    Description: Generates a list of products associated with a particular category.

-->

<?php
    require('connect.php');
    // Ensure that any category_id values passed by the user are validated as integers
    $category_id = filter_input(INPUT_GET, 'category_id', FILTER_VALIDATE_INT);
    if ($category_id) {
        // Build and prepare SQL String with :category_id placeholder parameter
        // Bind the :category_id parameter in the query to the sanitized
        // $category_id specifying a binding-type of Integer
        // Fetch the row selected by primary key category_id
        $query = "SELECT * FROM products WHERE category_id = :category_id";
        $statement = $db->prepare($query);
        $statement->bindValue(':category_id', $category_id, PDO::PARAM_INT);
        $statement->execute();
        $products = $statement->fetchAll();
        // Redirect to Categories page if category_id is not valid
    }   else {
            header("Location: categories.php");
            exit;
        }
        
    include('header.php');  
?>
        <h3 class="font-weight-bold text-muted">Products</h3>
        <div class="list-group">
            <!-- Output a list of products associated with a particular category -->
            <?php foreach($products as $product): ?>
                <a href="show_product.php?product_id=<?= $product['product_id'] ?>" class="list-group-item list-group-item-action"><?= $product['product_name'] ?></a>
            <?php endforeach ?>
        </div>
    </main>
</body>
</html>