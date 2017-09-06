<?php
// Personal Home Page or PHP: Hypertext Processor
include '../defaults.inc.php';

$to_root=get_rel_path(__DIR__, 'C:/Users/Nazaire/Desktop/My Projects/website/website-php');
$page_title='Game Development Blog - Nazaire Shabazz';

start_doc(__DIR__);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mydatabase";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM myblogs ORDER BY reg_date ASC";
$result = $conn->query($sql);
$result0 = $conn->query($sql);

function writeTags(){
  global $result;
  
  $tags = Array();
  
  if($result->num_rows>0){
    while($row = $result->fetch_assoc()) {
      $postTags = $row["tags"];
      
      foreach(explode(' ', $postTags) as $soloTag)
        array_push($tags, $soloTag);
    }
    
    $tags = array_unique($tags);
    
    echo "<p class='default-box' id='blog-tags'>\n";
    
    echo "  <a class='badge badge-default blog-tag' onclick='toggleAllTags()'>*EVERYTHING*</a>\n";
    
    foreach($tags as $tag)
      echo "  <a class='badge badge-default blog-tag' onclick='toggleTag(this)'>".$tag."</a>\n";
    
    echo "</p>";
  }
}

function writeBlogs(){
  global $result0;
  
  if($result0->num_rows>0){
    while($row = $result0->fetch_assoc()) {
      $raw_date = DateTime::createFromFormat('Y-m-d H:i:s', $row["reg_date"]);

      echo "<article class='".$row["tags"]."'><a href='../".str_replace(' ', '-', strtolower($row["title"]))."/'><figure><img src='".$row["image_rpath"]."'/><figcaption class='bg-faded'><h2>".$row["title"]."</h2><time datetime='".$raw_date->format('c')."' title='".$raw_date->format('n/d/y h:i:s a')."'>".$raw_date->format('F j, Y')."</time><p>".$row["excerpt"]."</p></figcaption></figure></a></article>";
    }
  }
}
?>
  <main id="blog-page">
    <section class='lg-size'>
      <h1 class="default-box" id="front-page-introduction">Dev Blog</h1>
      <p class="default-box ml10">Click the tags to see more specific posts</p>
      <?php writeTags(); ?>
      <hr class="default-box" id="front-page-loading-bar" />
      <?php writeBlogs(); ?>
    </section>
    <script>
      let tags = document.getElementsByClassName("blog-tag");
      let URLTagFound = false;
      let allTagsEnabled = false;
      
      if(window.location.hash){
        var tCount = tags.length;

        while(tCount--){
          let t = tags[tCount];

          if(t.innerText === window.location.hash.substring(1)){
            t.click();
            URLTagFound = true;
            break;
          }
        }
      }
      
      if(!URLTagFound)
        toggleAllTags();
      
      function toggleAllTags(){
        var tCount = tags.length;
        
        if(allTagsEnabled){
          while(tCount--)
            tags[tCount].classList.remove("badge-success");

          tags[1].classList.add("badge-success");
        }else{
          while(tCount--)
            tags[tCount].classList.add("badge-success");

          tags[1].classList.remove("badge-success");
        }
        
        toggleTag(tags[1]);
        allTagsEnabled = !allTagsEnabled;
      }
      
      function toggleTag(tagElement){
        tagElement.classList.toggle("badge-success");
        
        let posts = document.getElementsByTagName("article");
        var pCount = posts.length;
                
        while(pCount--){
          let p = posts[pCount];
          p.classList.add("hidden-xl-down");
          
          var tCount = tags.length;
          
          while(tCount--){
            let t = tags[tCount];
            if(t.classList.contains("badge-success") && p.classList.contains(t.innerText)){
              p.classList.remove("hidden-xl-down");
              break;
            }
          }
        }
      }
    </script>
  </main>
<?php
// Personal Home Page or PHP: Hypertext Processor
end_doc();
?>