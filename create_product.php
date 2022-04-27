<!--

    Description: New product form creation.

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
    // CREATE product if product was presented in POST, and "Create Product" button was pressed
    if (isset($_POST['create']) && (!empty($_POST['product_name']) || $_POST['product_name'] == 0) && (!empty($_POST['product_width']) || $_POST['product_width'] == 0) && (!empty($_POST['product_hight']) || $_POST['product_hight'] == 0) && (!empty($_POST['product_shape']) || $_POST['product_shape'] == 0) && (!empty($_POST['product_frame']) || $_POST['product_frame'] == 0) && (!empty($_POST['category_id']) || $_POST['category_id'] == 0)) {

        require 'images.php';
        
        // Sanitize user input to escape HTML sections and filter out dangerous characters
        $product_name = filter_input(INPUT_POST, 'product_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $product_width = filter_input(INPUT_POST, 'product_width', FILTER_SANITIZE_NUMBER_INT);
        $product_hight = filter_input(INPUT_POST, 'product_hight', FILTER_SANITIZE_NUMBER_INT);
        $product_shape = filter_input(INPUT_POST, 'product_shape', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $product_frame = filter_input(INPUT_POST, 'product_frame', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $product_description = filter_input(INPUT_POST, 'product_description', FILTER_DEFAULT);
        $category_id = filter_input(INPUT_POST, 'category_id', FILTER_SANITIZE_NUMBER_INT);
        $query = "INSERT INTO products (product_name, product_width, product_hight, product_shape, product_frame, product_description, product_image, category_id) VALUES (:product_name, :product_width, :product_hight, :product_shape, :product_frame, :product_description, :product_image, :category_id)";
        $statement = $db->prepare($query);
        $statement->bindValue(':product_name', $product_name);
        $statement->bindValue(':product_width', $product_width);
        $statement->bindValue(':product_hight', $product_hight);
        $statement->bindValue(':product_shape', $product_shape);
        $statement->bindValue(':product_frame', $product_frame);
        $statement->bindValue(':product_description', $product_description);
        $statement->bindValue(':product_image', $product_image);
        $statement->bindValue(':category_id', $category_id);
        $statement->execute();
        // Redirect to categories_admin.php page if variables are valid
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
        <h3 class="font-weight-bold text-muted">New Product</h3>
        <!-- Create form -->
        <form id="create_edit_product" action="create_product.php" method="post" enctype="multipart/form-data" autocomplete="off">
            <div class="form-group col-md-4">
                <label for="product_name" class="text-secondary font-weight-bold">Product Name: </label>
                <input class="form-control" name="product_name" id="product_name" type="text" />
                <p class="error" id="product_error">* Required field</p>
            </div>
            <div class="form-group col-md-4">
                <label for="product_width" class="text-secondary font-weight-bold">Width, (mm): </label>
                <input class="form-control" name="product_width" id="product_width" type="text" />
                <p class="error" id="width_error">* Required field</p>
                <p class="error" id="widthformat_error">* Width must be a number</p>
            </div>
            <div class="form-group col-md-4">
                <label for="product_hight" class="text-secondary font-weight-bold">Hight, (mm): </label>
                <input class="form-control" name="product_hight" id="product_hight" type="text" />
                <p class="error" id="hight_error">* Required field</p>
                <p class="error" id="hightformat_error">* Hight must be a number</p>
            </div>
            <div class="form-group col-md-4">
                <label for="product_shape" class="text-secondary font-weight-bold">Shape: </label>
                <input class="form-control" name="product_shape" id="product_shape" type="text" />
                <p class="error" id="shape_error">* Required field</p>
            </div>
            <div class="form-group col-md-4">
                <label for="product_frame" class="text-secondary font-weight-bold">Frame: </label>
                <input class="form-control" name="product_frame" id="product_frame" type="text" />
                <p class="error" id="frame_error">* Required field</p>
            </div>
            <div class="col-md-4">
                <label for="product_description" class="text-secondary font-weight-bold">Description: </label>
                <textarea name="product_description" id="product_description"></textarea>
            </div>
            
            <div class="col-md-4 my-3 mr-sm-2">
                <label class="text-secondary font-weight-bold" for="category_id">Category: </label>
                <select class="custom-select" id="category_id" name="category_id">
                    <?php foreach($categories as $category): ?>
                    <option value="<?= $category['category_id'] ?>"><?= $category['category'] ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="col-md-4">
                <label class="text-secondary font-weight-bold" for='product_image'>Image (optional):</label>
                <input class="form-control-file" type='file' name='product_image' id='product_image'>
            </div>
            <div>
                <!-- Button has "create" name parameter -->
                <button type="submit" class="btn btn-primary btn-sm ml-3 my-3" name="create">Create Product</button>
            </div>
        </form>
    </main>
</body>
</html>