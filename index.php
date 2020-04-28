<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login Page</title>
    <link rel="stylesheet" type="text/css" href="BMI2LoginStyleSheet.css">
</head>
<body>
    <div class="wrapper">
        <header>
            <div id="LogoDiv">
                <a href="https://www.bookmein2.com">
                    <img src="logo.png" alt="BookMeIn2" id="Logo">
                </a>
            </div>
        </header>
        <div id="content">
            <div class="container">
                <div class="row">
                    <div class="col" id="BlackSpace">
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-0 col-sm-0 col-md-2" id="BlackSpace">
                    </div>
                    <div class="col" id="LoginFormArea">
                        <form action='login.php' method='post' id="LoginForm">
                            <div class="form-group">
                                <label id="LoginLabel">Login</label>
                            </div>
                            <div class="form-group">
                                <label for="eventref" id="labelStyle">Event Reference</label>
                                <input type="text" name="eventref" class="form-control" id="eventref" placeholder="Event Reference">
                            </div>
                            <div class="form-group">
                                <label for="username" id="labelStyle">Username</label>
                                <input type="text" name="username" class="form-control" id="username" placeholder="Username">
                                <!-- change to type="email" -->
                            </div>
                            <div class="form-group">
                                <label for="password" id="labelStyle">Password</label>
                                <input type="password" name="password" class="form-control" id="password" placeholder="Password">
                            </div>
                            <button type='submit' class="btn btn-primary" id='loginbutton'>Login</button>
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
        <footer>
            <div class="TandC-PrivacyStatment">
                <a href="https://www.bookmein2.com/App_Terms_BMi2_v2_1_5-v002.pdf">Terms and Conditions and Privacy Statement</a>
            </div>
        </footer>
    </div>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>
