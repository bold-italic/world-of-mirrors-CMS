<!--

    Description: Generates Home Page with list of products associated with search result.

-->

<?php
    require('connect.php');
    if (isset($_POST['submit']) && (!empty($_POST['keyword']) || $_POST['keyword'] == 0)) {
        // Sanitize user input to escape HTML sections and filter out dangerous characters
        $keyword = filter_input(INPUT_POST, 'keyword', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $query = "SELECT * FROM products WHERE product_name LIKE :keyword OR product_shape LIKE :keyword OR product_frame LIKE :keyword OR product_description LIKE :keyword";
        $search_statement = $db->prepare($query);
        $search_statement->bindValue(':keyword', '%' . $keyword . '%', PDO::PARAM_STR); 
        $search_statement->execute();
        // Redirect to index.php page if variables are not valid
    }   else {
            header("Location: index.php");
            exit;
        }

    include('header.php');
?>
        <h3 class="font-weight-bold text-muted">Search</h3>
        <p class="text-secondary font-weight-bold">Found <?= $search_statement->rowCount() ?> Products</p>
        <div class="list-group">
            <!-- Loop through the retrieved rows -->
            <?php while($row = $search_statement->fetch()): ?>
                <a href="show_product.php?product_id=<?= $row['product_id'] ?>" class="list-group-item list-group-item-action"><?= $row['product_name'] ?></a>
            <?php endwhile ?>
        </div>
    </main>
</body>
</html>