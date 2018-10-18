<?php
require_once 'header.php';
?> 
<title>Login</title>

<!--<div class="limiter" id="messageDiv">
                    <div class="container-login100">
                        <div class="wrap-login100">
                            <span class="login100-form-title p-b-26">
                                <div id="message"></div> 
                                <div class="container-login100-form-btn">
                                                <div class="wrap-login100-form-btn">
                                                        <div class="login100-form-bgbtn"></div>
                                                        <button class="login100-form-btn" onclick="$('#messageDiv').fadeOut(1000);">
                                                                Ok 
                                                        </button>
                                                </div>
                                        </div>
                            </span>
                        </div>
                    </div>
                </div>-->



<div class="messageDiv">
    <a class="error_close"><b>x</b></a>
    <div class="error_container"><b id="errorText"></b></div>
    
</div>







<div class="container">
    <div class="row">




        <div class="limiter">
            <div class="container-login100">
                <div class="wrap-login100"> 
                    <form class="login100-form validate-form" id="login" method="post">
                        <span class="login100-form-title p-b-26">
                            Login 
                        </span>
                        <span class="login100-form-title p-b-48">
                            <a href="index.php"><img style="width: 6em; height: 6em;" src="img/travblog.png" alt=""/></a>
                        </span>

                        <div class="wrap-input100 validate-input" data-validate = "Valid email is: a@b.c">
                            <input type="email" autocomplete="off" id = "loginEmail" class="input100" type="text" name="email" required>
                            <span class="focus-input100" data-placeholder="Email"></span>
                        </div>

                        <div class="wrap-input100 validate-input" data-validate="Enter password">
                            <span class="btn-show-pass">
                                <i class="zmdi zmdi-eye"></i>
                            </span>
                            <input id = "loginPassword" class="input100" type="password" name="password" required>
                            <span class="focus-input100" data-placeholder="Password"></span>
                        </div>  

                        <div class="container-login100-form-btn">
                            <div class="wrap-login100-form-btn">
                                <div class="login100-form-bgbtn"></div>
                                <button class="login100-form-btn" id="loginSubmit" type="submit">
                                    Login
                                </button>
                            </div>
                        </div>

                        <div class="text-center p-t-115">
                            <span class="txt1">
                                Don’t have an account?
                            </span>

                            <a class="txt2" href="register_new_user.php">
                                Register now!
                            </a> 
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <div id="dropDownSelect1"></div>




    </div>
</div>

<?php
require_once 'footer.php';
?> 
<script src="js/validateLogIn.js" type="text/javascript"></script>
</body>
</html>