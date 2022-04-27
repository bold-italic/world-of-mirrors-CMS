<!--

    Description: Uploads and resizes images.

-->

<?php
    require 'php-image-resize-master/lib/ImageResize.php';
    require 'php-image-resize-master/lib/ImageResizeException.php';
    use \Gumlet\ImageResize;

    // file_upload_path() - Safely build a path String that uses slashes appropriate for our OS.
        // Default upload path is an 'uploads' sub-folder in the current folder.
        function file_upload_path($original_filename, $upload_subfolder_name = 'images') {
           $current_folder = dirname(__FILE__);
           
           // Build an array of paths segment names to be joins using OS specific slashes.
           $path_segments = [$current_folder, $upload_subfolder_name, basename($original_filename)];

           // The DIRECTORY_SEPARATOR constant is OS specific.
           return join(DIRECTORY_SEPARATOR, $path_segments);
        }

        // file_is_an_file() - Checks the mime-type & extension of the uploaded file for "file-ness".
        function file_is_an_file($temporary_path, $new_path) {
            $allowed_mime_types      = ['image/gif', 'image/jpeg', 'image/png'];
            $allowed_file_extensions = ['gif', 'GIF', 'jpg', "JPG", 'jpeg', 'JPEG', 'png', 'PNG'];
            
            $actual_file_extension   = pathinfo($new_path, PATHINFO_EXTENSION);
            $actual_mime_type      = mime_content_type($temporary_path);
            
            $file_extension_is_valid = in_array($actual_file_extension, $allowed_file_extensions);
            $mime_type_is_valid      = in_array($actual_mime_type, $allowed_mime_types);
            
            return $file_extension_is_valid && $mime_type_is_valid;
        }

        // Remove all special characters from Product Name
        function clean($string) {
           $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
           $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.

           return preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
        }
        
        $file_upload_detected = isset($_FILES['product_image']) && ($_FILES['product_image']['error'] === 0);
        $upload_error_detected = isset($_FILES['product_image']) && ($_FILES['product_image']['error'] > 0);

        if ($file_upload_detected) { 
            $file_filename        = $_FILES['product_image']['name'];
            $temporary_file_path  = $_FILES['product_image']['tmp_name'];
            $new_file_path        = file_upload_path($file_filename);

            $filename = pathinfo($file_filename)['filename'];
            $extension = pathinfo($file_filename)['extension'];

            if (file_is_an_file($temporary_file_path, $new_file_path)) {
                
                    $image = new ImageResize($temporary_file_path);
                    $image

                        ->resizeToWidth(600)
                        ->save("images/" . clean("{$_POST['product_name']}") . "." . $extension)
                    ;
                $product_image = "images/" . clean("{$_POST['product_name']}") . "." . $extension;
            }   else {
                    $product_image = NULL;
                }
        }
?>
