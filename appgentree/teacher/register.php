
<?php
require_once "recptcha.php";
?>
<!DOCTYPE html>
<html lang="en" class="no-js demo-1">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <title>GenTree</title>
        <meta name="description" content="" />
        <meta name="keywords" content="" />
        <meta name="author" content="VikOm" />
        <link rel="shortcut icon" href="favicon.ico"> 
        <!-- <link href="css/bootstrap.min.css" rel="stylesheet"> -->
        
        <link href='https://fonts.googleapis.com/css?family=Cabin+Sketch' rel='stylesheet' type='text/css'>
        <!-- ===========Angular files========== -->
        <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" rel="stylesheet">
        
         <script src='https://www.google.com/recaptcha/api.js'></script>
        <script src="js/angular-recaptcha.min.js"></script>
        <script src="../alert/alertify.min.js"></script>
        <link href="../alert/alertify.core.css" rel="stylesheet" type="text/css" />
        <link href="../alert/alertify.default.css" rel="stylesheet" type="text/css" />
       <!-- ===========angular files ends========== -->
       <link rel="stylesheet" type="text/css" href="../css/style.css">

      <script type="text/javascript">
         function validate()
         {  
             if(!isValidPassord(document.signinform.password1.value))
              { 
               
                document.getElementById("password1").focus();
                alertify.alert("The password must contain atleast one lowercase and uppercase and one alpha numeric character and atleast 8 character.");
                // document.getElementById("passwordvalue").style.color="red";
                // document.getElementById("passwordvalue").style.display="block";
                return false;
              }
             
              return true;
         }

         function isValidPassord(pass)
         {
          
           var re = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}/;
           return re.test(pass);
         }
      </script>

    </head>
    <body>
        <div class="wrapper" id="wrapper">
            <header id="header">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <nav class="navbar">
                              <div class="container-fluid">
                                <!-- Brand and toggle get grouped for better mobile display -->
                                <div class="navbar-header">
                                  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                                    <span class="sr-only">Toggle navigation</span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                  </button>
                                  <a class="navbar-brand" href="home.php">GenTree</a>
                                </div>

                                <!-- Collect the nav links, forms, and other content for toggling -->
                                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                                  
                                  <ul class="custom-nav nav navbar-nav navbar-right">
                                    <!-- <li><a href="#">Login</a></li>-->
                                    <li><a href="/admin/index.php">Login</a></li> 
                                    
                                  </ul>
                                </div><!-- /.navbar-collapse -->
                              </div><!-- /.container-fluid -->
                            </nav>
                        </div>
                    </div>
                </div>
            </header>
            <section class="content-1" id="content-1">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-lg-offset-3 col-md-offset-3 col-sm-offset-3 col-xs-12" >
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12 register-form">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 register-head text-center">
                                            Please enter your details
                                        </div>
                                    </div>
                                    <form style="padding: 15px;" role="form" name="signinform" onsubmit="return(validate());"  method="POST" action="/admin/register_redirect.php">
                                        
                                        <div class="row">
                                            <div class="form-group col-md-6 col-xs-12 form-register-group">
                                                <label for="fname">First Name</label>
                                                <input type="text" name="fname" id="fname" class="firstname form-control" 
                                                placeholder="Enter first name" required/>
                                                
                                            
                                            </div>
                                            <div class="col-md-6 col-xs-12 form-group form-register-group">
                                                <label for="lname">Last Name</label>
                                                <input type="text"  name="lname" id="lname" class="lastname form-control" 
                                                placeholder="Enter last name" required/>
                                                
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 col-xs-12 form-group form-register-group">
                                                <label for="email">Email</label>
                                                <input type="email"  name="email" id="email" class="email form-control" 
                                                placeholder="Enter your Email" required/>
                                             
                                            </div>
                                        </div>
                                        <div class="row">
                                          <div class="col-md-12 col-xs-12 form-register-group">
                                            <div class="row">
                                                <div class="col-md-12 col-xs-12 form-group">
                                                    <label for="passw1">Password</label>
                                                    <input class="password form-control" type="password" id="password1" name="password1"  placeholder="Password" required>
                                                    <div class="error">
                                                      
                                                      <span id="passwordvalue" style="display: block;">The password must contain atleast one lowercase and uppercase and one alpha numeric character and atleast 8 character.</span>
                                                      
                                                    </div>
                                                </div>
                                            </div>
                                          </div>

                                       

                                        </div>
                                        
                                        
                                        <div class="row">
                                          <div class="col-md-12 col-xs-12 text-center form-group form-register-group">
                                      
                                            <div class="form-group">
                                                <div class="col-sm-12" align="center">
                                                  <div class="g-recaptcha" data-sitekey="6LdluR8TAAAAALSWMEqcqrrsBXWyaO3wOscWd2nR"></div>
                                                </div>
                                              </div>
                                           </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 col-xs-12 fom-group text-center form-register-group">
                                            <button type="submit" class="btn btn-success btn-lg">Submit</button>
                                                <!-- <button class="btn btn-lg btn-success" ng-disabled="error || incomplete">&#10004; Submit</button> -->
                                            </div>
                                        </div>
                                    </form>
                                    
                                </div>
                            </div> 
                        </div>
                    </div>
                </div>
            </section>
        </div>
        
        
    <script type="text/javascript">
         <?php
         if($_GET['emailalredy']==1)
          {
          ?>
            alertify.alert("This email address is already registered");
        <?php
          }
          if($_GET['error']==2)
          {
          ?>
            alertify.alert("Invalid Recaptcha");
        <?php
          } 
          ?>
        </script>
    </body>
</html>
