<?php
// Personal Home Page or PHP: Hypertext Processor
include '../defaults.inc.php';
global $rootdir, $phpfolder, $wwwfolder;

$title="Hey How Yall Doin";
$dashed_title=str_replace(' ', '-', strtolower($title));
$image_rpath="assets/images/".$dashed_title."/top-image.gif";
$tags=".2020 .december trashfire";
$excerpt="It's been a whole minute y'all... so much has changed T_T";
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
      <h1 class="default-box" id="front-page-introduction">Hey... How Y'all Doin 😭</h1>
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
        <p>2020 has been... a year</p>
        <p>I can honestly say, since the last time I posted on this blog, I've gained so many levels as a programmer. While remaking the repo on my computer, there were so many little things that I do or don't do anymore.</p>
        <p>For example, in my JavaScript, I prefer the aesthetic of as few lines and characters as possible. My past self, however, didnae give af 😅. now I'm a lot more conscious about not repeating code and keeping things modular</p>
        <p>
          That said, my reckless, uninhibited style was somewhat freeing. By not worrying about the details I could get things done a lot quicker (until I couldn't).
          Now, I'm always wondering "is this the most modular way to write the code?" or "Am I repeating myself / reinventing wheels??".
        </p>

        <p>Makes you miss the simpler days of 'no refactor! only code!'.</p>

        <p>But anyways, 2020 right?</p>

        <p>
          It's not all bad. I started a whole company!!! It's called Lilac Snacc LLC. Ya girl a real businessman now purr 💅
          As you can see I've also become hella gay 😂 tricked some dude into being my bf somehow so that's nice 😂
        </p>
        <p>
          Experienced all sorts of things, from wine-tastings to yacht parties to collecting unemployment to freelancing. Currently doing a freelancing gig for a friend while I search for more stable work (and work on the business).
        </p>
        <p>
          That's part of what reviving this blog is for! While applying, one of my reviewers tipped me off to polish my LinkedIn and start blogging again. And honestly, I agree.<br>
          It feels really good to write in my little eDiary again. Also it's kinda funny how much I've changed like in terms of personality. I was so much more serious / strict...
        </p>
        <p>
          ... Actually, you know what happened? I turned 21 and forgot how to act 😂 Once I started clubbing and partying a lot more, I got to explore the type of person I am and want to be.
        </p>
        <p>
          The tired concept of the reclusive, awkward nerd was never for me anyways. PLUS, when you start realizing how silly things are, it's hard to stay serious.
        <p>
          For example, the US gov.
        </p>
        <p>
          Girl 😫 do you know we are in a World War Z type pandemic and it took our gov't 9 months to decide to give the people... *drumroll*... $600? 😭
          Before that, there was one single payment of $1200 in March. Y'all it is DECEMBER
        </p>
        <p>
          My bad I skipped over the part where literally 3,000+ Americans are dying from the virus PER DAY. And gov't goes "here, a pence for your troubles"
        </p>
        <p>
          No like the gov't literally sent everyone $5 / day and said 'make it work' 😭.
        </p>
        <p>
          Oh girl I skipped over the part where there's also a civil war, a war on lower class people, neo-nazis (girl u heard me right T_T), insider trading on vaccines, some kinda eugenecist "herd immunity" movement, and our superstar president is literally trying to undermine state governments and the electoral process, and... girl I'm tired.
        </p>
        <p>
          But anyways... believe it or not I'm looking forward to the future! Every day I get closer to my goals (living in the city, running a business, etc). So yes, shit's wild. But for now, I'm making due.
        </p>
      </div>
      <?php include '../includes/post-ending.php' ?>
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