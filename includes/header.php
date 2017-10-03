<?php
//Personal Home Page or PHP: Hypertext Processor
global $to_root;
?>
  <nav id='topbar' role="navigation">
    <a href='<?php echo $to_root ?>'>
      <img alt="my logo" src="<?php echo $to_root ?>/assets/images/header-image.png"/>
      <span class="sr-only">To Home</span>
    </a>
  </nav>
  <div id="topOfPage"></div>
  <a class="fa fa-2x fa-chevron-up text-white" id="toTopButton" href="#topOfPage"></a>