
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
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link href='https://fonts.googleapis.com/css?family=Cabin+Sketch' rel='stylesheet' type='text/css'>
        <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
        <script src="js/bootstrap.min.js"></script>
       
       
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
                                  <a class="navbar-brand" href="index.php">GenTree</a>
                                </div>

                                <!-- Collect the nav links, forms, and other content for toggling -->
                                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                                  
                                  <ul class="custom-nav nav navbar-nav navbar-right">
                                    <!-- <li><a href="#">Login</a></li>-->
                                    <li><a href="register.php">Register</a></li> 
                                    
                                  </ul>
                                </div><!-- /.navbar-collapse -->
                              </div><!-- /.container-fluid -->
                            </nav>
                        </div>
                    </div>
                </div>
            </header>
            <section class="content-1" id="content-1">
                <div class="container" >
                    <div class="row">
                        <div class="col-lg-8 col-md-8 col-sm-8 col-lg-offset-2 col-md-offset-2 col-sm-offset-2 col-xs-12">
                            
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12" align="center">
                                    <form class="form-signin" action="" onsubmit="return checkForm()" method="post" > 
                                        <h2 class="form-signin-heading text-center">Please enter Teacher ID</h2>
                                        <div class="row">
                                            <div class="col-md-6 col-xs-12">
                                                <span class="input_d input--ichiro">
                                                    <input class="input__field input__field--ichiro" type="text" id="input-1" name="teacher_id"/>
                                                    <label class="input__label input__label--ichiro" for="input-1">
                                                        <span class="input__label-content input__label-content--ichiro">Teacher Id</span>
                                                    </label>
                                                </span>
                                            </div>
                                            <div class="col-md-6 col-xs-12">
                                                <span class="input_d input--ichiro">
                                                    <input class="input__field input__field--ichiro" type="password" id="input-2" name="password"/>
                                                    <label class="input__label input__label--ichiro" for="input-2">
                                                        <span class="input__label-content input__label-content--ichiro">Password</span>
                                                    </label>
                                                </span>
                                            </div>
                                        </div>
                                        <!-- <label for="inputEmail" class="sr-only">pass</label>
                                        <input style="border-bottom-left-radius:0;border-bottom-right-radius:0;" type="number" id="passkey" class="form-control" placeholder="passkey" 
                                        name="passkey" required="" autofocus="">
                                        <label for="inputEmail" class="sr-only">password</label>
                                        <input style="border-radius:0;" type="number" id="passkey" class="form-control" placeholder="passkey" 
                                        name="passkey" required="" autofocus=""> -->
                                        <button style="margin:0 1em;" class="btn btn-lg btn-primary " type="submit">Submit</button>
                                    </form>
                                </div>
                            </div> 
                        </div>
                    </div>
                </div>
            </section>
        </div>
        
        
        <script src="js/classie.js"></script>
        <script>
            (function() {
                // trim polyfill : https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/String/Trim
                if (!String.prototype.trim) {
                    (function() {
                        // Make sure we trim BOM and NBSP
                        var rtrim = /^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g;
                        String.prototype.trim = function() {
                            return this.replace(rtrim, '');
                        };
                    })();
                }

                [].slice.call( document.querySelectorAll( 'input.input__field' ) ).forEach( function( inputEl ) {
                    // in case the input is already filled..
                    if( inputEl.value.trim() !== '' ) {
                        classie.add( inputEl.parentNode, 'input--filled' );
                    }

                    // events:
                    inputEl.addEventListener( 'focus', onInputFocus );
                    inputEl.addEventListener( 'blur', onInputBlur );
                } );

                function onInputFocus( ev ) {
                    classie.add( ev.target.parentNode, 'input--filled' );
                }

                function onInputBlur( ev ) {
                    if( ev.target.value.trim() === '' ) {
                        classie.remove( ev.target.parentNode, 'input--filled' );
                    }
                }
            })();
        </script>
    </body>
</html>