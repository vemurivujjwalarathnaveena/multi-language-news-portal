<?php
include "db.php";

$id = $_GET['id'];

$result = mysqli_query($conn,"SELECT * FROM news WHERE id='$id'");
$row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>

<title>Edit News</title>

<style>

body{
font-family:Arial, sans-serif;
margin:0;
padding:0;
background-image:url("https://png.pngtree.com/thumb_back/fh260/background/20211014/pngtree-news-tv-broadcast-technology-background-image_909022.png");
background-size:cover;
background-position:center;
height:100vh;
display:flex;
justify-content:center;
align-items:center;
}

/* Form Container */

.form-box{
background:white;
padding:25px;
width:420px;
border-radius:12px;
box-shadow:0px 0px 25px rgba(0,0,0,0.4);
}

/* Title */

.form-box h2{
text-align:center;
margin-bottom:15px;
color:#c40000;
}

/* Inputs */

input, textarea, select{
width:100%;
padding:10px;
margin:8px 0;
border:1px solid #ccc;
border-radius:6px;
font-size:14px;
box-sizing:border-box;
}

textarea{
height:80px;
resize:none;
}

/* Media preview */

.media-preview{
margin-top:8px;
margin-bottom:10px;
text-align:center;
}

.media-preview img{
width:100%;
max-height:160px;
object-fit:cover;
border-radius:8px;
}

.media-preview video{
width:100%;
max-height:160px;
object-fit:cover;
border-radius:8px;
}

/* Button */

button{
width:100%;
padding:12px;
background:#c40000;
color:white;
border:none;
border-radius:6px;
font-size:16px;
cursor:pointer;
}

button:hover{
background:#8f0000;
}

/* Replace label */

.replace-label{
font-size:13px;
color:#555;
margin-top:6px;
}

/* Back button */

.back{
display:block;
text-align:center;
margin-top:10px;
text-decoration:none;
color:#333;
font-size:13px;
}

.back:hover{
text-decoration:underline;
}

</style>

</head>

<body>

<div class="form-box">

<h2>Edit News</h2>

<form action="update_news.php" method="POST" enctype="multipart/form-data">

<input type="hidden" name="id" value="<?php echo $row['id']; ?>">

<!-- TITLE -->

<input type="text" name="title" value="<?php echo $row['title']; ?>" required>

<!-- DESCRIPTION -->

<textarea name="description"><?php echo $row['description']; ?></textarea>

<!-- CATEGORY -->

<select name="category" required>

<option value="Politics" <?php if($row['category']=="Politics") echo "selected"; ?>>Politics</option>

<option value="Sports" <?php if($row['category']=="Sports") echo "selected"; ?>>Sports</option>

<option value="Technology" <?php if($row['category']=="Technology") echo "selected"; ?>>Technology</option>

<option value="Entertainment" <?php if($row['category']=="Entertainment") echo "selected"; ?>>Entertainment</option>

<option value="Business" <?php if($row['category']=="Business") echo "selected"; ?>>Business</option>

</select>

<!-- MEDIA PREVIEW -->

<div class="media-preview">

<?php
$file = $row['image'];
$extension = pathinfo($file, PATHINFO_EXTENSION);

if($extension == "mp4"){
?>

<video controls>
<source src="uploads/<?php echo $file; ?>" type="video/mp4">
</video>

<?php
}else{
?>

<img src="uploads/<?php echo $file; ?>">

<?php
}
?>

</div>

<div class="replace-label">
Replace Image / Video (optional)
</div>

<input type="file" name="image">

<button type="submit">Update News</button>

</form>

<a class="back" href="dashboard.php">← Back to Dashboard</a>

</div>

</body>
</html>