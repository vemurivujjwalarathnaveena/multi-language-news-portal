```php
<?php
include "db.php";

$title = mysqli_real_escape_string($conn,$_POST['title']);
$description = mysqli_real_escape_string($conn,$_POST['description']);
$category = mysqli_real_escape_string($conn,$_POST['category']);
$featured = mysqli_real_escape_string($conn,$_POST['featured']);

/* INSERT NEWS */

$query = "INSERT INTO news(title,description,category,featured,created_at)
VALUES('$title','$description','$category','$featured',NOW())";

mysqli_query($conn,$query);

$news_id = mysqli_insert_id($conn);

/* MEDIA UPLOAD */

if(isset($_FILES['media'])){

$count = count($_FILES['media']['name']);

for($i=0;$i<$count;$i++){

$file_name = $_FILES['media']['name'][$i];
$tmp_name = $_FILES['media']['tmp_name'][$i];

$folder = "uploads/".$file_name;

move_uploaded_file($tmp_name,$folder);

mysqli_query($conn,"INSERT INTO news_media(news_id,file_name)
VALUES('$news_id','$file_name')");

}

}

header("Location: dashboard.php");
exit();

?>
```
