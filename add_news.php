<!DOCTYPE html>
<html>
<head>

<title>Add News</title>

<style>

body{
font-family: Arial, sans-serif;
margin:0;
padding:0;
background-image:url("https://img.freepik.com/premium-photo/spacious-newsroom-with-red-blue-lights-reflecting-floor_862489-41703.jpg");
background-size:cover;
background-position:center;
height:100vh;
display:flex;
justify-content:center;
align-items:center;
}

.form-box{
background:white;
padding:40px;
width:420px;
border-radius:12px;
box-shadow:0px 0px 25px rgba(0,0,0,0.4);
text-align:center;
}

input, textarea, select, button{
width:100%;
padding:12px;
margin:10px 0;
border:1px solid #ccc;
border-radius:6px;
font-size:16px;
box-sizing:border-box;
}

textarea{
height:120px;
resize:none;
}

button{
background:#c40000;
color:white;
border:none;
cursor:pointer;
}

button:hover{
background:#8f0000;
}

/* Back button */

.back-btn{
display:block;
margin-top:10px;
text-decoration:none;
background:#444;
color:white;
padding:10px;
border-radius:6px;
}

.back-btn:hover{
background:#222;
}

</style>

</head>

<body>

<div class="form-box">

<h2>Upload News</h2>

<form action="save_news.php" method="POST" enctype="multipart/form-data">

<input type="text" name="title" placeholder="News Title" required>

<textarea name="description" placeholder="Write news"></textarea>

<select name="category" required>
<option value="">Select Category</option>
<option>Politics</option>
<option>Sports</option>
<option>Technology</option>
<option>Entertainment</option>
<option>Business</option>
</select>

<select name="featured">
<option value="No">Normal News</option>
<option value="Yes">Featured News</option>
</select>

<input type="file" name="media[]" multiple required>

<button type="submit">Publish News</button>

</form>

<a href="dashboard.php" class="back-btn">← Back to Dashboard</a>

</div>

</body>
</html>