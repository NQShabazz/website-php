<?php
// Personal Home Page or PHP: Hypertext Processor
include '../defaults.inc.php';
$to_root=get_rel_path(__DIR__, 'C:/Users/Nazaire/Desktop/My Projects/website/website-php');

$title='Energy Rush';
$dashed_title=str_replace(' ', '-', strtolower($title));
$image_rpath="../assets/images/".$dashed_title."/thumbnail.gif";
$tags="game java processing";
$excerpt="snake + tron";

$trimmed_excerpt=$excerpt;

if(strlen($trimmed_excerpt) > 255);
  $trimmed_excerpt=substr($trimmed_excerpt, 0, 252).'...';

$page_title=$title.' - Nazaire Shabazz';
$page_description=$trimmed_excerpt;

//RESOLVE DIR PROBLEM
$blog_path="C:/Users/Nazaire/Desktop/My Projects/website/nqshabazz.github.io/".$dashed_title;
start_doc($blog_path);
?>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mydatabase";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: ".$conn->connect_error);
}
?>
  <main id="post-page">
    <article id='blog-post' class='md-size m-auto'>
      <h1 class="default-box" id="front-page-introduction"><?php echo $title ?></h1>
      <a class="text-muted">
        by Nazaire Shabazz | <time datetime="<?php echo date('c') ?>" title="<?php echo date('n/d/y h:i:s a') ?>"><?php echo date('n/d/y h:i:s a') ?></time>
      </a>
      <p id="post-tags">
        <?php foreach(explode(' ', $tags) as $tag) echo "<a class='badge badge-default' href='../blog/#".$tag."'>".$tag."</a>" ?>
      </p>
      <hr class="default-box" id="front-page-loading-bar" />
      <img src="<?php echo $image_rpath ?>"/>
      <div id="content-container" class="bg-faded">
        <p><?php echo $excerpt ?></p>
        <p> Made in Java Processing.</p>
        <hr/>
      </div>
      <address class="bg-faded">
        questions / suggestions? Get in touch:
        <p>
          <a href="https://twitter.com/nqshabazz" rel="nofollow" target="_blank" ><span class="fa fa-twitter"></span> @nqshabazz</a> |
          <a href="mailto:nqshabazz@gmail.com">nqshabazz@gmail.com</a>
        </p>
      </address>
      <div id="disqus_thread"></div>
      <script>
        /**
         *  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
         *  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables
         */
        /*
        var disqus_config = function () {
            this.page.url = PAGE_URL;  // Replace PAGE_URL with your page's canonical URL variable
            this.page.identifier = PAGE_IDENTIFIER; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
        };
        */
        (function() {  // DON'T EDIT BELOW THIS LINE
            var d = document, s = d.createElement('script');

            s.src = 'https://nqshabazz.disqus.com/embed.js';

            s.setAttribute('data-timestamp', +new Date());
            (d.head || d.body).appendChild(s);
        })();
      </script>
      <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
    </article>
  </main>
<?php
//Personal Home Page

//title, reg_date, image_rpath, tags, excerpt
$table = "myprojects";
$sql = "SELECT * FROM ".$table." WHERE title='".$title."'";
$result = $conn->query($sql);

if($result->num_rows<=0){
  $sql0 = "INSERT INTO ".$table." (title, image_rpath, tags, excerpt)
  VALUES ('".$title."', '".$image_rpath."', '".$tags."', '".$trimmed_excerpt."')";
  
  if($conn->query($sql0)!==TRUE){
      echo "Error: ".$sql0."<br>".$conn->error;
  }
}else{
  $sql0 = "UPDATE ".$table." SET title='".$title."', reg_date=CURRENT_TIMESTAMP, image_rpath='".$image_rpath."', tags='".$tags."', excerpt='".$trimmed_excerpt."' WHERE title='".$title."'";
  
  if($conn->query($sql0)!==TRUE){
      echo "Error: ".$sql0."<br>".$conn->error;
  }
}

$conn->close();
?>
<?php
// Personal Home Page or PHP: Hypertext Processor
end_doc();
?>