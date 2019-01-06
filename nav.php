<nav class="navbar navbar-dark bg-dark">
  <a class="navbar-brand color-f minefont" href=<?php echo get_main_path(); ?>>MarketPlace</a>

  <?php if(WEB_ACCOUNTS_ENABLED) { ?>
      <div class="float-right">
        <?php $pending_claims = pending_to_claim(); if($GLOBALS["logged"]){ if(CONTEXT!="profile"){ ?>
        <span class="mx-2 color-6 minefont"><?php echo price_format($GLOBALS["account"]->money); ?></span>
        <a class="text-white btn btn-primary my-2 my-sm-0 mr-3 color-f minefont" href="./<?php echo get_path("profile"); ?>" <?php if($pending_claims){ echo 'data-toggle="tooltip data-placement="bottom" title="You have '.$pending_claims.' item to claim"'; } ?>>Profile <?php 
          if($pending_claims>0) { ?>
            <span class="badge badge-light"> <?php echo $pending_claims; ?> </span>
          <?php }  ?>
          </a>
        <?php } ?>
            <a class="text-danger btn btn-outline-danger my-2 my-sm-0 color-c minefont" href="./<?php echo get_path("logout"); ?>">Log out</a>
        <?php }else{ ?>
            <a class="text-white btn btn-primary my-2 my-sm-0 color-f minefont" href="./<?php echo get_path("login"); ?>">Log in</a>
        <?php } ?>
      </div>
    <?php } ?>
</nav>