<?php
// Personal Home Page or PHP: Hypertext Processor
include '../defaults.inc.php';
global $rootdir, $phpfolder, $wwwfolder;

$title='IGME 470 Interactive Art';
$dashed_title=str_replace(' ', '-', strtolower($title));
$image_rpath="assets/images/".$dashed_title."/top-image.png";
$tags="igme470 interactive .2018 .january";
$excerpt="Most people think of art as untouchable, to be viewed from afar. I present to you interactive art, in which touch is a part of the appreciation.";
$reg_date = '2018-01-22T09:37:33-05:00';//date('c');

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
        
        <h2>The Puffer Sphere</h2>
        <h3>by Puffer Fish Display</h3>
        
        <iframe style="width: 100%; height: calc(50vw * 0.5625); min-height: 300px;" src="https://www.youtube.com/embed/VXLeBi1ALy8?rel=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
        
        <p>The Puffer Sphere began in 2006 as a low resolution display on a ball. It was amazing for it's time, but lacked quality and interactivity. 5 years later, in 2011, the Puffer Sphere had gained on-sphere interactivity, allowing users to touch, swipe, and generally interact.</p>
        <p>This opened a whole new field to the Puffer Fish Display team, and as graphics, fidelity, and accuracy improved, their business boomed. Now they are reknown in both the art and tech space, and have an international office in North America.</p>
        
        <h2>New Angles</h2>
        <h3>by Super Nature Design</h3>
        
        <iframe src="https://player.vimeo.com/video/20358627" style="width: 100%; height: calc(50vw * 0.75); min-height: 300px;" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
        <p>New Angles is a simple, modern, and mesmerizing work of interactive art created in 2010. Vibrant colors play on tilted pyramid pixels, arranged in a hexagonal shape, mesmerizing the viewer. The piece has many potential means of interaction, since the display juts out of the wall at points, rather than being completely flat. It gains a sense of depth and realism.</p>
        <p>Super Nature Design decided to go with a familiar approach to interactive art: the contrast mirror. Users can walk up, wave, and do whatever they want, and their sillhouette will be mirrored on the display.</p>
        
        <h2>Light Form</h2>
        <h3>by Mathieu Rivier</h3>
        
        <iframe src="https://player.vimeo.com/video/45704324" style="width: 100%; height: calc(50vw * 0.75); min-height: 300px;" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
        <p>Light Form is the most futuristically abstract piece I've seen so far. Created in 2012 by Mathieu Rivier, a student of ECAL, this piece allows users to touch a face of the tesselated surface and invert it's color. It is a simple interaction, but very user friendly and entertaining in it's use of timing and animation. I can see this as decor along the walls of a modern / futuristic home, or as a set piece of a scifi film.</p>
        
        <h2>3D Pac Man</h2>
        <h3>by Keita Takahashi</h3>
        
        <iframe style="width: 100%; height: calc(50vw * 0.5625); min-height: 300px;" src="https://www.youtube.com/embed/ZpYQ-N__zQo?rel=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
        <p>3D Pac Man is an arcade game made fully immersive by taking up the whole room. Created in 2012, it has the player control a Ms.Pac-Man as she runs along the walls and ceiling, collecting pellets and running from ghosts. This increases the immersion, requiring the player to move and look around, while providing a familiar and entertaining experience.</p>
        <p>Most interesting is the blurred lines between art and game, artist and viewer. One could argue that the Takahashi did not make this art, but adapted it.And others would argue that this isn't even art, but simply a game. This debate between the distinction of art and games has gone on for years.  Another view, perhaps more agreeable to streamers and video-watchers, is that it is the player that breathes life into the game and makes it art.</p>
        
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