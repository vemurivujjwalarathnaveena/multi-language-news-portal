
<?php
include "db.php";

$result = mysqli_query($conn,"
SELECT news.id, news.title, news_media.file_name
FROM news
LEFT JOIN news_media ON news.id = news_media.news_id
GROUP BY news.id
ORDER BY news.id DESC
LIMIT 10
");
?>

<!DOCTYPE html>
<html>

<head>

<title>Web Stories</title>

<style>

/* BODY BACKGROUND */

body{
margin:0;
font-family:Arial;
height:100vh;
color:white;
overflow:hidden;

/* animated gradient */

background:linear-gradient(135deg,#0f2027,#203a43,#2c5364);
background-size:400% 400%;
animation:bgmove 15s ease infinite;
}

@keyframes bgmove{
0%{background-position:0% 50%;}
50%{background-position:100% 50%;}
100%{background-position:0% 50%;}
}

/* HEADER */

.header{
background:#c40000;
padding:15px;
text-align:center;
font-size:28px;
font-weight:bold;
}

/* BACK BUTTON */

.back-button{
position:fixed;
top:15px;
left:15px;
background:white;
color:black;
padding:8px 14px;
border-radius:6px;
font-size:14px;
text-decoration:none;
z-index:999;
font-weight:bold;
}

/* STORY AREA */

.story-container{
width:100%;
height:90vh;
display:flex;
justify-content:center;
align-items:center;
}

/* STORY CARD */

.story{
width:360px;
height:640px;
background:black;
border-radius:15px;
overflow:hidden;
position:relative;

box-shadow:
0 0 20px rgba(255,255,255,0.1),
0 0 40px rgba(0,0,0,0.6);

display:flex;
justify-content:center;
align-items:center;
}

/* MEDIA */

.story img,
.story video{
max-width:100%;
max-height:100%;
object-fit:contain;
cursor:pointer;
}

/* TITLE */

.story-title{
position:absolute;
bottom:0;

background:linear-gradient(
transparent,
rgba(0,0,0,0.9)
);

width:100%;
padding:20px;
font-size:18px;
font-weight:bold;
}

/* NAVIGATION */

.nav-btn{
position:absolute;
top:50%;
transform:translateY(-50%);
font-size:40px;
color:white;
cursor:pointer;
padding:10px;
user-select:none;
}

.prev{ left:20px; }
.next{ right:20px; }

</style>

</head>

<body>

<a href="index.php" class="back-button">← Back</a>

<div class="header">
Web Stories
</div>

<div class="story-container">

<div class="nav-btn prev" onclick="prevStory()">❮</div>

<div class="story" id="storyArea">

<div id="storyMedia"></div>

<div class="story-title" id="storyTitle"></div>

</div>

<div class="nav-btn next" onclick="nextStory()">❯</div>

</div>

<script>

let stories = [

<?php
while($row=mysqli_fetch_assoc($result)){
?>

{
id:"<?php echo $row['id']; ?>",
file:"uploads/<?php echo $row['file_name']; ?>",
title:"<?php echo addslashes($row['title']); ?>"
},

<?php } ?>

];

let current = 0;
let autoplay;

/* SHOW STORY */

function showStory(){

let file = stories[current].file;
let ext = file.split('.').pop().toLowerCase();

let mediaHTML="";

if(ext=="mp4"){

mediaHTML =
'<a href="news.php?id='+stories[current].id+'">'+
'<video autoplay muted loop>'+
'<source src="'+file+'" type="video/mp4">'+
'</video>'+
'</a>';

}else{

mediaHTML =
'<a href="news.php?id='+stories[current].id+'">'+
'<img src="'+file+'">'+
'</a>';

}

document.getElementById("storyMedia").innerHTML = mediaHTML;

document.getElementById("storyTitle").innerHTML =
'<a href="news.php?id='+stories[current].id+'" style="color:white;text-decoration:none;">'
+stories[current].title+
'</a>';

}

/* NEXT STORY */

function nextStory(){

current++;

if(current >= stories.length){
current = 0;
}

showStory();

}

/* PREVIOUS STORY */

function prevStory(){

current--;

if(current < 0){
current = stories.length-1;
}

showStory();

}

/* AUTO PLAY EVERY 3 SECONDS */

function startAutoPlay(){
autoplay = setInterval(nextStory,3000);
}

/* MOBILE SWIPE SUPPORT */

let startX = 0;

const storyArea = document.getElementById("storyArea");

storyArea.addEventListener("touchstart", e=>{
startX = e.changedTouches[0].screenX;
});

storyArea.addEventListener("touchend", e=>{

let endX = e.changedTouches[0].screenX;

if(endX < startX - 50){
nextStory();
}

if(endX > startX + 50){
prevStory();
}

});

/* START */

showStory();
startAutoPlay();

</script>

</body>

</html>
