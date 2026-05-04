
<?php
include "db.php";

$id = $_GET['id'];

$search="";
if(isset($_GET['search'])){
$search=mysqli_real_escape_string($conn,$_GET['search']);
}

/* CATEGORY FILTER */

$where="";

if(isset($_GET['category'])){
$category=$_GET['category'];
$where="WHERE category='$category'";
}

/* GET CURRENT NEWS */

$result = mysqli_query($conn,"SELECT * FROM news WHERE id='$id'");
$row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>

<title><?php echo $row['title']; ?></title>

<style>

body{
font-family:Arial, sans-serif;
margin:0;
background:white;
}

/* Header */

.header{
background:#c40000;
color:white;
padding:15px 25px;
display:flex;
justify-content:space-between;
align-items:center;
}

.logo{
font-size:28px;
font-weight:bold;
}

.search input{
padding:6px;
border:none;
border-radius:3px;
}

/* Top menu */

.topmenu{
background:#b00000;
padding:8px 20px;
}

.topmenu a{
color:white;
text-decoration:none;
margin-right:20px;
}

/* Navigation */

.nav{
background:#e60000;
padding:10px;
text-align:center;
}

.nav a{
color:white;
text-decoration:none;
margin:0 15px;
font-weight:bold;
}

/* Breaking */

.breaking{
background:black;
color:white;
padding:8px;
}

/* Layout */

.container{
width:95%;
margin:auto;
margin-top:20px;
display:grid;
grid-template-columns:25% 50% 25%;
gap:20px;
}

/* Latest */

.latest h2{
border-bottom:3px solid red;
padding-bottom:5px;
}

.latest-item{
display:flex;
margin-bottom:12px;
border-bottom:1px solid #eee;
padding-bottom:8px;
}

.latest-item img{
width:90px;
height:65px;
object-fit:cover;
margin-left:10px;
}

/* Article */

.article img{
width:100%;
margin-bottom:10px;
}

.article video{
width:100%;
margin-bottom:10px;
}

.article-title{
font-size:30px;
font-weight:bold;
margin-bottom:10px;
}

.article p{
font-size:18px;
line-height:1.6;
}

/* Sidebar */

.sidebar img{
width:100%;
height:120px;
object-fit:cover;
margin-top:10px;
}

/* Footer */

.footer{
background:#222;
color:white;
text-align:center;
padding:15px;
margin-top:20px;
}

/* Hide google translate extra text */

.goog-logo-link,
.goog-te-gadget span{
display:none !important;
}

.goog-te-banner-frame.skiptranslate{
display:none !important;
}

body{
top:0px !important;
}

</style>

</head>

<body>

<!-- HEADER -->

<div class="header">

<div class="logo">Headline Hub తెలుగు</div>

<div style="display:flex;align-items:center;gap:15px;">

<div style="color:white;font-weight:bold;display:flex;align-items:center;gap:5px;">

Language:

<select onchange="changeLanguage(this.value)" style="padding:5px;border-radius:4px;">
<option value="">Select</option>
<option value="en">English</option>
<option value="te">Telugu</option>
<option value="hi">Hindi</option>
</select>

</div>

<div id="google_translate_element" style="display:none"></div>

<form class="search" method="GET" action="index.php">
<input type="text" name="search" placeholder="Search news" value="<?php echo $search; ?>">
</form>

</div>

</div>

<!-- GOOGLE TRANSLATE SCRIPT -->

<script>

function googleTranslateElementInit(){

new google.translate.TranslateElement(
{
pageLanguage:'en',
includedLanguages:'en,te,hi'
},
'google_translate_element');

}

function changeLanguage(lang){

var select=document.querySelector(".goog-te-combo");

if(select){
select.value=lang;
select.dispatchEvent(new Event("change"));
}

}

</script>

<script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

<!-- TOP MENU -->

<div class="topmenu">
<a href="index.php?type=video">VIDEO</a>
<a href="index.php?type=photo">PHOTOS</a>
<a href="webstories.php">WEB STORIES</a>
<a href="livetv.php">LIVE TV</a>
</div>

<!-- NAVIGATION -->

<div class="nav">

<a href="index.php">Home</a>
<a href="index.php?category=Politics">Politics</a>
<a href="index.php?category=Sports">Sports</a>
<a href="index.php?category=Technology">Technology</a>
<a href="index.php?category=Entertainment">Entertainment</a>

</div>

<div class="breaking">

<marquee>

<?php

$breaking=mysqli_query($conn,"SELECT * FROM news ORDER BY id DESC LIMIT 10");

while($b=mysqli_fetch_assoc($breaking)){

echo "🔴 ".$b['title']." &nbsp;&nbsp;&nbsp; | &nbsp;&nbsp;&nbsp; ";

}

?>

</marquee>

</div>

<div class="container">

<!-- LEFT LATEST NEWS -->

<div class="latest">

<h2>LATEST UPDATES</h2>

<?php

$latest = mysqli_query($conn,"SELECT * FROM news $where ORDER BY id DESC LIMIT 6");

while($l = mysqli_fetch_assoc($latest)){

$nid = $l['id'];

$media = mysqli_query($conn,"SELECT * FROM news_media WHERE news_id='$nid' LIMIT 1");
$m = mysqli_fetch_assoc($media);

?>

<a href="news.php?id=<?php echo $l['id']; ?>" style="text-decoration:none;color:black;">

<div class="latest-item">

<div>
<b><?php echo $l['title']; ?></b>
</div>

<?php
if($m){
?>

<img src="uploads/<?php echo $m['file_name']; ?>">

<?php
}else{
?>

<img src="uploads/<?php echo $l['image']; ?>">

<?php
}
?>

</div>

</a>

<?php
}
?>

</div>


<!-- CENTER ARTICLE -->

<div class="article">

<h1 class="article-title">
<?php echo $row['title']; ?>
</h1>

<?php

$media = mysqli_query($conn,"SELECT * FROM news_media WHERE news_id='$id'");

if(mysqli_num_rows($media) > 0){

while($m = mysqli_fetch_assoc($media)){

$file = $m['file_name'];
$ext = pathinfo($file, PATHINFO_EXTENSION);

if($ext == "mp4"){
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

}

}else{

?>

<img src="uploads/<?php echo $row['image']; ?>">

<?php
}
?>

<p>
<?php echo $row['description']; ?>
</p>

</div>


<!-- RIGHT SIDEBAR -->

<div class="sidebar">

<h3>Trending News</h3>

<?php

$side = mysqli_query($conn,"SELECT * FROM news $where ORDER BY id DESC LIMIT 3");

while($s = mysqli_fetch_assoc($side)){

$nid = $s['id'];

$media = mysqli_query($conn,"SELECT * FROM news_media WHERE news_id='$nid' LIMIT 1");
$m = mysqli_fetch_assoc($media);

?>

<a href="news.php?id=<?php echo $s['id']; ?>" style="text-decoration:none;color:black;">

<p><?php echo $s['title']; ?></p>

<?php
if($m){
?>

<img src="uploads/<?php echo $m['file_name']; ?>">

<?php
}else{
?>

<img src="uploads/<?php echo $s['image']; ?>">

<?php
}
?>

</a>

<?php
}
?>

</div>

</div>

<div class="footer">
© 2026 Live News Portal
</div>

</body>
</html>
