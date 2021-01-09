<?php
    $default_config = include("default-config.php");

    define("MP_PROTOCOL", "2");

    if(file_exists("config.php")){
        $loaded_config = include("config.php");

        foreach ($loaded_config as $key => $value) {
            define($key, $value);
        }
    }

    foreach ($default_config as $key => $value) {
        if(!defined($key)){
            define($key, $value);
        }
    }

    include("src/db_manager.php");
    if(WEB_ACCOUNTS_ENABLED){
        start_session();
        validate_session();
    }

    include("src/nbt.class.php");
    include("src/utils.php");
    include("src/accounts.php");
    include("src/sync_info.php");
    include("src/listings.php");
    include("src/session_manager.php");
    include("src/items.php");
?>

<head>
    <meta charset="UTF-8">
    <title>MarketPlace Web - <?php echo PAGE; ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="css/tooltip.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment-with-locales.min.js"></script>
    <script>moment.locale("<?php echo MOMENT_LANG; ?>")</script>
</head>

<?php
    $mp_protocol = get_protocol();
    if($mp_protocol!=MP_PROTOCOL){
        ?>
<body>
    <div class="container" style="height:100vh;">
        <div class="row align-items-center justify-content-center" style="height:100vh;">
            <div class="col col-10 col-lg-9 col-xl-6">
                <div class="card bg-inventory text-light">
                    <div class="card-body">
                    <h3 class="card-title color-f minefont">Protocol Mismatch!</h3>

                    <p class="color-f minefont">> MarketPlace plugin request protocol <span class="color-a"><?php echo $mp_protocol; ?></span></p>
                    <p class="color-f minefont">> WebMarket is still on protocol <span class="color-4"><?php echo MP_PROTOCOL; ?></span></p>
                    <p class="color-6 minefont">Please update your WebMarket version in order to continue: <a href="https://github.com/rodel77/MarketPlace-Web">https://github.com/rodel77/MarketPlace-Web</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
        <?php
        die();
    }
?>