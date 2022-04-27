<!--

    Description: Generates a page with list of categories for an admin role.

-->

<?php
    require('connect.php');
    // Add authentication script
    require 'authenticate.php';
    // Build and prepare SQL string.
    // A PDO::Statement is prepared from the query.
    // Execution on the DB server
    $query = "SELECT * FROM categories";
    $statement = $db->prepare($query);
    $statement->execute();
    $categories = $statement->fetchAll();

    include('header.php');
?>
        <h3 class="font-weight-bold text-muted">Edit Categories</h3>
        <div class="list-group">
            <!-- Loop through the retrieved rows -->
            <?php foreach($categories as $category): ?>
                <a href="edit_category.php?category_id=<?= $category['category_id'] ?>" class="list-group-item list-group-item-action"><?= $category['category'] ?></a>
            <?php endforeach ?>
        </div>
        <p>
            <a href="create_category.php" class="btn btn-primary btn-sm mr-sm-2 mt-3" role="button" aria-pressed="true">New Category</a>
        </p>
    </main>
</body>
</html>