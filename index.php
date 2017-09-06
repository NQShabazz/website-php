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
      $projectTagsHTML = "<p>";
      
      foreach(explode(' ', $projectTags) as $soloTag)
        $projectTagsHTML = $projectTagsHTML."<a class='badge badge-default blog-tag'>".$soloTag."</a>";
      
      $projectTagsHTML = $projectTagsHTML."</p>";
      
      echo "<article class='project-link ".$row["tags"]."'><a href='../".str_replace(' ', '-', strtolower($row["title"]))."/'><figure><img src='".$row["image_rpath"]."'/><figcaption class='bg-faded'><h2>".$row["title"]."</h2>".$projectTagsHTML."</figcaption></figure></a></article>";
    }
  }
}
?>
  <main>
    <section id='front-page'>
      <h1 class="default-box" id="front-page-introduction"><small>Hello, I'm</small><br>Nazaire Shabazz</h1>
      <hr class="default-box" id="front-page-loading-bar" />
      
      <div class="default-box" id="front-page-option-container">
        <div class="front-page-option-box-container">
          <a class='fa fa-code fa-5x front-page-option-box box1' href='<?php echo $to_root ?>#projects' data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="Projects"><span class="sr-only">Projects</span></a>
          <a class='fa fa-smile-o fa-5x front-page-option-box box2' href='<?php echo $to_root ?>#about' data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="About Me"><span class="sr-only">About Me</span></a>
        </div>
        <div class="front-page-option-box-container">
          <a class='fa fa-commenting-o fa-5x front-page-option-box box3' href='<?php echo $to_root ?>blog' data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="Dev Blog"><span class="sr-only">Dev Blog</span></a>
          <a class='fa fa-envelope-o fa-5x front-page-option-box box4' href='<?php echo $to_root ?>#contact' data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="nqshabazz@gmail.com"><span class="sr-only">Contact</span></a>
        </div>
        <div class="front-page-option-box-container">
          <a class='fa fa-twitter fa-2x front-page-option-box box5' href="https://twitter.com/nqshabazz" rel="nofollow" target="_blank" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="Twitter"><span class="sr-only">Twitter</span></a>
          <a class='fa fa-youtube-play fa-2x front-page-option-box box5' href="https://www.youtube.com/channel/UCwlgvHxHkWjNCsCm9byUEUg" rel="nofollow" target="_blank" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="YouTube"><span class="sr-only">YouTube</span></a>
          <a class='fa fa-github-alt fa-2x front-page-option-box box5' href="https://github.com/nqshabazz" rel="nofollow" target="_blank" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="Github"><span class="sr-only">Github</span></a>
          <a class='fa fa-linkedin fa-2x front-page-option-box box5' href="https://www.linkedin.com/in/nqshabazz/" rel="nofollow" target="_blank" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="LinkedIn"><span class="sr-only">LinkedIn</span></a>
        </div>
      </div>
    </section>
    <section id="projects" class="text-white">
        <ul class="nav nav-pills nav-justified">
          <li class="nav-item">
            <a class="nav-link active" data-toggle="pill" onclick="showAllProjects()">errthang</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="pill" onclick="filterProjects('game')">game</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="pill" onclick="filterProjects('art')">art</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="pill" onclick="filterProjects('music')">music</a>
          </li>
        </ul>
      
        <?php writeProjects() ?>
    </section>
    
    <script>
      let projectArray = document.getElementsByClassName("project-link");
      
      function showAllProjects(){
        var i = projectArray.length;
        
        while(i--)
          projectArray[i].classList.remove("hidden-xl-down");
      }
      
      function filterProjects(projectTag){
        var i = projectArray.length;
        
        while(i--)
          if(projectArray[i].classList.contains(projectTag))
            projectArray[i].classList.remove("hidden-xl-down");
          else
            projectArray[i].classList.add("hidden-xl-down");
      }
    </script>
  </main>
<?php
// Personal Home Page or PHP: Hypertext Processor
end_doc();
?>