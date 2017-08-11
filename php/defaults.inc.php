<?php
date_default_timezone_set('America/New_York');

$rootdir='C:\Users\Nazaire\Desktop\My Projects\website\php';
$html_path;

//From Felix Kling of StackOverflow
function recurse_copy($src,$dst){
  $dir=opendir($src);
  @mkdir($dst);
  while(false!==($file=readdir($dir))){
    if (($file!='.')&&($file!='..')){
      if(is_dir($src.'/'.$file)){
        recurse_copy($src.'/'.$file,$dst.'/'.$file);
      }
      else{
        copy($src.'/'.$file,$dst.'/'.$file);
      }
    }
  }
  closedir($dir);
}

//From Gordon of StackOverflow
function get_rel_path($from, $to)
{
  // some compatibility fixes for Windows paths
  $from = is_dir($from) ? rtrim($from, '\/') . '/' : $from;
  $to   = is_dir($to)   ? rtrim($to, '\/') . '/'   : $to;
  $from = str_replace('\\', '/', $from);
  $to   = str_replace('\\', '/', $to);

  $from     = explode('/', $from);
  $to       = explode('/', $to);
  $relPath  = $to;

  foreach($from as $depth => $dir) {
    // find first non-matching dir
    if($dir === $to[$depth]) {
      // ignore this directory
      array_shift($relPath);
    } else {
      // get number of remaining dirs to $from
      $remaining = count($from) - $depth;
      if($remaining > 1) {
          // add traversals up to first matching dir
          $padLength = (count($relPath) + $remaining - 1) * -1;
          $relPath = array_pad($relPath, $padLength, '..');
          break;
      } else {
          $relPath[0] = './' . $relPath[0];
      }
    }
  }
  return implode('/', $relPath);
}

function start_doc($path){
  global $html_path;
  $html_path=$path;
  
  if(!is_dir(str_replace('\php','\www',$path)))
    mkdir(str_replace('\php','\www',$path),0777,true);
  
  ob_start();
  echo"<!DOCTYPE html>\n<html lang='en'>\n";
  include"includes/head.php";
  echo"\n<body>\n";
  include"includes/header.php";
  echo"\n";
}

function end_doc(){
  include"includes/footer.php";
  echo"\n</body>\n</html>";
  
  $derr = ob_get_clean();
  echo $derr;
  
  global $html_path;
  file_put_contents(str_replace('\php','\www',$html_path).'\index.html',$derr);
  recurse_copy(__DIR__.'\assets','C:\Users\Nazaire\Desktop\My Projects\website\www\assets');
}

function root_dir(){
  return $rootdir;
}

function debug(){
  echo __FILE__;
}
?>