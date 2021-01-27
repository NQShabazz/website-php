<?php
// Personal Home Page or PHP: Hypertext Processor
include '../defaults.inc.php';
global $rootdir, $phpfolder, $wwwfolder;

$title='Happy Birthday Dan';
$dashed_title='happy-birthday-dan';
$image_rpath="assets/images/".$dashed_title."/top-image.png";
$tags=".2021 .jan";
$excerpt="Little thingy for my friend, Dan <3.";
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
  <main id="racoon-container">
    <p id="hbd-text">Happy Birthday Dan!!!</p>
  </main>
  <style>
    * {user-select: none}
    canvas {position: absolute; z-index: -1; left: 0; top: 0;}
    #hbd-text {font-family: Impact, Comic Sans MS, Helvetica, Arial; color: #fff; font-size: 0vw; position: absolute; left: 0; width: 100%; text-align: center; bottom: 40%; transition: font-size 1s, bottom 1s; opacity: 0; text-shadow: 0 0 5px black, 0 0 5px black, 0 0 5px black, 0 0 5px black;}
    #hbd-text.show {font-size: 10vw; bottom: 60%; opacity: 1;}
  </style>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r124/three.min.js" integrity="sha512-jeYvJdyAYkpQCY/omvCYQo89qA5YxDW4JBT7COPsHT2sOAanwxkZRFeP9gc69b5reSDpZIoyCqZQZcWZkbB5Gw==" crossorigin="anonymous"></script>
  <script src="https://cdn.rawgit.com/mrdoob/three.js/master/examples/js/loaders/GLTFLoader.js"></script>
  <!-- <script src="https://threejsfundamentals.org/threejs/resources/threejs/r122/examples/jsm/controls/OrbitControls.js"></script> -->
  <script src="https://cdn.jsdelivr.net/gh/mathusummut/confetti.js/confetti.min.js"></script>
  <script>
    let camera, scene, renderer
    let racoonModel, trashcanModel;
    let easyParent = new THREE.Object3D();
    let foods = new THREE.Group();
    let foodModels = []
    let foodSpawnTimer = 0.2;
    let modelsLoaded = 0, clickImpulse = 0, canOpened = 0;
    let windowHalfX = window.innerWidth / 2;
    let windowHalfY = window.innerHeight / 2;
    const loader = new THREE.GLTFLoader();

    function init() {
      // create the camera
      camera = new THREE.PerspectiveCamera( 75, window.innerWidth / window.innerHeight, 1, 1000 );
      camera.position.set(0, 10, 30)

      // create the Scene
      scene = new THREE.Scene();
      scene.background = new THREE.Color(0x44aaff)
      scene.fog = new THREE.Fog(scene.background)

      scene.add(easyParent)
      scene.add(foods)
      scene.add(new THREE.AmbientLight( 0xffffff, 0.4 ))

      const directionalLight = new THREE.DirectionalLight( 0xffffff, 1 );
      directionalLight.position.set(5, 5, -25);
      directionalLight.castShadow = true;
      directionalLight.shadow.mapSize.width = 2048;
      directionalLight.shadow.mapSize.height = 2048;
      directionalLight.shadow.camera.near = 0.1;
      directionalLight.shadow.camera.far = 1000;
      directionalLight.shadow.camera.fov = 75;
      scene.add( directionalLight )
      
      const geometry = new THREE.CircleGeometry( 25, 16 );
      const material = new THREE.MeshBasicMaterial( {color: 0x44aa88, side: THREE.DoubleSide} );
      const circle = new THREE.Mesh( geometry, material );
      circle.receiveShadow = true;
      circle.lookAt(0, 1, 0)
      circle.position.set(0, -0.5, 0)
      scene.add( circle );

      // create the container element
      container = document.createElement( 'div' );
      document.querySelector('#racoon-container').appendChild( container );
    
      // init the WebGL renderer and append it to the Dom
      renderer = new THREE.WebGLRenderer( { antialias: true } );
      renderer.setPixelRatio( window.devicePixelRatio );
      renderer.setSize( window.innerWidth, window.innerHeight );
      renderer.gammaOutput = true;
      renderer.gammaFactor = 2.2;
      renderer.shadowMap.enabled = true;
      renderer.shadowMap.type = THREE.PCFSoftShadowMap;
      container.appendChild( renderer.domElement );

      loader.load( '../assets/models/racoon.glb', function ( gltf ) {
        racoonModel = gltf.scene
        racoonModel.traverse( node => node.castShadow = node.isMesh)
        racoonModel.mixer = new THREE.AnimationMixer(racoonModel)
        racoonModel.rollAction = racoonModel.mixer.clipAction(gltf.animations[0]);
        racoonModel.runAction = racoonModel.mixer.clipAction(gltf.animations[1]);
        
        scene.add(racoonModel)
        modelsLoaded++
      }, undefined, err => console.log(err));

      loader.load( '../assets/models/trash_can.glb', function ( gltf ) {
        gltf.scene.traverse( node => node.castShadow = node.isMesh)
        gltf.scene.scale.set(5, 5, 5)
        gltf.scene.children[1].position.set(0, 1.8, 0)
        gltf.castShadow = true

        trashcanModel = gltf.scene
        scene.add(trashcanModel)
        modelsLoaded++
      }, undefined, err => console.log(err));

      loader.load( '../assets/models/food.glb', function ( gltf ) {
        gltf.scene.traverse( node => {
          node.castShadow = node.isMesh
          node.isMesh && foodModels.push(node)
          node.position.y = 3
        })
        
        modelsLoaded++
      }, undefined, err => console.log(err));

      function impulse() {
        if (modelsLoaded >= 3 && !canOpened)
          clickImpulse += 0.25
        else if (canOpened)
          createFood(0.29)
      }
      
      document.body.addEventListener('click', impulse)

      document.querySelector('footer').remove()
      document.querySelector('#toTopButton').remove()

      animate()
    }

    function openCan() {
      canOpened = 1

      confetti.start()

      trashcanModel.velocity = {x: -0.1, y: 0.25, z: -0.2}
      racoonModel.velocity = {x: 0.0, y: 0.5, z: 0.04}

      document.querySelector('#hbd-text').classList.add('show')
    }

    function createFood(impulseAmt = 0.15) {
      let newFood = foodModels[Math.random() * foodModels.length | 0].clone()
      let direction = new THREE.Vector2().random().subScalar(0.5).normalize().multiplyScalar(Math.random() * 0.05 + 0.05)

      clickImpulse = impulseAmt

      newFood.velocity = {x:  direction.x, y: 0.5, z: direction.y}
      newFood.rotation.setFromVector3(new THREE.Vector3().random().multiplyScalar(Math.PI).subScalar(Math.PI * 0.5))
      foods.add(newFood)
    }

    function animate() {
      renderer.render( scene, camera )

      if (trashcanModel) {
        trashcanModel && trashcanModel.rotation.set(Math.random() * clickImpulse - clickImpulse * 0.5, Math.random() * clickImpulse - clickImpulse * 0.5, Math.random() * clickImpulse - clickImpulse * 0.5)
        clickImpulse = Math.max(0, clickImpulse - 0.01)
        if (clickImpulse > 0.3) openCan()
        
        if (trashcanModel.velocity) {
          trashcanModel.children[1].position.add(trashcanModel.velocity)
          trashcanModel.children[1].rotation.x += 0.1
          trashcanModel.children[1].rotation.y += 0.1
          trashcanModel.velocity.y -= 0.002
        }
      }

      if (racoonModel && racoonModel.velocity && racoonModel.position.y >= 0) {
        racoonModel.position.add(racoonModel.velocity)
        racoonModel.velocity.y -= 0.005
        racoonModel.rotation.x += 0.1

        if (racoonModel.position.y < 0) {
          racoonModel.position.y = -0.001
          racoonModel.rotation.x = 0
          racoonModel.rotation.y = Math.PI * 0.5;
          racoonModel.rollAction.stop()
          racoonModel.runAction.play()

          easyParent.attach(racoonModel)
        }
      }

      if (canOpened) {
        foodSpawnTimer -= 0.017

        if (foodSpawnTimer < 0) {
          createFood()
          foodSpawnTimer = 2.5
        }

        foods.children.forEach(food => {
          if (food.position.y > 0) {
            food.position.add(food.velocity)
            food.velocity.y -= 0.005
            food.rotation.x += 0.1
            food.rotation.y += 0.1

            if (food.position.y < 0) food.position.y = -0.001
          }
        })
      }

      easyParent.rotation.y += 0.002
      
      racoonModel && racoonModel.mixer && racoonModel.mixer.update(0.009)

      requestAnimationFrame(animate)
    }

    window.addEventListener('load', init)
  </script>
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