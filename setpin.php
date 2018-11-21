<!DOCTYPE html>
<?php 
    define("PAGE", "Set pin");
    define("CONTEXT", "setpin");
    include("head.php");
    ses_start();
    validate_session();
?>
<body>
<div class="container" style="height:100vh;">
    <div class="row align-items-center justify-content-center" style="height:100vh;">
        <div class="col col-10 col-lg-9 col-xl-6">
            <div class="card bg-inventory text-light">
                <div class="card-body">
                    <h3 class="card-title color-f minefont">How to create/reset a pin</h3>

                    <ul>
                        <li class="color-f minefont">Join in the server</li>
                        <li class="color-f minefont">Use the command <code class="color-d minefont">/mp setpin &lt;your-pin&gt;</code></li>
                        <li class="color-f minefont">Deposit some money into your wallet using <code class="color-d minefont">/mp wallet deposit &lt;amount&gt;</code></li>
                        <li class="color-f minefont">Return to <a href="<?php echo get_path("login"); ?>">log in page</a></code></li>
                        <li class="color-f minefont">Insert your Minecraft name and the pin you just have set</li>
                        <li class="color-f minefont">Enjoy purchasing in web</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>