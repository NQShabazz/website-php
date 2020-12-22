<?php
// Personal Home Page or PHP: Hypertext Processor
include '../defaults.inc.php';
global $rootdir, $phpfolder, $wwwfolder;

$title='IGME 470 Final Project';
$dashed_title=str_replace(' ', '-', strtolower($title));
$image_rpath="assets/images/".$dashed_title."/top-image.png";
$tags="igme470 arduino .2018 .april";
$excerpt="IGME 470 was by far my favorite class this semester. Recently we did our final project.";
$reg_date = '2018-05-07T01:19:42-04:00';// date('c');

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
        
        <p>At the start of the semester I knew nothing of hardware or that it was easy to get into. This course opened my eyes to new possibilities, and I'm thinking about diving deeper into Arduino. ^_^</p>
        
        <p>We had our final project of the class. The assignment was to make <b>anything</b>, as long as the Arduino had serial communication with another device. This sounds easy enough, but I was overwhelmed with the possibilities. I find that happens often with free-form projects; so many thoughts and ideas I freeze up and end up doing little.</p>
        
        <p>The first two weeks of the project were like that. I'd tinker a little, almost put something together, then dash it for a new, better idea. When the final week came I started to freak out. And for all my grand ideas I ended up using my failsafe idea of simple Arduino - Android communication.</p>
        
        <p>Because of this my project was rather simple. Te user would use their phone to toggle 4 LEDs connected to the Arduino. This meant I only needed 5 components total: 4 LEDs and one Bluetooth Module. Wiring the LEDs was quick enough work, but figuring out how to write the Android app was a task. Luckily I found <a href="http://mcuhq.com/27/simple-android-bluetooth-application-with-arduino-example">an Arduino Bluetooth tutorial</a> on which set me in the right direction. Thanks Justin Bleau!</p>
        
        <p>After figuring out how to do things with Android Studio and code, the Arduino code was much kinder. In fact, most of it is derived from the third project:</p>
        
        <p></p>
        
        <a class="btn btn-primary btn-lg text-white" id="mainCodeHeading" data-toggle="collapse" data-target="#mainCode" aria-expanded="false" aria-controls="mainCode">+ main.ino</a>
        
        <div id="mainCode" class="collapse" aria-labelledby="mainCodeHeading">
          <code>
            <pre class="card card-body">
              String data;
              int timeStamp, delta;
              bool LED49, LED50, LED51, LED52;

              void setup(){
                Serial.begin(9600);
                LED49 = LED50 = LED51 = LED52 = false;
                Serial.write("AT+NAMEARDUINOPLEASE");
              }

              void loop(){
                delta=millis()-timeStamp;
                timeStamp=millis();

                while(Serial.available()>0){
                  data+=Serial.read();
                }

                if(data.length()>0){
                  if(data=="48"){
                    Serial.println("48");
                  }else if(data=="49"){
                    LED49 = !LED49;
                    digitalWrite(13, LED49 ? HIGH : LOW);
                    Serial.println("49");
                  }else if(data=="50"){
                    LED50 = !LED50;
                    digitalWrite(12, LED50 ? HIGH : LOW);
                    Serial.println("50");
                  }else if(data=="51"){
                    LED51 = !LED51;
                    digitalWrite(11, LED51 ? HIGH : LOW);
                    Serial.println("51");
                  }else if(data=="52"){
                    LED52 = !LED52;
                    digitalWrite(10, LED52 ? HIGH : LOW);
                    Serial.println("52");
                  }

                  data="";
                }
              }
            </pre>
          </code>
        </div>
        
        <p>At a point I realized that I could do something interesting with the first project - maybe a bluetooth controller or something, but by then it was a bit too late. It isn't too late to make personally though. This class has made me so interested in Arduino I consider it a hobby! Over the summer I plan to make some interesting stuff :)</p>
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