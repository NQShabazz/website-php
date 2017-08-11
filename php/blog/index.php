<?php
// Personal Home Page or PHP: Hypertext Processor
header("Refresh: 5;");
include '../defaults.inc.php';

$to_root=get_rel_path(__DIR__, 'C:/Users/Nazaire/Desktop/My Projects/website/php');
$page_title='Game Development Blog - Nazaire Shabazz';

start_doc(__DIR__);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "blogDB";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM myblogs ORDER BY reg_date ASC";
$result = $conn->query($sql);

function writeBlogs(){
  global $result;
  
  if($result->num_rows>0){
    while($row = $result->fetch_assoc()) {
      $raw_date = DateTime::createFromFormat('Y-m-d H:i:s', $row["reg_date"]);

      echo "<article><a href='../".str_replace(' ', '-', strtolower($row["title"]))."/'><figure><img src='".$row["image_rpath"]."'/><figcaption class='bg-faded'><h2>".$row["title"]."</h2><time datetime='".$raw_date->format('c')."' title='".$raw_date->format('n/d/y h:i:s a')."'>".$raw_date->format('F j, Y')."</time><p>".$row["excerpt"]."</p></figcaption></figure></a></article>";
    }
  }
}
?>
  <main id="blog-page">
    <section class='lg-size m-auto'>
      <h1 class="text-white">BLOG</h1>
      
      <div class="d-flex justify-content-between flex-wrap">
        <?php writeBlogs() ?>
      </div>
    </section>
  </main>
<?php
// Personal Home Page or PHP: Hypertext Processor
end_doc();
?>