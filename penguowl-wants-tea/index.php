<?php
// Personal Home Page or PHP: Hypertext Processor
include '../defaults.inc.php';
$to_root=get_rel_path(__DIR__, 'C:/Users/Nazaire/Desktop/My Projects/website/website-php');

$title='Penguowl Wants Tea';
$dashed_title=str_replace(' ', '-', strtolower($title));
$image_rpath="../assets/images/".$dashed_title."/top-image.jpg";
$tags="igme470 arduino .2018 .april";
$excerpt="Silly yet fun project idea.";
$entry_date = date('c');

$trimmed_excerpt=$excerpt;

if(strlen($trimmed_excerpt) > 255);
  $trimmed_excerpt=substr($trimmed_excerpt, 0, 252).'...';

$page_title=$title.' - Nazaire Shabazz';
$page_description=$trimmed_excerpt;
$page_image="/".$image_rpath;
$page_url="/".$dashed_title;

$trimmed_excerpt = addslashes($trimmed_excerpt);

//RESOLVE DIR PROBLEM
$blog_path="C:/Users/Nazaire/Desktop/My Projects/website/nqshabazz.github.io/".$dashed_title;
start_doc($blog_path);
?>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mydatabase";
$tablename = "myblogs";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: ".$conn->connect_error);
}

$sql = "SELECT reg_date FROM myblogs WHERE title='".$title."'";
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
        
        <p>This game will have the player serve Penguowl some tea! Penguowl will turn to one of three teacups ever so often. The player must take the tea kettle and pour tea into the teacup Penguowl wants to drink from. If the player chooses the wrong teacup or is not fast enough, Penguowl will become enraged and destroy reality. Or The eye will flash and Penguowl will flap his arms in frustration while clucking at the player. One of the two.</p>
        
        <p>So the making of this will be a little challenging. Firstly the plush owl needs be chopped in half so that the top of the owl can rotate independent from the bottom. A motor is attached to the top half and grounded on the bottom half; this is what will make it turn. Then a sensor, such as a light sensor or distance sensor, is placed into each teacup, to detect if the tea kettle is over them. That's the gist of the components needed.</p>
        
        <p>In terms of the code, we just need code to select a number from 0-2, inclusive, at random. This decides which cup to turn to. The owl then turns by a predetermined amount to face that cup. The user is given 1 second afterward to "pour tea" into the cup by trigerring the sensor in the teacup. If another teacup's sensor is triggered or time runs out, player loses, and the owl throws a tempertantrum. Otherwise, the owl turns faster and faster, shaving 0.05s off the time allowed every time (until like 0.2 or so).</p>
        
        <p>This game is fun, thematically wacky, and easy to get into, so I like it. Also I now declare copyright on Penguowl XD.</p>
      </div>
      <?php include '../includes/post-ending.php' ?>
      <script>
        
      </script>
    </article>
  </main>
<?php
//Personal Home Page

//title, reg_date, image_rpath, tags, excerpt

$sql = "SELECT * FROM myblogs WHERE title='".$title."'";
$result = $conn->query($sql);

if($result->num_rows<=0){
  $sql0 = "INSERT INTO myblogs (title, image_rpath, tags, excerpt) VALUES ('".$title."', '".$image_rpath."', '".$tags."', '".$trimmed_excerpt."')";
  
  if($conn->query($sql0)!==TRUE){
      echo "Error: ".$sql0."<br>".$conn->error;
  }
}else{
  $sql0 = "UPDATE myblogs SET title='".$title."', image_rpath='".$image_rpath."', tags='".$tags."', excerpt='".$trimmed_excerpt."' WHERE title='".$title."'";
  
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