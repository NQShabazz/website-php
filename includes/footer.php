  <footer class='footer'>
    <p id="social-media-footer">
      <a class='fa fa-2x fa-twitter' href="https://twitter.com/lilacsnacc" rel="nofollow" target="_blank" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="Twitter"><span class="sr-only">Twitter</span></a>
      <a class='fa fa-2x fa-youtube-play' href="https://www.youtube.com/channel/UCeg8SXBwjJ3SHyAqLhvyoTg" rel="nofollow" target="_blank" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="YouTube"><span class="sr-only">YouTube</span></a>
      <a class='fa fa-2x fa-github-alt' href="https://github.com/lilacsnacc" rel="nofollow" target="_blank" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="Github"><span class="sr-only">Github</span></a>
      <a class='fa fa-2x fa-linkedin' href="https://www.linkedin.com/in/nqshabazz/" rel="nofollow" target="_blank" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="LinkedIn"><span class="sr-only">LinkedIn</span></a>
      <a class='fa fa-2x fa-envelope' href='mailto:lilacsnacc@gmail.com' data-toggle="popover" data-trigger="hover" data-placement="top" data-content="lilacsnacc@gmail.com"><span class="sr-only">Email</span></a>
    </p>
    <p>&copy; Nazaire Shabazz / Lilac Snacc LLC 2020 <span style="float: right">(made with PHP and mySQL)</span></p>
  </footer>
  <script>
    document.body.classList.add("loaded");
    
    window.onload = function(){
      let anchorArray = document.getElementsByTagName("a");
      var index = anchorArray.length;

      while(index--){
        let anchorTarget = anchorArray[index].getAttribute("href");
        
        if(anchorTarget && anchorTarget.startsWith("#")){
          let anch = anchorArray[index];
          
          anch.addEventListener("click", function(event) {
            event.preventDefault();
            smoothScroll(anchorTarget.substring(1));
          });
        }
      }

      if (location.hash) {
        setTimeout(function() {
          window.scrollTo(0, 0);
          smoothScroll(location.hash.substring(1))
        }, 1);
      }
    };
    
    function smoothScroll(target){
      let elem = document.getElementById(target);
      
      if(elem)
        $('html, body').animate({scrollTop: elem.offsetTop}, 250);
    }
  </script>