<?php
// Personal Home Page or PHP: Hypertext Processor
include '../defaults.inc.php';
$to_root=get_rel_path(__DIR__, 'C:/Users/Nazaire/Desktop/My Projects/website/website-php');

$title='Why 2018 Will Be Lit';
$dashed_title=str_replace(' ', '-', strtolower($title));
$image_rpath="../assets/images/".$dashed_title."/top-image.png";
$tags="personal .2017 .december";
$excerpt="2017 was a mental drain. I'm making changes to ensure 2018 is much better.";
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
        
        <p>It's actually so hard to start a blog. There's a million and one things I want to do at once. But I won't let that overwhelm me. Before we go into 2018, my friend and I set some goals for ourselves. Something like New Years resolutions. Writing one blog post a week is one of those resolutions, along with a handful of others. Some of the goals are pretty clear, like finish at least 5 Duolingo lessons a week, or workout thrice a week. Others, like gaining 1000 followers, not so clear. Still, they are reasonable goals for the next year.</p>
        
        <p>As you might have notiecd, some of these goals are more like tasks / quotas (though that doesn't sound very motivating; wording matters). This "Do X, Y times a week" format not only gameifies my objectives, but gives me a sense of accomplishment. I made a little list of tasks in Google Sheets, and the closer I am to finishing something, the brighter/greener it gets. As well, I've sorted those tasks from simplest to most difficult. For example, calling my fam 5 times a week is a simple task, so it's at the top of the list. Making one minigame a week is a bit more complicated, so it's at the bottom.</p>
        
        <p>I'm still getting into the groove of it, and it's been a rocky start, but I've never felt more accomplished and happy in the past few months (though school being on break might have something to do with that :P).</p>
        
        <p>Oh yea! I also introduced a little rule for myself: No gaming unless it's with friends. I know this might sound controversial for someone who wants to be a game developer, but honestly I feel so much more productive. Gaming is more of a treat, and something of a reward now. Plus, playing with friends is always better, since in the games I play (mainly League), random players can be quite toxic.</p>
        
        <p>Moving back to my list of goals. One of them - "Get a summer tech job in the city (NYC or SF)" - is kinda daunting to me. It's the one goal I feel the most pressure about, and I'm so happy to be completing this with a friend. It is good to challenge yourself, but to have a friend take the challenge with you is uplifting. You push each other to set better goals, but reign each other in if the goals are unrealistic. You pressure each other to get shit done, and you inspire each other by seeing those accomplishments fill up. Motivation can be so hard to come by, but with a friend to motivate you, you always feel alive.</p>
        
        <p>I think I've conveyed what I wanted to so far, but I can tell the execution isn't very good. I'm still pretty happy. Because with each week my posts will get better and better. I'm gonna have to start following blogs, appreciating more than just their content - their delivery, and their formatting as well. Writing a blog is harder than I thought :P.</p>
        
        <p>note: I'm still in the middle of writing this post. (It's about 4:30, on 12/30 rn).</p>
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