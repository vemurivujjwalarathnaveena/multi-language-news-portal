<?php
session_start();

if(!isset($_SESSION['journalist'])){
header("Location: login.php");
}

include "db.php";
?>

<!DOCTYPE html>
<html>
<head>

<title>Journalist Dashboard</title>

<style>

body{
font-family: Arial, sans-serif;
margin:0;
padding:0;
background-image:url("https://www.shutterstock.com/image-illustration/modern-news-space-worldmap-on-260nw-2469443615.jpg");
background-size:cover;
background-position:center;
}

/* Header */

.header{
background:#222;
color:white;
padding:18px;
font-size:26px;
text-align:center;
font-weight:bold;
}

/* Navigation */

.nav{
background:#444;
padding:10px;
text-align:center;
}

.nav a{
color:white;
margin:0 15px;
text-decoration:none;
font-size:16px;
}

.nav a:hover{
text-decoration:underline;
}

/* Breaking news */

.breaking{
background:#c40000;
color:white;
padding:8px;
font-weight:bold;
}

/* Layout */

.main{
display:flex;
padding:20px;
}

/* Left side */

.content{
width:70%;
background:rgba(255,255,255,0.95);
padding:20px;
border-radius:10px;
box-shadow:0px 0px 15px rgba(0,0,0,0.3);
}

/* Sidebar */

.sidebar{
width:30%;
margin-left:20px;
background:rgba(255,255,255,0.95);
padding:20px;
border-radius:10px;
box-shadow:0px 0px 15px rgba(0,0,0,0.3);
}

/* Upload button */

.upload-btn{
display:inline-block;
background:#c40000;
color:white;
padding:10px 20px;
text-decoration:none;
border-radius:5px;
margin-bottom:15px;
}

.upload-btn:hover{
background:#900000;
}

/* Search */

.search{
margin-bottom:15px;
}

.search input{
padding:8px;
width:70%;
}

.search button{
padding:8px 12px;
}

/* Table */

table{
width:100%;
border-collapse:collapse;
}

table th, table td{
border:1px solid #ddd;
padding:10px;
text-align:left;
}

table th{
background:#333;
color:white;
}

/* Footer */

.footer{
background:#222;
color:white;
text-align:center;
padding:10px;
margin-top:20px;
}

.logout-btn{
position:absolute;
right:20px;
top:15px;
background:#c40000;
color:white;
border:none;
padding:8px 16px;
font-size:14px;
border-radius:5px;
cursor:pointer;
}

.logout-btn:hover{
background:#900000;
}

.header{
background:#222;
color:white;
padding:18px;
font-size:26px;
text-align:center;
font-weight:bold;
position:relative;
}

</style>

</head>

<body>

<div class="header">

LIVE NEWS PORTAL - JOURNALIST PANEL

<form action="logout.php" method="POST" style="display:inline;">
<button class="logout-btn">Logout</button>
</form>

</div>

<div class="nav">
<a href="dashboard.php">Home</a>
<a href="dashboard.php?category=Politics">Politics</a>
<a href="dashboard.php?category=Sports">Sports</a>
<a href="dashboard.php?category=Technology">Technology</a>
<a href="dashboard.php?category=Entertainment">Entertainment</a>
</div>

<div class="breaking">
<marquee>Breaking: Latest news updates | Market rises | AI technology expanding</marquee>
</div>

<div class="main">

<div class="content">

<h2>
<?php
if(isset($_GET['category'])){
echo $_GET['category']." News";
}else{
echo "Manage News";
}
?>
</h2>

<a class="upload-btn" href="add_news.php">Upload News</a>

<form class="search" method="GET">

<input type="text" name="search" placeholder="Search news..."
value="<?php if(isset($_GET['search'])) echo $_GET['search']; ?>">

<button type="submit">Search</button>

</form>

<table>

<tr>
<th>Title</th>
<th>Category</th>
<th>Date</th>
<th>Action</th>
</tr>

<?php

$where = "";

if(isset($_GET['search'])){
$search = mysqli_real_escape_string($conn,$_GET['search']);
$where .= " title LIKE '%$search%' ";
}

if(isset($_GET['category'])){
$category = mysqli_real_escape_string($conn,$_GET['category']);

if($where!=""){
$where .= " AND category='$category'";
}else{
$where = " category='$category'";
}

}

if($where!=""){
$query = "SELECT * FROM news WHERE $where ORDER BY id DESC";
}else{
$query = "SELECT * FROM news ORDER BY id DESC";
}

$result = mysqli_query($conn,$query);

while($row = mysqli_fetch_assoc($result)){

?>

<tr>

<td><?php echo $row['title']; ?></td>

<td><?php echo $row['category']; ?></td>

<td><?php echo $row['created_at']; ?></td>

<td>
<a href="edit_news.php?id=<?php echo $row['id']; ?>">Edit</a> |
<a href="delete_news.php?id=<?php echo $row['id']; ?>">Delete</a>
</td>

</tr>

<?php
}
?>

</table>

</div>

<div class="sidebar">



<h3>Latest Updates</h3>

<ul>

<?php

$latest = mysqli_query($conn,"SELECT * FROM news ORDER BY id DESC LIMIT 5");

while($l = mysqli_fetch_assoc($latest)){
?>

<li><?php echo $l['title']; ?></li>

<?php
}
?>

</ul>

</div>

</div>

<div class="footer">
Digital News Management System
</div>

</body>
</html>