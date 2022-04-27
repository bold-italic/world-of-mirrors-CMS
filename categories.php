<!--

    Description: Generates Home Page with list of categories.

-->

<?php
    require('connect.php');
    // Build and prepare SQL string.
    // A PDO::Statement is prepared from the query.
    // Execution on the DB server
    $query = "SELECT * FROM categories";
    $statement = $db->prepare($query);
    $statement->execute();
    $categories = $statement->fetchAll();

    include('header.php');
?>
        <h3 class="font-weight-bold text-muted">Categories</h3>
        <div class="llist-group">
            <!-- Loop through the retrieved rows -->
            <?php foreach($categories as $category): ?>
                <a href="show_category.php?category_id=<?= $category['category_id'] ?>" class="list-group-item list-group-item-action"><?= $category['category'] ?></a>
            <?php endforeach ?>
        </div>
    </main>
</body>
</html>