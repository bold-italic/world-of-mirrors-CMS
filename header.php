<!--

    Description: Uses as a header and navigation panel and search form in other php files.

-->



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>World of Mirrors</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" type="text/css" href="styles.css" />
</head>
<body>
    <main class="container">
        <header>
        	<h1 class="text-uppercase font-weight-bold text-muted">World of Mirrors</h1>
        </header>
        <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #E3F2FD;">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item">
                    <a href="index.php" class="btn btn-outline-primary btn-lg mr-sm-2" role="button" aria-pressed="true">Home</a>
                </li>
                <li class="nav-item">
                    <a href="categories.php" class="btn btn-outline-primary btn-lg mr-sm-2" role="button" aria-pressed="true">Categories</a>
                </li>
                <li class="nav-item">
                    <a href="admin.php" class="btn btn-outline-primary btn-lg mr-sm-2" role="button" aria-pressed="true">Admin</a>
                </li>
            </ul>            
             <form class="form-inline" action="search.php" method="post" autocomplete="off">
                <input class="form-control mr-sm-2" type="text" placeholder="Search" name="keyword" required>
                <button class="btn btn-primary" type="submit" name="submit">Search</button>
            </form>           
        </nav>
