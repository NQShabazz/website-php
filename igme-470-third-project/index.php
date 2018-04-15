<?php
// Personal Home Page or PHP: Hypertext Processor
include '../defaults.inc.php';
$to_root=get_rel_path(__DIR__, 'C:/Users/Nazaire/Desktop/My Projects/website/website-php');

$title='IGME 470 Third Project';
$dashed_title=str_replace(' ', '-', strtolower($title));
$image_rpath="../assets/images/".$dashed_title."/top-image.jpg";
$tags="igme470 arduino .2018 .april";
$excerpt="For my third Arduino project, I made a bluetooth tune speaker thing :P";
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
        
        <iframe style="width: 100%; height: calc(50vw * 0.5625); min-height: 300px;" src="https://www.youtube.com/embed/OD3gRXR-rJc" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
        
        <p>For this project we were tasked to make use of the speaker and microphone components of the Arduino.</p>
        
        <p>There was a bit less rush, but I way overscoped nonetheless X). At first I wanted to make a project wherein the Arduino would record the user's voice, send it over bluetooth to a phone app, then have the phone app send data back to the Arduino to play over the speakers.</p>
        
        <p>Part of the reason this didn't work is because I left my microphone component somewhere with the class' components. Another reason is because I could not figure out how to make a homemade app interface with Arduino over bluetooth. So I cut out the recorder part and made due with an Arduino bluetooth app in the app store.</p>
        
        <img src="../assets/images/<?php echo $dashed_title ?>/screenshot.png"/>
        
        <p>A recurring theme with Arduino seems to be that there's little to no code at all! It was super simple to set up Bluetooth - basically it acts as a Serial device just like the basic Arduino. Characters received from the Bluetooth can be parsed by their decimal values.</p>
        
        <p>The speaker was also pretty easy to use: there is a built-in tone library for arduino that allows you to play basic sounds with one line. I combined that with the "arduino bluetooth controller" app to make a simple tone player and recorder. The app would send a command over bluetooth for the Arduino to interpret and act upon.</p>
        
        <p>Here's what I wrote:</p>
        
        <a class="btn btn-primary btn-lg text-white" id="mainCodeHeading" data-toggle="collapse" data-target="#mainCode" aria-expanded="false" aria-controls="mainCode">+ main.ino</a>
        <div id="mainCode" class="collapse" aria-labelledby="mainCodeHeading">
          <code>
            <pre class="card card-body">
            
              String data;
              int melody,difference,recordingIndex,speakerPin,
              recordTimer, playingIndex, playTimer, timeStamp, delta;
              bool recording, playing;

              int recordArray[16];

              void setup(){
                Serial.begin(9600);

                Serial.write("AT+NAMEARDUINOPLEASE");
                recording=false;
                playing=false;
                speakerPin=8;
                melody=32;
              }

              void loop(){
                delta=millis()-timeStamp;
                timeStamp=millis();

                while(Serial.available()>0){
                  data+=Serial.read();
                }

                if(data.length()>0){
                  if(data=="48"){
                    //box
                    melody=32;
                    doStuff();
                    Serial.println("48");
                  }else if(data=="49"){
                    //tri
                    melody=41;
                    doStuff();
                    Serial.println("49");
                  }else if(data=="50"){
                    //cross
                    melody=52;
                    doStuff();
                    Serial.println("50");
                  }else if(data=="51"){
                    //circle
                    melody=62;
                    doStuff();
                    Serial.println("51");
                  }else if(data=="52"){
                    //up
                    difference=0;
                    doStuff();
                    Serial.println("52");
                  }else if(data=="53"){
                    //down
                    difference=200;
                    doStuff();
                    Serial.println("53");
                  }else if(data=="54"){
                    //left
                    difference=400;
                    doStuff();
                    Serial.println("54");
                  }else if(data=="55"){
                    //right
                    difference=800;
                    doStuff();
                    Serial.println("55");
                  }else if(data=="56"){
                    //select
                    playing=false;
                    recording=!recording;
                    recordingIndex=0;
                    recordTimer=0;

                    if(recording){
                      for(int i=0; i<16; i++){
                        recordArray[i]=0;
                      }
                    }

                    noTone(speakerPin);
                    Serial.println("56");
                  }else if(data=="57"){
                    //start
                    recording=false;
                    playing=!playing;
                    playingIndex=0;
                    playTimer=0;

                    if(playing){
                      tone(speakerPin,recordArray[0],recordArray[1]);
                    }else{
                      noTone(speakerPin);
                    }

                    Serial.println("57");
                  }

                  data="";
                }

                if(recording){
                  recordTimer+=delta;
                }

                if(playing){
                  playTimer+=delta;

                  if(playTimer>recordArray[playingIndex+1]+5){        
                    if(playingIndex==16){
                      playing=false;
                      noTone(speakerPin);
                    }

                    playingIndex+=2;

                    if(playingIndex<16)
                      tone(speakerPin,recordArray[playingIndex],recordArray[playingIndex+1]);

                    playTimer=0;
                  }
                }
              }

              void doStuff(){

                    if(!playing){
                      tone(speakerPin,melody+difference);
                    }

                    if(recording){
                      if(recordingIndex>0){
                        recordArray[recordingIndex]=recordTimer;
                        recordingIndex++;
                      }

                      if(recordingIndex<16){
                        recordTimer=0;
                        recordArray[recordingIndex]=melody+difference;
                        recordingIndex+=1;
                      }else{
                        recording=false;
                      }
                    }
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