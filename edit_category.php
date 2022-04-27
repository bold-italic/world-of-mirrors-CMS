<!--

    Description: Category editing and deleting.

-->

<?php
    // Add authentication script
    require 'authenticate.php';
    require('connect.php');
    // --- Update section ---
    // UPDATE categories table if category_id and categoty were presented in POST, and "Update Category" button was pressed
    if (isset($_POST['update']) && isset($_POST['category_id']) && (!empty($_POST['category']) || $_POST['category'] == 0)) {
        // Sanitize user input to escape HTML sections and filter out dangerous characters
        $category = filter_input(INPUT_POST, 'category', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $category_id = filter_input(INPUT_POST, 'category_id', FILTER_SANITIZE_NUMBER_INT);
        // Build the parameterized SQL query and bind to the above sanitized values
        $query = "UPDATE categories SET category = :category WHERE category_id = :category_id LIMIT 1";
        $statement = $db->prepare($query);
        $statement->bindValue(':category', $category);
        $statement->bindValue(':category_id', $category_id, PDO::PARAM_INT);
        $statement->execute();
        // Redirect to categories_admin.php page if variables are valid
        header("Location: categories_admin.php");
        exit;
    }   
        // --- Delete section ---
        // DELETE category if category_id was presented in POST, and "Delete" button was pressed
        elseif (isset($_POST['delete']) && isset($_POST['category_id'])) {
            $category_id = filter_input(INPUT_POST, 'category_id', FILTER_SANITIZE_NUMBER_INT);
            // Build the parameterized SQL query and bind to the above sanitized value
            $query = "DELETE FROM categories WHERE category_id = :category_id LIMIT 1";
            $statement = $db->prepare($query);
            $statement->bindValue(':category_id', $category_id, PDO::PARAM_INT);
            $statement->execute();
            // Redirect to categories_admin.php page if variables are valid
            header("Location: categories_admin.php");
            exit;
            // --- Load section ---
            // Ensure that any category_id values passed by the user are validated as integers
        }   elseif ($category_id = filter_input(INPUT_GET, 'category_id', FILTER_VALIDATE_INT)) {
                $query = "SELECT * FROM categories WHERE category_id = :category_id";
                $statement = $db->prepare($query);
                $statement->bindValue(':category_id', $category_id, PDO::PARAM_INT);
                $statement->execute();
                $category = $statement->fetch();
                // Redirect to categories_admin.php page if variables are not valid
            }   else {
                    header("Location: categories_admin.php");
                    exit;
                }

    include('header.php');
?>
    <script src="createEditCategoryValidate.js"></script>
        <h3 class="font-weight-bold text-muted">Update Category</h3>
        <!-- Create form -->
        <form id="create_edit_category" action="edit_category.php" method="post" autocomplete="off">
            <!-- Hidden input for the quote primary key -->
            <input type="hidden" name="category_id" value="<?= $category['category_id'] ?>">
            <div class="form-group col-md-4">
                <label for="category" class="text-secondary font-weight-bold">Category Name: </label>
                <input class="form-control" name="category" type="text" id="category" value="<?= $category['category'] ?>" />
                <p class="error" id="category_error">* Required field</p>
            </div>
            <div>
                <!-- Button has "update" name parameter -->
                <button type="submit" class="btn btn-primary btn-sm ml-3 mb-3" name="update">Update Category</button>
                <button type="submit" class="btn btn-primary btn-sm ml-1 mb-3" name="delete" onclick="return confirm('Are you sure you wish to delete this category?')">Delete</button>
            </div>
        </form>
    </main>
</body>
</html>