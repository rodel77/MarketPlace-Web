<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand color-f minefont" href=<?php echo CONTEXT=="main" ? "#" : "../" ; ?>>MarketPlace</a>

    <form class="form-inline my-2 my-lg-0">


      <?php $pending_claims = pending_to_claim(); if($GLOBALS["logged"]){ if(CONTEXT!="profile"){ ?>
      <span class="mx-2 color-6 minefont">12$</span>
      <a class="text-white btn btn-primary my-2 my-sm-0 mr-3 color-f minefont" href="/profile.php" <?php if($pending_claims){ echo 'data-toggle="tooltip data-placement="bottom" title="You have '.$pending_claims.' item to claim"'; } ?>>Profile <?php 
        if($pending_claims>0) { ?>
          <span class="badge badge-light"> <?php echo $pending_claims; ?> </span>
        <?php } ?>
        </a>
      <?php } ?>
      <a class="text-danger btn btn-outline-danger my-2 my-sm-0 color-c minefont" href="/logout.php">Log out</a>
      <?php }else{ ?>
      <a class="text-white btn btn-primary my-2 my-sm-0 color-f minefont" href="/login.php">Log in</a>
      <?php } ?>
    </form>
</nav>