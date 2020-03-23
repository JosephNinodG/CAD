<!DOCTYPE html>
<html lang="en" dir="ltr">
<head><meta charset="utf-8"><link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">      
 <title>Profile</title>
    <style type="text/css">
		.imgtest{
		
		margin:10px 5px;
		overflow:hidden;}
		.list_ul figcaption p{
		font-size: 12px;
		color:#aaa;}
		.imgtest figure div{
		display:inline-block;
		margin:5px auto;
		max-width:200px;
		height:200px;
		border-radius:100px;
		border:2px solid #fff;
		overflow:hidden;
		-webkit-box-shadow:0 0 3px #ccc;
		box-shadow:0 0 3px #ccc;
		}
		.imgtest img{width:100%;
		min-height:100%;text-align:center;}

		.imgtest{text-align:center}
		#picture{margin:0 auto;}
		#edit{position:relative;top:20px;height:20px;right:175px;}
		
		#detail{
		text-align:center
		}
        body{position:relative;top:125px;}
      
        
    </style>
	</head>
	<body>

	<div id="edit">
	<form action="editProfile.php" method="post">
	<button type="submit" style="float:right;color:black;background-color:#FECE1A; border-color: #FECE1A; width:100px;"> Edit </button>
	</form>
	</div>

	<div class="imgtest">
	  <figure>
	    <div id="picture">
		<img src="dog.jpg"/>
		</div>

	  </figure>
	</div>
     
	
	<div id="detail">

	<p>
    <input name="" type="text" disabled="disabled" value="First Name" style="width:450px;height:30px;"/>  <input name="" type="text" disabled="disabled" value="Family Name"style="width:450px;height:30px;"/>
	</p>

    <p>
	<input name="" type="text" disabled="disabled" value="Phone Number" style="width:450px;height:30px;"/>  <input name="" type="text" disabled="disabled" value="Email Address"style="width:450px;height:30px;"/>
    </p>

	<p>
    <input name="" type="text" disabled="disabled" value="Default Short Biogrphy" style="width:905px;height:60px;"/> 
	</p>

	<p>
	<input name="" type="text" disabled="disabled" value="Default Long Biogrphy" style="width:905px;height:90px;"/> 
	</p>

	<p>
    <input name="" type="text" disabled="disabled" value="Website" style="width:905px;height:30px;"/> 
	</p>
	
	<p>
	<input name="" type="text" disabled="disabled" value="Facebook" style="width:450px;height:30px;"/>  <input name="" type="text" disabled="disabled" value="Linkedln"style="width:450px;height:30px;"/>
	</p>
	
	<p>
	<input name="" type="text" disabled="disabled" value="Instagram" style="width:450px;height:30px;"/>  <input name="" type="text" disabled="disabled" value="Twitter"style="width:450px;height:30px;"/>
	</p>
	
	</div>

	</body>
	</html>