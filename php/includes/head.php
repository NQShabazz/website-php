<?php
//Personal Home Page or PHP: Hypertext Processor
global $page_title;
if(!isset($page_title))
  $page_title="Digital Developer & Artist | Nazaire Shabazz";

global $page_description;
if(!isset($page_description))
  $page_description="Portfolio of Nazaire Shabazz, digital developer and artist.";

global $to_root;
?>
<head>
  <!-- meta data -->
  <meta charset="UTF-8">
  
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="<?php echo $page_description; ?>">
  <meta name="keywords" content="Game Development, Portfolio, 3D, Programmer, Code, Software">
  <meta name="author" content="Nazaire Shabazz">

  <meta property="og:title" content="<?php echo $page_title; ?>"/>
  <meta property="og:description" content="<?php echo $page_description; ?>"/>
  <meta property="og:type" content="website"/>
  <meta property="og:url" content="https://nqshabazz.xyz"/>
  <meta property="og:image" content="https://nqshabazz.xyz/assets/images/logo.png"/>
  <meta property="og:locale:alternate" content="es_ES"/>

  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:site" content="@nqshabazz">
  <meta name="twitter:creator" content="@nqshabazz">
  <meta name="twitter:title" content="<?php echo $page_title; ?>">
  <meta name="twitter:description" content="<?php echo $page_description; ?>"/>
  <meta name="twitter:image" content="https://nqshabazz.xyz/assets/images/logo.png">

  <!-- meta links -->
  <link rel="publisher" href="https://plus.google.com/u/0/111346714509241869686"/>
  <link rel="canonical" href="/"/>
  <link rel="shortcut icon" type="image/png" href="<?php echo $to_root?>assets/images/favicon.png"/>
  
  <!-- title -->
  <title><?php echo $page_title; ?></title>
  
  <!--Bootstrap CSS content delivery network-->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
  
  <!--jQuery JS content delivery network-->
  <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
  
  <!--Tether JS content delivery network (for Bootstrap code highlighting)-->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
  
  <!--Bootstrap JS content delivery network-->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
  
  <!--FontAwesome CSS content delivery network-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  
  <!--Google Font Open Sans Font-Family-->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
  
  <!--my css-->
  <link rel="stylesheet" href="../../assets/css/style-default.css">
  
  <script>
    $(window).on('load',function(){
      $('[data-toggle="popover"]').popover();
    });
  </script>
</head>