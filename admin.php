<!--

    Description: Generates a list of products and categories links for an admin role.

-->

<?php
    // Add authentication script
    require 'authenticate.php';
    require('connect.php');
    include('header.php');
?>
        <h3 class="font-weight-bold text-muted">Admin</h3>
        <div class="list-group">
            <a href="products_admin.php" class="list-group-item list-group-item-action">Products</a>
            <a href="categories_admin.php" class="list-group-item list-group-item-action">Categories</a>
        </div>
    </main>
</body>
</html>