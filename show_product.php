<!--

    Description: Generates Product Page and Comments.

-->

<?php
    require('connect.php');
    // --- Generates Product information ---
    // Ensure that any product_id values passed by the user are validated as integers
    $product_id = filter_input(INPUT_GET, 'product_id', FILTER_VALIDATE_INT);
    if ($product_id) {
        // Build and prepare SQL String with :product_id placeholder parameter
        // Bind the :product_id parameter in the query to the sanitized
        // $product_id specifying a binding-type of Integer
        // Fetch the row selected by primary key product_id
        $query = "SELECT * FROM products WHERE product_id = :product_id LIMIT 1";
        $statement = $db->prepare($query);
        $statement->bindValue(':product_id', $product_id, PDO::PARAM_INT);
        $statement->execute();
        $row = $statement->fetch();
        // Generates Comments information
        $query = "SELECT * FROM comments WHERE product_id = :product_id ORDER BY comment_created_date DESC";
        $statement = $db->prepare($query);
        $statement->bindValue(':product_id', $product_id, PDO::PARAM_INT);
        $statement->execute();
        $comments = $statement->fetchAll();

        // Redirect to Home Page if product_id is not valid
    }   else {
            header("Location: index.php");
            exit;
        }
    // CREATE comment if comment was presented in POST, and "Create Comment" button was pressed
    $comment_user_name = "";
    $comment = "";
    if (isset($_POST['create']) && (!empty($_POST['product_id']) || $_POST['product_id'] == 0)) {
        // Sanitize user input to escape HTML sections and filter out dangerous characters
        $comment_user_name = filter_input(INPUT_POST, 'comment_user_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $comment = filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $product_id = filter_input(INPUT_POST, 'product_id', FILTER_SANITIZE_NUMBER_INT);
        // Build the parameterized SQL query and bind to the above sanitized values
        $query = "INSERT INTO comments (comment_user_name, comment, product_id) VALUES (:comment_user_name, :comment, :product_id)";
        $statement = $db->prepare($query);
        $statement->bindValue(':comment_user_name', $comment_user_name);
        $statement->bindValue(':comment', $comment);
        $statement->bindValue(':product_id', $product_id);
        $statement->execute();
        // Redirect to categories_admin.php page if variables are valid
        header("Location: index.php");
        exit;
    }

    include('header.php');
?>
    <script src="createCommenttValidate.js"></script>
        <h3 class="font-weight-bold text-muted">Product</h3>
        <!-- Output product parameters -->
        <table class="table table-striped">
            <tbody>
                <tr>
                    <td class="text-primary font-weight-bold">Name</td>
                    <td><?= $row['product_name'] ?></td>
                </tr>
                <tr>
                    <td class="text-primary font-weight-bold">Width, (mm)</td>
                    <td><?= $row['product_width'] ?></td>
                </tr>
                <tr>
                    <td class="text-primary font-weight-bold">Hight, (mm)</td>
                    <td><?= $row['product_hight'] ?></td>
                </tr>
                <tr>
                    <td class="text-primary font-weight-bold">Shape</td>
                    <td><?= $row['product_shape'] ?></td>
                </tr>
                <tr>
                    <td class="text-primary font-weight-bold">Frame</td>
                    <td><?= $row['product_frame'] ?></td>
                </tr>
                <tr>
                    <td class="text-primary font-weight-bold">Description</td>
                    <td><?= $row['product_description'] ?></td>
                </tr>                                                
            </tbody>
        </table>
        <?php if($row['product_image'] != NULL): ?>
            <img src="<?= $row['product_image'] ?>" alt = "" />
        <?php endif ?>
        <!-- Create comment form -->
        <h3 class="font-weight-bold text-muted">New Comment</h3>
        <form id="create_comment" action="#" method="post" autocomplete="off">
            <!-- Hidden input for product_id -->
            <input type="hidden" name="product_id" value="<?= $row['product_id'] ?>">
            <div class="form-group col-md-4">
                <label for="comment_user_name" class="text-secondary font-weight-bold">Name: </label>
                <input name="comment_user_name" class="form-control" id="comment_user_name" type="text" value="<?php echo $comment_user_name; ?>" />
                <p class="error" id="name_error">* Required field</p>
            </div>
            <div class="form-group col-md-7">
                <label for="comment" class="text-secondary font-weight-bold">Comment: </label>
                <textarea name="comment" class="form-control" id="comment" rows="4"><?php echo $comment; ?></textarea>
                <p class="error" id="comment_error">* Required field</p>
            </div>
                <button class="btn btn-primary btn-sm ml-3" type="submit" name="create">Create Comment</button>
        </form>
        
        <!-- Output comments -->
        <h3 class="font-weight-bold text-muted mt-5">Comments</h3>
        <?php foreach($comments as $comment): ?>
            <div class="border border-primary p-3 bg-white m-3">
                <p><span class="text-primary font-weight-bold">Posted: </span><?= $comment['comment_created_date'] ?></p>
                <div><span class="text-secondary font-weight-bold">Name: </span><?= $comment['comment_user_name'] ?></div>
                <div><span class="text-secondary font-weight-bold">Comment: </span><?= $comment['comment'] ?></div>
            </div>
        <?php endforeach ?>
    </main>
</body>
</html>