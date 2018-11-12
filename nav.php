<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href=<?php echo CONTEXT=="main" ? "#" : "../" ; ?>>MarketPlace</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
    </ul>
    <form class="form-inline my-2 my-lg-0">


      <?php $pending_claims = pending_to_claim(); if($GLOBALS["logged"]){ if(CONTEXT!="profile"){ ?>
      <a class="text-white btn btn-primary my-2 my-sm-0 mr-3" href="/profile.php" <?php if($pending_claims){ echo 'data-toggle="tooltip data-placement="bottom" title="You have '.$pending_claims.' item to claim"'; } ?>>Profile <?php 
        if($pending_claims>0) { ?>
          <span class="badge badge-light"> <?php echo $pending_claims; ?> </span>
        <?php } ?>
        </a>
      <?php } ?>
      <a class="text-danger btn btn-outline-danger my-2 my-sm-0" href="/logout.php">Log out</a>
      <?php }else{ ?>
      <a class="text-white btn btn-primary my-2 my-sm-0" href="/login.php">Log in</a>
      <?php } ?>
    </form>
  </div>
</nav>