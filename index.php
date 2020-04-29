<!DOCTYPE html>
<html lang="en">
<head> <!-- initialise page and import bootstrap stylesheet -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login Page</title>
    <link rel="stylesheet" type="text/css" href="BMI2LoginStyleSheet.css"> <!-- import specific page stylesheet -->
</head>
<body>
    <div class="wrapper">
        <header> <!-- Place BookMeIn2 logo in header with embedded link to redirect to main website -->
            <div id="LogoDiv">
                <a href="https://www.bookmein2.com">
                    <img src="logo.png" alt="BookMeIn2" id="Logo">
                </a>
            </div>
        </header>
        <div id="content"> <!-- Main content goes here -->
            <div class="container"> <!-- bootstrap container used (not container-fluid as that is full page width) -->
                <div class="row">
                    <div class="col" id="BlackSpace"> <!-- div block for page structure -->
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-0 col-sm-0 col-md-2" id="BlackSpace"> <!-- col used to help center login form (cols are removed at certain page size) -->
                    </div>
                    <div class="col" id="LoginFormArea">
						<?php if(isset($_GET['badpass'])){
								if($_GET['badpass'] == 1) {
									echo "<div class='alert alert-danger' role='alert'>Incorrect login information provided</div>";
								}
								if ($_GET['badpass'] == 2) {
									echo "<div class='alert alert-danger' role='alert'>Couldn't retrieve user profile</div>";
								}
						}?> <!-- login error message displayed if login.php returns badpass -->
                        <form action='login.php' method='post' id="LoginForm"> <!-- login form created that is linked to the login.php file -->
                            <div class="form-group">
                                <label id="LoginLabel">Login</label>
                            </div>
                            <div class="form-group">
                                <label for="eventref" id="labelStyle">Event Reference</label>
                                <input type="text" name="eventref" class="form-control" id="eventref" placeholder="Event Reference"> <!-- Event ref input box (bootstrap class used) -->
                            </div>
                            <div class="form-group">
                                <label for="username" id="labelStyle">Username</label>
                                <input type="text" name="username" class="form-control" id="username" placeholder="Username"> <!-- username input box (bootstrap class used) -->
                                <!-- change to type="email" -->
                            </div>
                            <div class="form-group">
                                <label for="password" id="labelStyle">Password</label>
                                <input type="password" name="password" class="form-control" id="password" placeholder="Password"> <!-- password input box (bootstrap class used) -->
                            </div>
                            <button type='submit' class="btn btn-primary" id='loginbutton'>Login</button> <!-- login button (bootstrap class used) -->
                        </form>
                    </div>
                    <div class="col-xs-0 col-sm-0 col-md-2" id="BlackSpace">
                    </div>
                </div>
                <div class="row">
                    <div class="col" id="BlackSpace">
                    </div>
                </div>
            </div>
        </div>
        <footer> <!-- textlink to the BookMeIn2 Terms and Conditions and Privacy Statement -->
            <div class="TandC-PrivacyStatment">
                <a href="https://www.bookmein2.com/App_Terms_BMi2_v2_1_5-v002.pdf">Terms and Conditions and Privacy Statement</a>
            </div>
        </footer>
    </div>
	<!-- import scripts for bootstrap -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>
