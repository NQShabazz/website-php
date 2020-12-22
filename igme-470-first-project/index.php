<?php
// Personal Home Page or PHP: Hypertext Processor
include '../defaults.inc.php';
global $rootdir, $phpfolder, $wwwfolder;

$title='IGME 470 First Project';
$dashed_title=str_replace(' ', '-', strtolower($title));
$image_rpath="assets/images/".$dashed_title."/top-image.png";
$tags="igme470 arduino .2018 .february";
$excerpt="For class I made my first Arduino project! A small controller with an lcd in the center, like a prehistoric Gameboy.";
$reg_date = '2018-02-12T10:21:25-05:00';//date('c');

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
        
        <iframe style="width: 100%; height: calc(50vw * 0.5625); min-height: 300px;" src="https://www.youtube.com/embed/DvrxcmPUNXM" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
        
        <p>For this part I had to do just a bit of coding. It was also necessary to make the Button and Joystick classes, which was a fun learning experience. Here's what I wrote:</p>
        
        <a class="btn btn-primary btn-lg text-white" id="mainCodeHeading" data-toggle="collapse" data-target="#mainCode" aria-expanded="false" aria-controls="mainCode">+ main.ino</a>
        <div id="mainCode" class="collapse" aria-labelledby="mainCodeHeading">
          <code>
            <pre class="card card-body">
            
              #include&lt;LiquidCrystal.h&gt;
              #include&lt;Button.h&gt;
              #include&lt;Joystick.h&gt;

              unsigned long timeStamp=0;
              unsigned int delta=0;
              const unsigned int deltaTarget=17; // 1/60 seconds, in milliseconds

              Joystick jStick(A0,A1,A2);

              LiquidCrystal lcd(2,3,4,5,6,9);

              const unsigned int lbPin=13;
              const unsigned int lbLED=11;
              Button lButton(lbPin,true);;
              const unsigned int rbPin=12;
              const unsigned int rbLED=10;
              Button rButton(rbPin,true);

              void setup() {
                jStick.rotate();
                jStick.flipX();
                pinMode(A3, OUTPUT);
                analogWrite(A3, 0);

                lcd.begin(16,2);
                lcd.setCursor(0,0);
                lcd.print("DERP");

                pinMode(lbLED,OUTPUT);
                pinMode(rbLED,OUTPUT);

                Serial.begin(9600);
              }

              void loop() {
                delta=millis()-timeStamp;
                timeStamp=millis();

                jStick.loop(delta);
                lButton.loop(delta);
                rButton.loop(delta);

                if(delta>=deltaTarget){
                  if(lButton.reloadAmount>=lButton.reloadTime)
                    analogWrite(lbLED,16);
                  else
                    analogWrite(lbLED,4*lButton.reloadAmount/lButton.reloadTime);

                  if(rButton.reloadAmount>=rButton.reloadTime)
                    analogWrite(rbLED,16);
                  else
                    analogWrite(rbLED,4*rButton.reloadAmount/rButton.reloadTime);

                  lcd.clear();
                  lcd.print("X:"+String(jStick.xAxis)+", Y:"+String(jStick.yAxis)+", B:"+String(jStick.pressed));
                  lcd.setCursor(0,1);
                  lcd.print("B0:"+String(lButton.pressed)+", B1:"+String(rButton.pressed));

                  analogWrite(A3, jStick.xAxis*1.2);
                }

               // Serial.println(String(digitalRead(13))+String(rButton.pressed)+" ... "+String(rButton.reloadAmount)+", "+String(rButton.reloadTime));
              }
            </pre>
          </code>
        </div>
        
        <a class="btn btn-primary btn-lg text-white" id="buttonHHeading" data-toggle="collapse" data-target="#buttonH" aria-expanded="false" aria-controls="buttonH">+ Button.h</a>
        <div id="buttonH" class="collapse" aria-labelledby="buttonHHeading">
          <code>
            <pre class="card card-body">
            
              #ifndef Button_h
              #define Button_h

              #include "Arduino.h"

              class Button{
                public:
                  Button(unsigned int pin);
                  Button(unsigned int pin,bool pullup);
                  void loop(unsigned int delta);
                  bool pressed;
                  bool justPressed;
                  unsigned int reloadAmount;
                  unsigned int reloadTime;
                private:
                  unsigned int _pin;
                  bool _pullup;
              };

              #endif
            </pre>
          </code>
        </div>
        
        <a class="btn btn-primary btn-lg text-white" id="ButtonCPPHeading" data-toggle="collapse" data-target="#ButtonCPP" aria-expanded="false" aria-controls="ButtonCPP">+ Button.cpp</a>
        <div id="ButtonCPP" class="collapse" aria-labelledby="ButtonCPPHeading">
          <code>
            <pre class="card card-body">
            
              #include "Arduino.h"
              #include "Button.h"

              Button::Button(unsigned int pin){
                pinMode(pin,INPUT);
                _pin=pin;
                _pullup=false;
                pressed=false;
                justPressed=false;
                reloadTime=3000;
                reloadAmount=reloadTime;
              }

              Button::Button(unsigned int pin,bool pullup){
                pinMode(pin,pullup?INPUT_PULLUP:INPUT);
                _pin=pin;
                _pullup=pullup;
                pressed=false;
                justPressed=false;
                reloadTime=3000;
                reloadAmount=reloadTime;
              }

              void Button::loop(unsigned int delta){
                pressed=_pullup?!digitalRead(_pin):digitalRead(_pin);
                Serial.println("pin "+String(_pin)+", "+String(_pullup)+", "+String(digitalRead(_pin)));

                if(reloadAmount&lt;=reloadTime){
                  reloadAmount+=delta;
                  justPressed=false;
                }else if(pressed){
                  justPressed=true;
                  reloadAmount=0;
                }
              }
            </pre>
          </code>
        </div>
        
        <a class="btn btn-primary btn-lg text-white" id="JoystickHHeading" data-toggle="collapse" data-target="#JoystickH" aria-expanded="false" aria-controls="JoystickH">+ Joystick.h</a>
        <div id="JoystickH" class="collapse" aria-labelledby="JoystickHHeading">
          <code>
            <pre class="card card-body">
            
            #ifndef Joystick_h
            #define Joystick_h

            #include "Arduino.h"

            class Joystick{
              public:
                Joystick(unsigned int xPin,unsigned int yPin);
                Joystick(unsigned int xPin,unsigned int yPin,unsigned int bPin);
                void loop(unsigned int delta);
                void rotate();
                void flipX();
                void flipY();
                unsigned int xAxis;
                unsigned int yAxis;
                bool pressed;
                bool justPressed;
              private:
                unsigned int _xPin;
                unsigned int _yPin;
                unsigned int _bPin;
                bool _flipX;
                bool _flipY;
            };

            #endif
            </pre>
          </code>
        </div>
        
        <a class="btn btn-primary btn-lg text-white" id="JoystickCPPHeading" data-toggle="collapse" data-target="#JoystickCPP" aria-expanded="false" aria-controls="JoystickCPP">+ Joystick.cpp</a>
        <div id="JoystickCPP" class="collapse" aria-labelledby="JoystickCPPHeading">
          <code>
            <pre class="card card-body">
            
              #include "Arduino.h"
              #include "Joystick.h"

              Joystick::Joystick(unsigned int xPin,unsigned int yPin){
                pinMode(xPin,INPUT);
                pinMode(yPin,INPUT);
                _xPin=xPin;
                _yPin=yPin;
                _bPin=-1;
                xAxis=0;
                yAxis=0;
                pressed=false;
                justPressed=false;
                _flipX = false;
                _flipY = false;
              }

              Joystick::Joystick(unsigned int xPin,unsigned int yPin,unsigned int bPin){
                pinMode(xPin,INPUT);
                pinMode(yPin,INPUT);
                pinMode(bPin,INPUT_PULLUP);
                _xPin=xPin;
                _yPin=yPin;
                _bPin=bPin;
                xAxis=0;
                yAxis=0;
                pressed=false;
                justPressed=false;
                _flipX=false;
                _flipY=false;
              }

              void Joystick::loop(unsigned int delta){
                bool wasPressed=pressed;

                pressed=_bPin==-1?false:!digitalRead(_bPin);

                if(!wasPressed && pressed)
                  justPressed=true;
                else
                  justPressed=false;

                xAxis=_flipX?map(analogRead(_xPin),0,1023,99,0):map(analogRead(_xPin),0,1023,0,99);
                yAxis=_flipY?map(analogRead(_yPin),0,1023,99,0):map(analogRead(_yPin),0,1023,0,99);
              }

              void Joystick::rotate(){
                  unsigned int k=_xPin;
                  _xPin=_yPin;
                  _yPin=k;
              }

              void Joystick::flipX(){
                  _flipX=!_flipX;
              }
              void Joystick::flipY(){
                  _flipY=!_flipY;
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