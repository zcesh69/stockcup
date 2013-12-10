<!DOCTYPE html>
<html>
    <head>
        <title>Log In</title>
        <script type="text/JavaScript" src="js/sha512.js"></script> 
        <script type="text/JavaScript" src="js/forms.js"></script> 
    </head>
    <body>
        <?php 
        // most login related code are referenced from http://www.wikihow.com/Create-a-Secure-Login-Script-in-PHP-and-MySQL

            if(isset($_GET['error'])) { 
                echo 'Error Logging In!'; 
            } 
        ?> 
        <form action="process_login.php" 
                                 method="post" 
                                 name="login_form">
                                 Email: <input type="text" name="email" />
                                 Password: <input type="password"
                                             name="password"
                                             id="password"/>
                <input type="button"
                            value="Login"
                            onclick="formhash(this.form,
                            this.form.password);" /> 
        </form>
    </body>
</html>