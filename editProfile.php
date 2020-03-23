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
        body{position:relative;top:20px;}
      
        
    </style>
	</head>
	<body>

	<div class="imgtest">
	  <figure>
	    <div id="picture">
		<img src="dog.jpg"/>
		</div>

	  </figure>
	</div>
     
	
	<div id="detail">

	<p>
    <input name="" type="text"  value="First Name" style="width:450px;height:30px;"/>  <input name="" type="text"  value="Family Name"style="width:450px;height:30px;"/>
	</p>

    <p>
	<input name="" type="text"  value="Phone Number" style="width:450px;height:30px;"/>  <input name="" type="text"  value="Email Address"style="width:450px;height:30px;"/>
    </p>

	<p>
    <textarea name="" type="text" style="width:905px;height:60px;">Default Short Biogrphy</textarea>
	</p>

	<p>
	<textarea name="" type="text" style="width:905px;height:90px;">Default Long Biogrphy</textarea> 
	</p>

	<p>
    <input name="" type="text"  value="Website" style="width:905px;height:30px;"/> 
	</p>
	
	<p>
	<input name="" type="text"  value="Facebook" style="width:450px;height:30px;"/>  <input name="" type="text"  value="Linkedln"style="width:450px;height:30px;"/>
	</p>
	
	<p>
	<input name="" type="text"  value="Instagram" style="width:450px;height:30px;"/>  <input name="" type="text"  value="Twitter"style="width:450px;height:30px;"/>
	</p>
	
	</div>
	<div id="edit">
	<p><button type="submit" style="float:right;margin-left:20px;color:white;background-color:black; border-color: black; width:100px;"> Cancel </button></p>
	<p><button type="submit" style="float:right;color:black;background-color:#FECE1A; border-color: #FECE1A; width:100px;"> Save </button></p>
	</div>

	</body>
	</html>