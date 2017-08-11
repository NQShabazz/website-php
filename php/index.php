<?php
// Personal Home Page or PHP: Hypertext Processor
include 'defaults.inc.php';
$to_root=get_rel_path(__DIR__, 'C:/Users/Nazaire/Desktop/My Projects/website/php');
start_doc(__DIR__);
?>
  <main>
    <section id='front-page'>
      <h1 class="default-box" id="front-page-introduction"><small>Hello, I'm</small><br>Nazaire Shabazz</h1>
      <hr class="default-box" id="front-page-loading-bar" />
      
      <div class="default-box" id="front-page-option-container">
        <div class="front-page-option-box-container">
          <figure class="front-page-option-box box1"></figure>
          <figure class="front-page-option-box box2"></figure>
        </div>
        <div class="front-page-option-box-container">
          <figure class="front-page-option-box box3"></figure>
          <figure class="front-page-option-box box4"></figure>
        </div>
        <div class="front-page-option-box-container">
          <a class='fa fa-twitter fa-2x front-page-option-box box5' href="https://twitter.com/nqshabazz" rel="nofollow" target="_blank" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="Twitter"><span class="sr-only">Twitter</span></a>
          <a class='fa fa-youtube-play fa-2x front-page-option-box box5' href="https://www.youtube.com/channel/UCwlgvHxHkWjNCsCm9byUEUg" rel="nofollow" target="_blank" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="YouTube"><span class="sr-only">YouTube</span></a>
          <a class='fa fa-github-alt fa-2x front-page-option-box box5' href="https://github.com/nqshabazz" rel="nofollow" target="_blank" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="Github"><span class="sr-only">Github</span></a>
          <a class='fa fa-linkedin fa-2x front-page-option-box box5' href="https://www.linkedin.com/in/nqshabazz/" rel="nofollow" target="_blank" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="LinkedIn"><span class="sr-only">LinkedIn</span></a>
        </div>
      </div>
    </section>
  </main>
<?php
// Personal Home Page or PHP: Hypertext Processor
end_doc();
?>