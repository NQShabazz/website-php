  <footer class='footer bg-inverse text-white text-center'>
    <p>nqshabazz@gmail.com</p><p>&copy; Nazaire Shabazz 2017</p>
  </footer>
  <script>
    document.body.classList.add("loaded");
    
    window.onload = function(){
      let anchorArray = document.getElementsByTagName("a");
      var index = anchorArray.length;

      while(index--){
        let anchorTarget = anchorArray[index].href.substring(17);
        
        if(anchorTarget.startsWith("#")){
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
      
      $('html, body').animate({scrollTop: elem.offsetTop}, 750);
    }
  </script>