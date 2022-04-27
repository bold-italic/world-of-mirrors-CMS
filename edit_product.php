<!--

    Description: Product editing and deleting. Comment moderation.

-->

<?php
    require('connect.php');
    require 'authenticate.php';
    // Load category for drop-down list.
    // Build and prepare SQL string.
    // A PDO::Statement is prepared from the query.
    // Execution on the DB server
    $query = "SELECT * FROM categories";
    $statement = $db->prepare($query);
    $statement->execute();
    $categories = $statement->fetchAll();

    // --- Update section ---
    // UPDATE products table if product_id and product were presented in POST, and "Update Product" button was pressed
    if (isset($_POST['update']) && isset($_POST['product_id']) && (!empty($_POST['product_name']) || $_POST['product_name'] == 0) && (!empty($_POST['product_width']) || $_POST['product_width'] == 0) && (!empty($_POST['product_hight']) || $_POST['product_hight'] == 0) && (!empty($_POST['product_shape']) || $_POST['product_shape'] == 0) && (!empty($_POST['product_frame']) || $_POST['product_frame'] == 0) && (!empty($_POST['category_id']) || $_POST['category_id'] == 0)) {

            // Sanitize user input to escape HTML sections and filter out dangerous characters
        $product_name = filter_input(INPUT_POST, 'product_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $product_width = filter_input(INPUT_POST, 'product_width', FILTER_SANITIZE_NUMBER_INT);
        $product_hight = filter_input(INPUT_POST, 'product_hight', FILTER_SANITIZE_NUMBER_INT);
        $product_shape = filter_input(INPUT_POST, 'product_shape', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $product_frame = filter_input(INPUT_POST, 'product_frame', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $product_description = filter_input(INPUT_POST, 'product_description', FILTER_DEFAULT);
        if (isset($_POST['delete_image'])) {
            unlink($_POST['product_image']);
            $product_image =NULL;
        }   elseif (isset($_POST['product_image'])) {
                $product_image = filter_input(INPUT_POST, 'product_image', FILTER_DEFAULT);
            }   else {
                    require 'images.php';
            }
        $category_id = filter_input(INPUT_POST, 'category_id', FILTER_SANITIZE_NUMBER_INT);
        $product_id = filter_input(INPUT_POST, 'product_id', FILTER_SANITIZE_NUMBER_INT);
        // Build the parameterized SQL query and bind to the above sanitized values
        $query = "UPDATE products SET product_name = :product_name, product_width = :product_width, product_hight = :product_hight, product_shape = :product_shape, product_frame = :product_frame, product_description = :product_description, product_image = :product_image, category_id = :category_id WHERE product_id = :product_id LIMIT 1";
        $statement = $db->prepare($query);
        $statement->bindValue(':product_name', $product_name);
        $statement->bindValue(':product_width', $product_width);
        $statement->bindValue(':product_hight', $product_hight);
        $statement->bindValue(':product_shape', $product_shape);
        $statement->bindValue(':product_frame', $product_frame);
        $statement->bindValue(':product_description', $product_description);
        $statement->bindValue(':product_image', $product_image);
        $statement->bindValue(':category_id', $category_id);
        $statement->bindValue(':product_id', $product_id, PDO::PARAM_INT);
        $statement->execute();
        // Redirect to categories_admin.php page if variables are valid
        header("Location: products_admin.php");
        exit;
    }   
        // --- Delete product section ---
        // DELETE product if product_id was presented in POST, and "Delete" button was pressed
        elseif (isset($_POST['delete']) && isset($_POST['product_id'])) {
            $product_id = filter_input(INPUT_POST, 'product_id', FILTER_SANITIZE_NUMBER_INT);
            // Build the parameterized SQL query and bind to the above sanitized value
            $query = "DELETE FROM products WHERE product_id = :product_id LIMIT 1";
            $statement = $db->prepare($query);
            $statement->bindValue(':product_id', $product_id, PDO::PARAM_INT);
            $statement->execute();
            unlink($_POST['product_image']);
            // Redirect to categories_admin.php page if variables are valid
            header("Location: products_admin.php");
            exit;
            // --- Load product section ---
            // Ensure that any product_id values passed by the user are validated as integers
        }   elseif ($product_id = filter_input(INPUT_GET, 'product_id', FILTER_VALIDATE_INT)) {
                $query = "SELECT * FROM products WHERE product_id = :product_id";
                $statement = $db->prepare($query);
                $statement->bindValue(':product_id', $product_id, PDO::PARAM_INT);
                $statement->execute();
                $product = $statement->fetch();
                // Redirect to categories_admin.php page if variables are not valid
            }
    // Comment moderation.
    // DELETE comment if comment_id was presented in POST, and "Delete Comment" button was pressed
    if (isset($_POST['delete_comment']) && isset($_POST['comment_id']) && isset($_POST['product_id'])) {
        $comment_id = filter_input(INPUT_POST, 'comment_id', FILTER_SANITIZE_NUMBER_INT);
        $product_id = filter_input(INPUT_POST, 'product_id', FILTER_SANITIZE_NUMBER_INT);
        // Build the parameterized SQL query and bind to the above sanitized value
        $query = "DELETE FROM comments WHERE comment_id = :comment_id LIMIT 1";
        $statement = $db->prepare($query);
        $statement->bindValue(':comment_id', $comment_id, PDO::PARAM_INT);
        $statement->execute();
        // unlink($_POST['product_image']);
        // if (isset($_POST['product_image'])) {
        //     unlink($_POST['product_image']);
        // }
        // Redirect to categories_admin.php page if variables are valid
        header("Location: edit_product.php?product_id={$product_id}");
        exit;
        // --- Load comments section ---
            // Ensure that any product_id values passed by the user are validated as integers
    }   elseif ($product_id = filter_input(INPUT_GET, 'product_id', FILTER_VALIDATE_INT)) {
            $query = "SELECT * FROM comments WHERE product_id = :product_id ORDER BY comment_created_date DESC";
            $statement = $db->prepare($query);
            $statement->bindValue(':product_id', $product_id, PDO::PARAM_INT);
            $statement->execute();
            $comments = $statement->fetchAll();
            // Redirect to products_admin.php if product_id is not valid
        }   
        else {
                header("Location: products_admin.php");
                exit;
            }

    include('header.php');
?>
    <script src="createEditProductValidate.js"></script>
    <script src="tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
    <script>
        tinyMCE.init({
            mode  : "textareas",
            theme : "advanced",
            theme_advanced_buttons1 : "bold,italic,underline,separator," +
                                      "strikethrough,justifyleft,justifycenter,justifyright,bullist,numlist,forecolor,backcolor,blockquote,hr,separator," +
                                      "undo,redo,separator,link,unlink",
            theme_advanced_buttons2 : "",
            theme_advanced_buttons3 : "",
            theme_advanced_toolbar_location : "top",
            theme_advanced_toolbar_align : "left",
            theme_advanced_path : false,
            theme_advanced_font_sizes : "Big text=30px,Small text=small,My Text Size=.mytextsize",
            width: "600",
            height: '250px'
        });
    </script>
        <h3 class="font-weight-bold text-muted">Update Product</h3>
        <!-- Create form -->
        <form id="create_edit_product" action="edit_product.php" method="post" enctype="multipart/form-data" autocomplete="off">
            <!-- Hidden input for the quote primary key -->
            <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
            <div class="form-group col-md-4">
                <label for="product_name" class="text-secondary font-weight-bold">Product Name: </label>
                <input class="form-control" name="product_name" id="product_name" type="text" value="<?= $product['product_name'] ?>" />
                <p class="error" id="product_error">* Required field</p>
            </div>
            <div class="form-group col-md-4">
                <label for="product_width" class="text-secondary font-weight-bold">Width, (mm): </label>
                <input class="form-control" name="product_width" id="product_width" type="text" value="<?= $product['product_width'] ?>" />
                <p class="error" id="width_error">* Required field</p>
                <p class="error" id="widthformat_error">* Width must be a number</p>
            </div>
            <div class="form-group col-md-4">
                <label for="product_hight" class="text-secondary font-weight-bold">Hight, (mm): </label>
                <input class="form-control" name="product_hight" id="product_hight" type="text" value="<?= $product['product_hight'] ?>" />
                <p class="error" id="hight_error">* Required field</p>
                <p class="error" id="hightformat_error">* Hight must be a number</p>
            </div>
            <div class="form-group col-md-4">
                <label for="product_shape" class="text-secondary font-weight-bold">Shape: </label>
                <input class="form-control" name="product_shape" id="product_shape" type="text" value="<?= $product['product_shape'] ?>" />
                <p class="error" id="shape_error">* Required field</p>
            </div>
            <div class="form-group col-md-4">
                <label for="product_frame" class="text-secondary font-weight-bold">Frame: </label>
                <input class="form-control" name="product_frame" id="product_frame" type="text" value="<?= $product['product_frame'] ?>" />
                <p class="error" id="frame_error">* Required field</p>
            </div>
            <div class="col-md-4">
                <label for="product_description" class="text-secondary font-weight-bold">Description: </label>
                <textarea name="product_description" id="product_description"><?= $product['product_description'] ?></textarea>
            </div>
            <div class="col-md-4 my-3 mr-sm-2">
                <label for="category_id" class="text-secondary font-weight-bold">Category: </label>
                <select class="custom-select" id="category_id" name="category_id">
                    <?php foreach($categories as $category): ?>
                    <option value="<?= $category['category_id'] ?>" 
                        <?php if ($product['category_id'] == $category['category_id']): ?>
                            selected
                        <?php endif ?>>
                        <?= $category['category'] ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="col-md-4">
                <div class="text-secondary font-weight-bold mb-2">Image (optional): </div>
                <?php if (!$product['product_image'] == NULL): ?>
                    <input type="hidden" name="product_image" value="<?= $product['product_image'] ?>">
                    <div>
                        <img src="<?= $product['product_image'] ?>" height="100" alt = "" />
                    </div>
                    <div class="form-check mt-2">
                        <input class="form-check-input" id="delete_image" type='checkbox' name='delete_image' />
                        <label class="form-check-label text-secondary font-weight-bold" for="delete_image">Delete Image</label>
                    </div>
                <?php else: ?>
                    <input class="form-control-file" type='file' name='product_image' id='product_image'>
                <?php endif ?>
            </div>
            <div>
                <!-- Button has "update" name parameter -->
                <button type="submit" class="btn btn-primary btn-sm ml-3 my-3" name="update">Update Product</button>
                <button type="submit" class="btn btn-primary btn-sm ml-1 my-3" name="delete" onclick="return confirm('Are you sure you wish to delete this product?')">Delete</button>
            </div>
        </form>
        <?php if (count($comments)): ?>
            <hr />
            <h3 class="font-weight-bold text-muted">Moderate Comments</h3>
            <form id="delete_comment" action="edit_product.php" method="post">
                <div class="col-md-2 my-3">
                    <label class="text-secondary font-weight-bold" for="comment_id">Comment ID: </label>
                    <select class="custom-select" id="comment_id" name="comment_id">
                        <?php foreach($comments as $comment): ?>
                        <option value="<?= $comment['comment_id'] ?>"><?= $comment['comment_id'] ?></option>
                        <?php endforeach ?>
                    </select>
                    <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
                </div>
                <button type="submit" class="btn btn-primary btn-sm ml-3 mb-3" name="delete_comment" onclick="return confirm('Are you sure you wish to delete this comment?')">Delete Comment</button>
            </form>
        <?php endif ?>
        <?php foreach($comments as $comment): ?>
            <input type="hidden" name="comment_id" value="<?= $comment['comment_id'] ?>">
            <div class="border border-primary p-3 bg-white m-3">
                <p><span class="text-primary font-weight-bold">ID: </span><?= $comment['comment_id'] ?></p>
                <div><span class="text-secondary font-weight-bold">Posted: </span><?= $comment['comment_created_date'] ?></div>
                <div><span class="text-secondary font-weight-bold">Name: </span><?= $comment['comment_user_name'] ?></div>
                <div><span class="text-secondary font-weight-bold">Comment: </span><?= $comment['comment'] ?></div>
            </div>
        <?php endforeach ?>
    </main>
</body>
</html>