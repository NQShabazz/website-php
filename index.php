<?php
// Personal Home Page or PHP: Hypertext Processor
include 'defaults.inc.php';
$to_root=get_rel_path(__DIR__, 'C:\Users\Nazaire\Desktop\My Projects\website\website-php');
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

$sql = "SELECT * FROM myprojects ORDER BY reg_date ASC";
$result = $conn->query($sql);

function writeProjects(){
  global $result;
  
  if($result->num_rows>0){
    while($row = $result->fetch_assoc()) {
      $raw_date = DateTime::createFromFormat('Y-m-d H:i:s', $row["reg_date"]);
      
      $projectTags = $row["tags"];
      $projectTagsHTML = "";
      
      foreach(explode(' ', $projectTags) as $soloTag)
        $projectTagsHTML = $projectTagsHTML."<p class='badge badge-default blog-tag'>".$soloTag."</p>";
      
      echo "<article class='project-link ".$row["tags"]."'><a href='../".str_replace(' ', '-', strtolower($row["title"]))."/'><figure><img src='".$row["image_rpath"]."'/><figcaption class='bg-faded'><h3>".$row["title"]."</h3>".$projectTagsHTML."</figcaption></figure></a></article>";
    }
  }
}

$sql = "SELECT * FROM myblogs ORDER BY reg_date ASC";
$result0 = $conn->query($sql);
$result1 = $conn->query($sql);

function writeTags(){
  global $result0;
  
  $tags = Array();
  
  if($result0->num_rows>0){
    while($row = $result0->fetch_assoc()) {
      $postTags = $row["tags"];
      
      foreach(explode(' ', $postTags) as $soloTag)
        array_push($tags, $soloTag);
    }
    
    $tags = array_unique($tags);
    
    echo "  <p class='badge badge-default blog-tag' onclick='toggleAllTags()'>*EVERYTHING*</p>\n";
    
    foreach($tags as $tag)
      echo "  <p class='badge badge-default blog-tag' onclick='toggleTag(this)'>".$tag."</p>\n";
  }
}

function writeBlogs(){
  global $result1;
  
  if($result1->num_rows>0){
    while($row = $result1->fetch_assoc()) {
      $raw_date = DateTime::createFromFormat('Y-m-d H:i:s', $row["reg_date"]);

      echo "<article class='".$row["tags"]."'><a href='../".str_replace(' ', '-', strtolower($row["title"]))."/'><figure><img src='".$row["image_rpath"]."'/><figcaption><h3>".$row["title"]."</h3><time datetime='".$raw_date->format('c')."' title='".$raw_date->format('n/d/y h:i:s a')."'>".$raw_date->format('F j, Y')."</time><p>".$row["excerpt"]."</p></figcaption></figure></a></article>";
    }
  }
}
?>
  <main class="text-white">
    <h1 class="default-box" id="front-page-introduction"><small>Hello, I'm</small><br>Nazaire Shabazz</h1>
    
    <div class="container">
      <section>
        <h2><a class="div-toggler" id="projects-toggle" href="#projects" data-toggle="collapse"><span>&#x0002b;</span> Projects</a></h2>
        
        <div id="projects" class="collapse">
          <ul id="project-filter-container">
            <li class="project-filter active" onclick="filterProjects(this)">all</li> 
            <li class="project-filter" onclick="filterProjects(this)">game</li> 
            <li class="project-filter" onclick="filterProjects(this)">art</li> 
            <li class="project-filter" onclick="filterProjects(this)">music</li>
          </ul>

          <?php writeProjects() ?>

          <div class="spacer-box"></div>
        </div>
      </section>

      <section>
        <h2><a class="div-toggler" id="devblog-toggle" href="#devblog" data-toggle="collapse"><span>&#x0002b;</span> Dev Blog</a></h2>
        
        <div id="devblog" class="collapse">
          <?php writeTags() ?>
          <?php writeBlogs() ?>

          <div class="spacer-box"></div>
        </div>
      </section>

      <section>
        <h2><a class="div-toggler" id="aboutcontact-toggle" href="#aboutcontact" data-toggle="collapse"><span>&#x0002b;</span> About / Contact</a></h2>
        
        <div id="aboutcontact" class="collapse">
          <div class="spacer-box"></div>
        </div>
      </section>
    </div>
    
    <script>
      let togglerArray = document.getElementsByClassName("div-toggler");
      var togglerLength = togglerArray.length;
      
      while(togglerLength--){
        togglerArray[togglerLength].addEventListener("click", function(){
          if(document.getElementById(this.href.substring(this.href.indexOf("#") + 1)).classList.contains("show"))
            this.getElementsByTagName("span")[0].innerHTML = "&#x0002b;";
          else
            this.getElementsByTagName("span")[0].innerHTML = "&#10799;";
        });
      }
      
      let filterArray = document.getElementsByClassName("project-filter");
      let projectArray = document.getElementsByClassName("project-link");
      
      function filterProjects(elem){
        let projectTag = elem.innerText;
        let showAll = projectTag == 'all';
        
        var i = projectArray.length;
        
        while(i--)
          if(showAll || projectArray[i].classList.contains(projectTag))
            projectArray[i].classList.remove("hidden-xl-down");
          else
            projectArray[i].classList.add("hidden-xl-down");
        
        i = filterArray.length;
        
        while(i--)
          filterArray[i].classList.remove('active');
        
        elem.classList.add("active");
      }
      

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
            document.getElementById("devblog-toggle").click();
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
        
        let posts = document.getElementById("devblog").getElementsByTagName("article");
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
        
        allTagsEnabled = false;
      }
    </script>
  </main>
<?php
// Personal Home Page or PHP: Hypertext Processor
end_doc();
?>