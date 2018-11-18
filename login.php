<!DOCTYPE html>
<?php 
    define("PAGE", "Login");
    define("CONTEXT", "login");
    include("head.php");
    ses_start();
    validate_session();
    if($GLOBALS["logged"]){
        header("Location: ../");
        die();
    }

    // Just use for feedback
    $valid_account = true;

    if(isset($_POST["name"]) && isset($_POST["pin"])){
        $name = $_POST["name"];
        $pin = $_POST["pin"];

        $account = new Account($name);

        if(isset($account->uuid)){
            if($account->compare_password($pin)){
                login_user($account);
                header("Location: ../");
                die();
            }else{
                $valid_account = false;
            }
        }else{
            $valid_account = false;
        }
    }
?>
<body>
<div class="container" style="height:100vh;">
    <div class="row align-items-center justify-content-center" style="height:100vh;">
        <div class="col col-10 col-lg-9 col-xl-6">
            <div class="card bg-inventory text-light">
                <div class="card-body">
                    <h3 class="card-title color-f minefont">Log in</h3>
                    
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                        <div class="form-group">
                            <label for="name" class="color-f minefont">Minecraft Username</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="pin" class="color-f minefont">Pin</label>
                            <input type="password" class="form-control" id="pin" name="pin" required>
                        </div>
                        <button type="submit" class="btn btn-primary color-f minefont">Log in</button>
                        <a href="setpin.php" class="mx-2 color-3 minefont">Forgot / Register Instructions</a>
                    </form>

                    <?php if(!$valid_account) { ?>
                    <div class="alert alert-danger mt-4 color-c minefont" role="alert">Error: Invalid name or password</div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>