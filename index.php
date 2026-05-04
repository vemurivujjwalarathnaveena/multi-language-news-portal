<?php
include "db.php";

/* SEARCH */

$search="";
if(isset($_GET['search'])){
$search=mysqli_real_escape_string($conn,$_GET['search']);
}

/* CATEGORY */

$category="";
if(isset($_GET['category'])){
$category=mysqli_real_escape_string($conn,$_GET['category']);
}

/* TYPE */

$type="";
if(isset($_GET['type'])){
$type=$_GET['type'];
}

/* WHERE CONDITION */

$where="WHERE 1";

if($search!=""){
$where.=" AND (title LIKE '%$search%' OR description LIKE '%$search%')";
}

if($category!=""){
$where.=" AND category='$category'";
}

if($type=="video"){
$where.=" AND (image LIKE '%.mp4' OR id IN (SELECT news_id FROM news_media WHERE file_name LIKE '%.mp4'))";
}

if($type=="photo"){
$where.=" AND (image NOT LIKE '%.mp4' OR id IN (SELECT news_id FROM news_media WHERE file_name NOT LIKE '%.mp4'))";
}

?>

<!DOCTYPE html>
<html>

<head>

<title>Live News Portal</title>

<style>

body{
font-family:Arial;
margin:0;
background:white;
}

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

.topmenu{
background:#b00000;
padding:8px 20px;
}

.topmenu a{
color:white;
text-decoration:none;
margin-right:20px;
}

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

.breaking{
background:black;
color:white;
padding:8px;
}

.container{
width:95%;
margin:auto;
margin-top:20px;
display:grid;
grid-template-columns:25% 50% 25%;
gap:20px;
}

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

.latest-item img,
.latest-item video{
width:90px;
height:65px;
object-fit:cover;
margin-left:10px;
}

.center img{
width:100%;
height:350px;
object-fit:cover;
}

.center video{
width:100%;
height:350px;
object-fit:cover;
}

.sidebar img,
.sidebar video{
width:100%;
height:120px;
object-fit:cover;
margin-top:10px;
}

.footer{
background:#222;
color:white;
text-align:center;
padding:15px;
margin-top:20px;
}

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

/* Hide Google translate top banner */

.goog-te-banner-frame.skiptranslate{
display:none !important;
}

body{
top:0px !important;
position:static !important;
}

/* Remove highlight effects */

.goog-text-highlight{
background:none !important;
box-shadow:none !important;
}

/* Hide tooltip */

.goog-tooltip{
display:none !important;
}

.goog-tooltip:hover{
display:none !important;
}

</style>

</head>

<body>

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

<div class="topmenu">
<a href="index.php?type=video">VIDEO</a>
<a href="index.php?type=photo">PHOTOS</a>
<a href="webstories.php">WEB STORIES</a>
<a href="livetv.php">LIVE TV</a>
</div>

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

<div class="latest">

<h2>Latest Updates</h2>

<?php

$latest_news=mysqli_query($conn,"SELECT * FROM news $where ORDER BY id DESC LIMIT 6");

while($row=mysqli_fetch_assoc($latest_news)){

$nid=$row['id'];

$media=mysqli_query($conn,"SELECT * FROM news_media WHERE news_id='$nid' LIMIT 1");
$m=mysqli_fetch_assoc($media);

?>

<a href="news.php?id=<?php echo $row['id']; ?>" style="text-decoration:none;color:black;">

<div class="latest-item">

<div>
<b><?php echo $row['title']; ?></b>
</div>

<?php

if($m){

$file=$m['file_name'];
$ext=pathinfo($file,PATHINFO_EXTENSION);

if($ext=="mp4"){
?>

<video muted>
<source src="uploads/<?php echo $file; ?>" type="video/mp4">
</video>

<?php
}else{
?>

<img src="uploads/<?php echo $file; ?>">

<?php
}

}else{
?>

<img src="uploads/<?php echo $row['image']; ?>">

<?php
}
?>

</div>

</a>

<?php } ?>

</div>

<div class="center">

<?php

if($type=="photo" || $type=="video"){
$query="SELECT * FROM news $where ORDER BY id DESC";
}else{
$query="SELECT * FROM news $where ORDER BY id DESC LIMIT 1";
}

$result=mysqli_query($conn,$query);

while($row=mysqli_fetch_assoc($result)){

$nid=$row['id'];

$media=mysqli_query($conn,"SELECT * FROM news_media WHERE news_id='$nid' LIMIT 1");
$m=mysqli_fetch_assoc($media);

?>

<a href="news.php?id=<?php echo $row['id']; ?>" style="text-decoration:none;color:black;">

<?php

if($m){

$file=$m['file_name'];
$ext=pathinfo($file,PATHINFO_EXTENSION);

if($ext=="mp4"){
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

}else{
?>

<img src="uploads/<?php echo $row['image']; ?>">

<?php
}
?>

<h2><?php echo $row['title']; ?></h2>

<p><?php echo substr($row['description'],0,200); ?>...</p>

</a>

<hr>

<?php } ?>

</div>

<div class="sidebar">

<h3>Trending News</h3>

<?php

$side=mysqli_query($conn,"SELECT * FROM news $where ORDER BY id DESC LIMIT 3");

while($row=mysqli_fetch_assoc($side)){

$nid=$row['id'];

$media=mysqli_query($conn,"SELECT * FROM news_media WHERE news_id='$nid' LIMIT 1");
$m=mysqli_fetch_assoc($media);

?>

<a href="news.php?id=<?php echo $row['id']; ?>" style="text-decoration:none;color:black;">

<p><?php echo $row['title']; ?></p>

<?php

if($m){

$file=$m['file_name'];
$ext=pathinfo($file,PATHINFO_EXTENSION);

if($ext=="mp4"){
?>

<video muted>
<source src="uploads/<?php echo $file; ?>" type="video/mp4">
</video>

<?php
}else{
?>

<img src="uploads/<?php echo $file; ?>">

<?php
}

}else{
?>

<img src="uploads/<?php echo $row['image']; ?>">

<?php
}
?>

</a>

<?php } ?>

</div>

</div>

<div class="footer">
© 2026 Live News Portal
</div>

<script>

function googleTranslateElementInit(){
new google.translate.TranslateElement(
{pageLanguage:'en',includedLanguages:'en,te,hi'},
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

<script>

function removeTranslateBanner(){

var banner=document.querySelector(".goog-te-banner-frame");

if(banner){
banner.style.display="none";
}

document.body.style.top="0px";

}

setInterval(removeTranslateBanner,100);

</script>

</body>
</html>