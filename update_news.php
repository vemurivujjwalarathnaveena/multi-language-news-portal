```php
<?php
include "db.php";

$id = $_POST['id'];

$title = mysqli_real_escape_string($conn,$_POST['title']);
$description = mysqli_real_escape_string($conn,$_POST['description']);
$category = mysqli_real_escape_string($conn,$_POST['category']);

/* UPDATE NEWS */

$query = "UPDATE news SET
title='$title',
description='$description',
category='$category'
WHERE id='$id'";

mysqli_query($conn,$query);

/* IMAGE UPDATE */

if(isset($_FILES['image']) && $_FILES['image']['name']!=""){

$file_name = $_FILES['image']['name'];
$tmp_name = $_FILES['image']['tmp_name'];

$folder = "uploads/".$file_name;

move_uploaded_file($tmp_name,$folder);

mysqli_query($conn,"UPDATE news SET image='$file_name' WHERE id='$id'");

}

header("Location: dashboard.php");
exit();

?>
```
