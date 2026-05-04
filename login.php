<!DOCTYPE html>
<html>
<head>

<title>Journalist Login</title>

<style>

body{
font-family: Arial, sans-serif;
margin:0;
padding:0;

background-image:url("https://thumbs.dreamstime.com/b/explore-vibrant-futuristic-news-background-featuring-abstract-elements-dynamic-lighting-effects-perfect-media-366218591.jpg");
background-size:cover;
background-position:center;
height:100vh;

display:flex;
justify-content:center;
align-items:center;
}

.login-box{
background-image:url("https://www.sonicwall.com/_next/image?url=https%3A%2F%2Fimages-cms.sonicwall.com%2Fv3%2Fassets%2Fblt281ecbfc2563bf9b%2Fbltb761b8b27dbfd07b%2F6800ef5c15d4c53d8f922b0d%2FHero_homepage.png&w=3840&q=75&dpl=dpl_D1qkQGDsnYnqGMQ2yo2kPWXqJCMk");
padding:40px;
width:350px;
border-radius:10px;
box-shadow:0px 0px 20px rgba(0,0,0,0.4);
text-align:center;
}

.login-box h2{
margin-bottom:20px;
}

input{
width:100%;
padding:12px;
margin:10px 0;
border:1px solid #ccc;
border-radius:5px;
font-size:16px;
box-sizing:border-box;
}

button{
width:100%;
padding:12px;
background:#c40000;
color:white;
border:none;
border-radius:5px;
font-size:16px;
cursor:pointer;
box-sizing:border-box;
}

button:hover{
background:#a00000;
}

.title{
font-size:24px;
font-weight:bold;
color:#c40000;
margin-bottom:10px;
}

</style>

</head>

<body>

<div class="login-box">

<div class="title">LIVE NEWS</div>

<h2>Journalist Login</h2>

<form action="authenticate.php" method="POST">

<input type="text" name="username" placeholder="Username" required>

<input type="password" name="password" placeholder="Password" required>

<button type="submit">Login</button>

</form>

</div>

</body>

</html>