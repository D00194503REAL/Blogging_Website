<?php
require_once 'header.php';
?> 
<title>Registration</title>    

<?php
/* Show error message for any user input errors if this form was previously submitted */
if (isset($_SESSION["error_message"])) {

    echo '<div class="messageDivClear"><div class="text"><div class="text-inner"><h1 id="errorHeading"> Message </h1><h2 id="errorText">' . $_SESSION["error_message"] . '</h2><div id="home" class="button"><h3 id="homeHeadingClear"> Okay </h3></div></div></div></div>';

    unset($_SESSION["error_message"]);
}
?>  


<div class="container">
    <div class="row">

        <div class="limiter">
            <div class="container-login100">
                <div class="wrap-login100"> 
                    <form class="login100-form validate-form" action="confirm_registration_transaction.php" method="post">
                        <span class="login100-form-title p-b-26">
                            Confirm Registration 
                        </span>
                        <span class="login100-form-title p-b-48">
                            <a href="index.php"><img style="width: 6em; height: 6em;" src="img/travblog.png" alt=""/></a>
                        </span>

                        <input type="hidden" id ="token" name = "token">

                        <div class="wrap-input100 validate-input" data-validate = "Please enter a proper name">
                            <input type="text" autocomplete="off" id = "name" class="input100" type="text" name="name" required autofocus>
                            <span class="focus-input100" data-placeholder="Name"></span>
                        </div> 

                        <div class="wrap-input100 validate-input" data-validate = "Please tell us something about yourself">
                            <input type="text" autocomplete="off" id = "description" class="input100" type="text" name="description" required autofocus>
                            <span class="focus-input100" data-placeholder="Tell us about yourself"></span>
                        </div> 

                        <div class="wrap-input100 validate-input" data-validate="Enter password">
                            <span class="btn-show-pass">
                                <i class="zmdi zmdi-eye"></i>
                            </span>
                            <input id = "password" class="input100" type="password" name="password" required>
                            <span class="focus-input100" data-placeholder="Password"></span>
                        </div>

                        <div class="wrap-input100 validate-input" data-validate="Confirm password">
                            <span class="btn-show-pass">
                                <i class="zmdi zmdi-eye"></i>
                            </span>
                            <input id = "password" class="input100" type="password" name="confirmPassword" required>
                            <span class="focus-input100" data-placeholder="Confirm Password"></span>
                        </div>

                        <div class="wrap-input100 validate-input" id="countyMain" data-validate="Enter country">  

                            <input type="text" name="country" autocomplete="off" id="country" class="country input100">

                            <span class="focus-input100" data-placeholder="Country"></span>
                            <div id="countryList"></div> 
                        </div>

                        <div class="wrap-input100 validate-input" id="countyMain" data-validate="Enter county">  

                            <input type="text" name="county"  id="county" autocomplete="off" class="input100 county">

                            <span class="focus-input100" data-placeholder="County"></span>
                            <div id="countyList"></div> 
                        </div>

                        <div class="wrap-input100 validate-input" id="townMain" data-validate="Enter town">  

                            <input type="text" name="town"  id="town" autocomplete="off" class="input100 town">

                            <span class="focus-input100" data-placeholder="Town"></span>
                            <div id="townList"></div> 
                        </div>
                        <script>
                            /* get the 'token' from the url */
                            function getURLValue(name)
                            {
                                name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
                                var regexS = "[\\?&]" + name + "=([^&#]*)";
                                var regex = new RegExp(regexS);
                                var results = regex.exec(window.location.href);
                                if (results === null)
                                    return null;
                                else
                                    return results[1];
                            }

                            document.getElementById('token').value = getURLValue('token');
                        </script>



                        <div class="container-login100-form-btn">
                            <div class="wrap-login100-form-btn">
                                <div class="login100-form-bgbtn"></div>
                                <button class="login100-form-btn" type="submit">
                                    Create Account
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <div id="dropDownSelect1"></div>




    </div>
</div>
<!-- Page Footer-->
<?php
require_once 'footer.php';
?>
</body>
</html>