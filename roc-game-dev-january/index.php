<?php
// Personal Home Page or PHP: Hypertext Processor
include '../defaults.inc.php';
global $rootdir, $phpfolder, $wwwfolder;

$title='ROC Game Dev January';
$dashed_title=str_replace(' ', '-', strtolower($title));
$image_rpath="assets/images/why-2018-will-be-lit/top-image.png";
$tags="roc-game-dev gamedev .january .2018";
$excerpt="So on Wednesday (1/3/2018) I went to the ROC Game Dev Meetup.";
$reg_date = '2018-01-06T22:19:10-05:00';//date('c');

$trimmed_excerpt=$excerpt;

if(strlen($trimmed_excerpt) > 255);
  $trimmed_excerpt=substr($trimmed_excerpt, 0, 252).'...';

$page_title=$title.' - Nazaire Shabazz';
$page_description=$trimmed_excerpt;
$page_image="/".$image_rpath;
$page_url="/".$dashed_title;

$trimmed_excerpt = addslashes($trimmed_excerpt);

$blog_path=$rootdir.$wwwfolder.'/'.$dashed_title;
start_doc($blog_path);
?>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mydatabase";
$tablename = "articles";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: ".$conn->connect_error);
}

$sql = "SELECT reg_date FROM articles WHERE title='".$title."'";
$result0 = $conn->query($sql);

if($result0 && $result0->num_rows>0){
  $row = ($result0->fetch_assoc());
  $reg_date = $row["reg_date"];
}
?>
  <main id="post-page">
    <article id='blog-post' class='m-auto'>
      <h1 class="default-box" id="front-page-introduction"><?php echo $title ?></h1>
      <p class="text-muted">
        by Nazaire Shabazz | <time datetime="<?php echo date("c", strtotime($reg_date)) ?>" title="<?php echo date('n/d/y h:i:s a', strtotime($reg_date)) ?>"><?php echo date('n/d/y h:i:s a', strtotime($reg_date)) ?></time>
      </p>
      <p id="post-tags">
        <?php foreach(explode(' ', $tags) as $tag) echo "<a class='badge badge-default' href='../#".$tag."'>".$tag."</a>" ?>
      </p>
      <hr class="default-box" id="front-page-loading-bar" />
      <img src="../<?php echo $image_rpath ?>"/>
      <div id="content-container" class="bg-faded">
        <p><?php echo $excerpt ?></p>
        
        <p>It's really cool! The first Wednesday of every month, game developers of Rochester will get together to chat and present their projects.</p>
        
        <p>The first game presented was a 2D top-down horror game by Devin Strehle and his brother. The player is lost in a crypt, and must rely on an oil lamp to find their way out. The oil lamp flickers out over time, so the player has to find oil and be quick to progress. So far the creator has lighting and sprites set up, and based on some of the concept art, there will be undead creatures roaming around as well!</p>
        
        <p>The second game was Project Hunt, shared by Eric Baker. The game takes place on a hex-tile grid with three points of interest: the animal, it's destination, and the hunter. Each turn, the animal goes one tile closer to it's destination, and the hunter attempts to intercept it. As the player, you can make one tile untraversable each turn (up to four blocked tiles total). Project Hunt is simple, challenging, and relaxing.</p>
        
        <p>The third project was Halloween Forever, shared by Pete Lazarski. It's a halloween-themed platformer. One of the amazing things they did was create hardware for the game. It was an arcade controller with a joystick and two-button input. It was also apparently super cheap and easy for them to build.</p>
        
        <p>The last thing I saw before I had to go was ChimeN. It's a social app that takes local news and events and lets the user quickly chime in by reacting with an emote. I can already see how this could be useful as a quick polling app or a local invitation app. It also has a little "room" system to join even more localized chats. So if you're in a coffee shop for example, you can join the "coffee room" and chat with others in the room.</p>
        <hr/>
      </div>
      <?php include '../includes/post-ending.php' ?>
      <script>
        
      </script>
    </article>
  </main>
<?php
//Personal Home Page

//title, reg_date, image_rpath, tags, excerpt

$sql = "SELECT * FROM articles WHERE title='".$title."'";
$result = $conn->query($sql);

if(!$result || $result->num_rows<=0){
  $sql0 = "INSERT INTO articles (title, image_rpath, tags, excerpt, reg_date) VALUES ('".$title."', '".$image_rpath."', '".$tags."', '".$trimmed_excerpt."', '".$reg_date."')";
  
  if($conn->query($sql0)!==TRUE){
      echo "Error: ".$sql0."<br>".$conn->error;
  }
}else{
  $sql0 = "UPDATE articles SET title='".$title."', image_rpath='".$image_rpath."', tags='".$tags."', excerpt='".$trimmed_excerpt."' WHERE title='".$title."'";
  
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