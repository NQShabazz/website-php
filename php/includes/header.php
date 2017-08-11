<?php
//Personal Home Page or PHP: Hypertext Processor
global $to_root;
?>
  <nav id='topbar' class='fixed-top d-flex flex-wrap justify-content-end align-items-center' role="navigation">
    <a class='text-lowercase ml-auto align-items-top' data-toggle="collapse" data-target="#link-nav" aria-expanded="false" aria-controls="navbar">
      <img alt="my logo" src="../../assets/images/header-image.png"/>
      <span class="sr-only">Toggle navigation</span>
    </a>
    
    <nav id="link-nav" class='navbar-collapse collapse'>
      <div>
        <a class='fa fa-code' href='<?php echo $to_root ?>/#projects' data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="Projects"><span class="sr-only">Projects</span></a> /
        <a class='fa fa-smile-o' href='<?php echo $to_root ?>/#about' data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="About Me"><span class="sr-only">About Me</span></a> /
        <a class='fa fa-envelope' href='<?php echo $to_root ?>/#contact' data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="nqshabazz@gmail.com"><span class="sr-only">Contact</span></a> /
        <a class='fa fa-commenting-o' href='<?php echo $to_root ?>/blog' data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="Blog"><span class="sr-only">Blog</span></a>
      </div>
      <div>
        <a class='fa fa-twitter' href="https://twitter.com/nqshabazz" rel="nofollow" target="_blank" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="Twitter"><span class="sr-only">Twitter</span></a> /
        <a class='fa fa-youtube-play' href="https://www.youtube.com/channel/UCwlgvHxHkWjNCsCm9byUEUg" rel="nofollow" target="_blank" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="YouTube"><span class="sr-only">YouTube</span></a> /
        <a class='fa fa-github-alt' href="https://github.com/nqshabazz" rel="nofollow" target="_blank" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="Github"><span class="sr-only">Github</span></a> /
        <a class='fa fa-linkedin' href="https://www.linkedin.com/in/nqshabazz/" rel="nofollow" target="_blank" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="LinkedIn"><span class="sr-only">LinkedIn</span></a>
      </div>
    </nav>
  </nav>