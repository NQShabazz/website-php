<?php
// Personal Home Page or PHP: Hypertext Processor
include '../defaults.inc.php';
global $rootdir, $phpfolder, $wwwfolder;

$title='IGME 470 Second Project';
$dashed_title=str_replace(' ', '-', strtolower($title));
$image_rpath="../assets/images/".$dashed_title."/top-image.jpg";
$tags="igme470 arduino .2018 .march";
$excerpt="For my second Arduino project, I attempted to make a cheap data glove.";
$reg_date = date('c');

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
      <img src="<?php echo $image_rpath ?>"/>
      <div id="content-container" class="bg-faded">
        <p><?php echo $excerpt ?></p>
        
        <iframe style="width: 100%; height: calc(50vw * 0.5625); min-height: 300px;" src="https://www.youtube.com/embed/smsTHg0WOo4" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
        
        <p>The project didn't turn out exactly as I desired, but I was able to get the flex sensor onto a glove and (sometimes) connect the arduino to my phone via bluetooth.</p>
        
        <p>Also I had great help from friends at the Construct and learned a lot about wiring, sensors, and hardware in general. For example, a few of the Construct staff taught me enough to design my own flex sensor, and I drew this:</p>
        
        <img src="../assets/images/<?php echo $dashed_title ?>/sketch.jpg"/>
        
        <p>There wasn't much at all in terms of code, since the sofware was mainly for debugging purposes. The btle and NRF stuff I didn't understand at all but thanks to floe of Github for writing the libraries.</p>
        <p>Here's what I wrote:</p>
        
        <a class="btn btn-primary btn-lg text-white" id="mainCodeHeading" data-toggle="collapse" data-target="#mainCode" aria-expanded="false" aria-controls="mainCode">+ main.ino</a>
        <div id="mainCode" class="collapse" aria-labelledby="mainCodeHeading">
          <code>
            <pre class="card card-body">
            
              #include &lt;SPI.h&gt;
              #include &lt;RF24.h&gt;
              #include &lt;BTLE.h&gt;

              RF24 radio(9,10);

              BTLE btle(&radio);

              void setup() {
                // put your setup code here, to run once:
                Serial.begin(9600);

                while (!Serial) { }
                Serial.println("BTLE advertisement sender");

                btle.begin("dgbtle");
              }

              void loop() {
                // put your main code here, to run repeatedly:
              //  Serial.println(analogRead(3));
              ////  delay(100);
              //  delay(1000);                       // wait for a second
              //  digitalWrite(8, LOW);    // turn the LED off by making the voltage LOW
              //  delay(1000);
                Serial.print(0);  // To freeze the lower limit
                Serial.print(" ");
                Serial.print(1000);  // To freeze the upper limit
                Serial.print(" ");
              //  Serial.print(analogRead(A5));
              //  Serial.print(" ");
              //  Serial.print(analogRead(A4));
              //  Serial.print(" ");
                Serial.println(analogRead(A3));

                btle.advertise(0,0);
                btle.hopChannel();
                Serial.print(".");
              }
            </pre>
          </code>
        </div>
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