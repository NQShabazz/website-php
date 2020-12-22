<?php
//Personal Home Page or PHP: Hypertext Processor
global $rootdir, $phpfolder, $to_root;
if(!isset($to_root))
  $to_root=get_rel_path(__DIR__, $rootdir.$phpfolder);
?>
  <nav id='topbar' role="navigation">
    <a href='<?php echo $to_root ?>'>
      <img alt="my logo" src="<?php echo $to_root ?>/assets/images/header-image.png"/>
      <span class="sr-only">To Home</span>
    </a>
  </nav>
  <div id="topOfPage"></div>
  <a class="fa fa-2x fa-chevron-up text-white" id="toTopButton" href="#topOfPage"></a>