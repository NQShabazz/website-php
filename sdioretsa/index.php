<?php
// Personal Home Page or PHP: Hypertext Processor
include '../defaults.inc.php';
$to_root=get_rel_path(__DIR__, 'C:/Users/Nazaire/Desktop/My Projects/website/website-php');

$title='Sdioretsa';
$dashed_title=str_replace(' ', '-', strtolower($title));
$image_rpath="../assets/images/".$dashed_title."/thumbnail.gif";
$tags="html javascript webgl njse";
$excerpt="Asteroids, but from the other perspective.";
$entry_date = date('c');

$trimmed_excerpt=$excerpt;

if(strlen($trimmed_excerpt) > 255);
  $trimmed_excerpt=substr($trimmed_excerpt, 0, 252).'...';

$page_title=$title.' - Nazaire Shabazz';
$page_description=$trimmed_excerpt;
$page_image="/".$image_rpath;

//RESOLVE DIR PROBLEM
$blog_path="C:/Users/Nazaire/Desktop/My Projects/website/nqshabazz.github.io/".$dashed_title;
start_doc($blog_path);
?>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mydatabase";
$tablename = "myprojects";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: ".$conn->connect_error);
}

$sql = "SELECT reg_date FROM ".$tablename." WHERE title='".$title."'";
$result0 = $conn->query($sql);

if($result0->num_rows>0){
  $row = ($result0->fetch_assoc());
  $entry_date = $row["reg_date"];
}
?>
  <main id="post-page">
    <article id='blog-post' class='m-auto'>
      <h1 class="default-box" id="front-page-introduction"><?php echo $title ?></h1>
      <p class="text-muted">
        by Nazaire Shabazz | <time datetime="<?php echo date("c", strtotime($entry_date)) ?>" title="<?php echo date('n/d/y h:i:s a', strtotime($entry_date)) ?>"><?php echo date('n/d/y h:i:s a', strtotime($entry_date)) ?></time>
      </p>
      <p id="post-tags">
        <?php foreach(explode(' ', $tags) as $tag) echo "<a class='badge badge-default' href='../#".$tag."'>".$tag."</a>" ?>
      </p>
      <hr class="default-box" id="front-page-loading-bar" />
      <img src="<?php echo $image_rpath ?>"/>
      <div id="content-container" class="bg-faded">
        <p><?php echo $excerpt ?></p>
        <p>So I'm making a little engine in JavaScript, and this will be one of the main games I make with it.</p>
        <p><a class="badge badge-success" href="../projects/sdioretsa/">Dat ASTEROID tho</a></p>
        <hr/>
      </div>
      <?php include '../includes/post-ending.php' ?>
    </article>
  </main>
<?php
//Personal Home Page

//title, reg_date, image_rpath, tags, excerpt
$sql = "SELECT * FROM ".$tablename." WHERE title='".$title."'";
$result = $conn->query($sql);

if($result->num_rows<=0){
  $sql0 = "INSERT INTO ".$tablename." (title, image_rpath, tags, excerpt)
  VALUES ('".$title."', '".$image_rpath."', '".$tags."', '".$trimmed_excerpt."')";
  
  if($conn->query($sql0)!==TRUE){
      echo "Error: ".$sql0."<br>".$conn->error;
  }
}else{
  $sql0 = "UPDATE ".$tablename." SET title='".$title."', image_rpath='".$image_rpath."', tags='".$tags."', excerpt='".$trimmed_excerpt."' WHERE title='".$title."'";
  
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