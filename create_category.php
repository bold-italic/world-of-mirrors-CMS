<!--

    Description: New category form creation.

-->

<?php
    require('connect.php');
    // Add authentication script
    require 'authenticate.php';
    // CREATE category if category was presented in POST, and "Create Category" button was pressed
    if (isset($_POST['create']) && (!empty($_POST['category']) || $_POST['category'] == 0)) {
        // Sanitize user input to escape HTML sections and filter out dangerous characters
        $category = filter_input(INPUT_POST, 'category', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        // Build the parameterized SQL query and bind to the above sanitized values
        $query = "INSERT INTO categories (category) VALUES (:category)";
        $statement = $db->prepare($query);
        $statement->bindValue(':category', $category);
        $statement->execute();
        // Redirect to categories_admin.php page if variables are valid
        header("Location: categories_admin.php");
        exit;
    }

    include('header.php');   
?>
    <script src="createEditCategoryValidate.js"></script>
        <h3 class="font-weight-bold text-muted">New Category</h3>    
        <!-- Create form -->
        <form id="create_edit_category" action="create_category.php" method="post" autocomplete="off">
            <div class="form-group col-md-4">
                <label for="category" class="text-secondary font-weight-bold">Category Name: </label>
                <input class="form-control" name="category" id="category" type="text" />
                <p class="error" id="category_error">* Required field</p>
            </div>
            <div>
                <!-- Button has "create" name parameter -->
                <button class="btn btn-primary btn-sm ml-3 mb-3" type="submit" name="create">Create Category</button>
            </div>
        </form>
    </main>
</body>
</html>