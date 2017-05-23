<?php
ob_start();
session_start();

$servername = "localhost";
$dbname     = "blogster";
$dbusername = "blogster";
$dbpassword = getenv('SG_DB_PASSWORD');

$db = new PDO("mysql:host=$servername;dbname=$dbname", $dbusername, $dbpassword);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$total  = $db->query("SELECT COUNT(postID) as rows FROM posts")
      ->fetch(PDO::FETCH_OBJ);

$perpage = 10;
$posts  = $total->rows;
$pages  = ceil($posts / $perpage);

# default
$get_pages = isset($_GET['page']) ? $_GET['page'] : 1;

$data = array(

  'options' => array(
    'default'   => 1,
    'min_range' => 1,
    'max_range' => $pages
    )
);

$number = trim($get_pages);
$number = filter_var($number, FILTER_VALIDATE_INT, $data);
$range  = $perpage * ($number - 1);

$prev = $number - 1;
$next = $number + 1;

$stmt = $db->prepare("SELECT postID, postTitle, postDesc, postDate FROM posts ORDER BY postID DESC LIMIT :limit, :perpage");
$stmt->bindParam(':perpage', $perpage, PDO::PARAM_INT);
$stmt->bindParam(':limit', $range, PDO::PARAM_INT);
$stmt->execute();

$result = $stmt->fetchAll();



//set timezone
date_default_timezone_set('Europe/Kiev');

//load classes as needed
function __autoload($class) {

   $class = strtolower($class);

   //if call from within assets adjust the path
   $classpath = 'classes/class.'.$class . '.php';
   if ( file_exists($classpath)) {
      require_once $classpath;
   }

   //if call from within admin adjust the path
   $classpath = '../classes/class.'.$class . '.php';
   if ( file_exists($classpath)) {
      require_once $classpath;
   }

   //if call from within admin adjust the path
   $classpath = '../../classes/class.'.$class . '.php';
   if ( file_exists($classpath)) {
      require_once $classpath;
   }

}

$user = new User($db);
?>
