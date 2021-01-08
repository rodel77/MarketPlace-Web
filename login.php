<?php 
    define("PAGE", "Login");
    define("CONTEXT", "login");
    include("head.php");
    if(WEB_ACCOUNTS_ENABLED && $GLOBALS["logged"]){
        header("Location: ".get_main_path());
        die();
    }

    // Just use for feedback
    $valid_account = true;

    if(WEB_ACCOUNTS_ENABLED && isset($_POST["name"]) && isset($_POST["pin"])){
        $name = $_POST["name"];
        $pin = $_POST["pin"];

        $account = new Account($name);

        if(isset($account->uuid)){
            if($account->compare_password($pin)){
                login_user($account);
                header("Location: ".get_main_path());
                die();
            }else{
                $valid_account = false;
            }
        }else{
            $valid_account = false;
        }
    }
?>
<!DOCTYPE html>
<body>
<div class="container" style="height:100vh;">
    <div class="row align-items-center justify-content-center" style="height:100vh;">
        <div class="col col-10 col-lg-9 col-xl-6">
            <div class="card bg-inventory text-light">
                <div class="card-body">
                    <?php if(WEB_ACCOUNTS_ENABLED) { ?>
                        <h3 class="card-title color-f minefont">Log in</h3>
                        
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                            <div class="form-group">
                                <label for="name" class="color-f minefont">Minecraft Username</label>
                                <input type="text" class="form-control" id="name" name="name" value="<?php echo isset($_POST["name"]) ? $_POST["name"] : ""; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="pin" class="color-f minefont">Pin</label>
                                <input type="password" class="form-control" id="pin" name="pin" required>
                            </div>
                            <button type="submit" class="btn btn-primary color-f minefont">Log in</button>
                            <a href="<?php echo get_path("setpin"); ?>" class="mx-2 color-3 minefont">Forgot / Register Instructions</a>
                        </form>

                        <?php if(!$valid_account) { ?>
                        <div class="alert alert-danger mt-4 color-c minefont" role="alert">Error: Invalid name or password</div>
                        <?php } ?>
                    <?php } else { ?>
                        <h3 class="card-title color-f minefont">WebAccounts disabled</h3>

                        <span class="color-f minefont">If you want to enable them, please go to the <a href="https://github.com/rodel77/MarketPlace-Web/wiki">wiki</a></span>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>