<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- <script src="jquery-3.4.1.min.js"></script>
<script>
$(document).ready(function() {

        $('#nav-dash').click(function() {
            $('#content').load('seminars.php');
            return false;
        });

    }); -->
</script>
<style>
body {
  font-family: "Lato", sans-serif;
}

.sidenav {
  height: 100%;
  width: 160px;
  position: fixed;
  z-index: 1;
  top: 0;
  left: 0;
  background-color: #FECE1A;
  overflow-x: hidden;
  padding-top: 20px;
}

.sidenav a {
  padding: 6px 8px 6px 16px;
  text-decoration: none;
  font-size: 25px;
  color: #181A1C;
  display: block;
}

.sidenav a:hover {
  color: #f1f1f1;
}

.main {
  margin-left: 160px; /* Same as the width of the sidenav */
  /* font-size: 28px; /* Increased text to enable scrolling */ */
  padding: 0px 10px;
}
@media screen and (max-height: 450px) {
  .sidenav {padding-top: 15px;}
  .sidenav a {font-size: 18px;}
}
</style>
</head>
<body>
<div class="sidenav">
  <a href="#Dashboard" id="nav-dash">Dashboard</a>
  <a href="#Profile">Profile</a>
  <a href="#Logout">Logout</a>
</div>
<div class="main" id="content">
  <br/>
  <br/>
<?php include("seminars.php"); ?>
</div>
</body>
</html>
