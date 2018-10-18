<?php
    require_once 'header.php';
        ?> 
<title>Register</title>
  
<div class="messageDiv">
    <a class="error_close"><b>x</b></a>
    <div class="error_container"><b id="errorText"></b></div>
    
</div>

<?php
/* Show error message for any user input errors if this form was previously submitted */
if (isset($_SESSION["error_message"])) {

    echo '<div class="messageDivClear"><a class="error_close"><b>x</b></a><div class="error_container"><b id="errorText">' . $_SESSION["error_message"] . '</b></div></div>'; 
 
    unset($_SESSION["error_message"]);
}
?>  


    <div class="container">
      <div class="row">
          	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100"> 
				<form id="dkit_register_new_user_form" action="register_new_user_transaction.php" method="post">
					<span class="login100-form-title p-b-26">
						Register 
					</span>
					<span class="login100-form-title p-b-48">
                                            <a href="index.php"><img id="travelerBlog" style="width: 6em; height: 6em;" src="img/travblog.png" alt=""/></a>
					</span>
                                        
                                    
                                    
                                    
					<div class="wrap-input100 validate-input" data-validate = "Valid email is: a@b.c">
                                            <input type="email" autocomplete="off" id = "email" class="input100" type="email" name="email" required autofocus>
						<span class="focus-input100" data-placeholder="Email"></span>
					</div> 
  
					<div class="wrap-input100 validate-input" data-validate="Valid email is: a@b.c">
						<input type="email" autocomplete="off" id = "confirmEmail" class="input100" type="email" name="confirmEmail" required>
						<span class="focus-input100" data-placeholder="Confirm email"></span>
					</div>
                                    
                                    

					<div class="container-login100-form-btn">
						<div class="wrap-login100-form-btn">
							<div class="login100-form-bgbtn"></div>
                                                        <button class="login100-form-btn" id="emailRegister" type="submit">
								Register 
							</button>
						</div>
					</div>
                                    <br><br>
                                    <div class="g-recaptcha" data-callback="capcha_filled" data-expired-callback="capcha_expired" data-sitekey="6Le5lVMUAAAAAMIl8QNLVCKTSodwrKWqIh7KwJru"></div>
                                    
                                    <div class="text-center p-t-115">
						<span class="txt1">
							Already have an account?
						</span>

						<a class="txt2" href="login.php">
							Login now!
						</a> 
					</div>
				</form>
			</div>
		</div>
	</div> 
          
          
          
        
      </div>
    </div>

<?php
    require_once 'footer.php';
        ?>
<script src="js/validateEmail.js" type="text/javascript"></script>
  </body>
</html>