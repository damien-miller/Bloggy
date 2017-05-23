<?php require('includes/config.php');

$stmt = $db->prepare('SELECT postID, postTitle, postCont, postImage, postDate, like_num FROM posts WHERE postID = :postID');
$stmt->execute(array(':postID' => $_GET['id']));
$row = $stmt->fetch();

$stmt = $db->prepare("SELECT id FROM likes WHERE post_id = :post_id");
$stmt->execute(array(':post_id' => $_GET['id']));
$likes = $stmt->fetchAll();


//if post does not exists redirect user.
if($row['postID'] == ''){
	header('Location: ./');
	exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>myBlog - <?php echo $row['postTitle'];?></title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <link rel="stylesheet" href="style/main.css">
  <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
</head>
<body>

	<div class="container">

    <div class="row">
  		<h2><a href="/index.php">myBlog</a></h2>
  		<hr />
  		<p><a href="./">Blog Index</a></p>
    </div>

		<?php
			echo '<div class="row">';
        echo '<img src="'.$row['postImage'].'" class="img-responsive" />';
				echo '<h1>'.htmlspecialchars($row['postTitle'], ENT_QUOTES).'</h1>';
				echo '<p>Posted on '.date('jS M Y', strtotime($row['postDate'])).'</p>';
				echo '<p>'.$row['postCont'].'</p>';
			echo '</div>';
		?>


    <!-- Likes -->

    <div class="row ratings">
      <p class="pull-right"></p>
      <p>
        <!-- Like Icon HTML -->
        <a href="like.php?type=post&id=<?php echo $_GET['id']; ?>&user_id=<?php ?>"><span class="glyphicon glyphicon-thumbs-up"></span>&nbsp; Like it!</a>
        <!-- Like Counter -->
        <span class="counter" id="like_count<?php echo $row['id']; ?>"><?php echo count($likes); ?></span>&nbsp;&nbsp;&nbsp;
      </p>
    </div>


    <!-- Comments -->

    <?php
      $stmt = $db->prepare("SELECT name, comment, post_id FROM comments WHERE POST_ID=".$_GET['id']." ORDER BY id DESC");
      $stmt->execute();
      $comments = $stmt->fetchAll();
    ?>

    <div class="row">
      <h3>Comments</h3>
      <br />
      <?php

      try {
        if($comments && count($comments) > 0)
        {
            foreach($comments as $comment)
            {
              echo '<div>';
                echo '<p> Comment from '.$comment['name'].': '.$comment['comment'].'</p>';
              echo '</div>';
            }

        }
      } catch(PDOException $e) {
          echo $e->getMessage();
      }

      ?>
    </div>

    <br />

    <div class="row">
      <h3>Leave your Comment</h3>
      <hr/>
      <form action="" method="post">
      <input type='hidden' name='post_id' id='post_id' value="<?php echo $_GET["id"]; ?>" />
      <label>Name </label><br>
      <input type="text" name="name" id="name" placeholder="Please Enter Name"/><br /><br />
      <label>Email </label><br>
      <input type="email" name="email" id="email" placeholder="john123@gmail.com"/><br/><br />
      <label>Comment </label><br>
      <input type="text" name="comment" id="comment" placeholder="Please Enter Comment"/><br/><br />
      <input type="submit" value=" Submit " name="submit"/><br />
      </form>
    </div>
    <?php
      if(isset($_POST["submit"])){
        $servername = "localhost";
        $dbname     = "blogster";
        $dbusername = "blogster";
        $dbpassword = getenv('SG_DB_PASSWORD');

        try {
          $dbh = new PDO("mysql:host=$servername;dbname=$dbname", $dbusername, $dbpassword);

          $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // <== add this line
          $sql = "INSERT INTO comments (name, email, comment, post_id)
          VALUES ('".$_POST["name"]."','".$_POST["email"]."','".$_POST["comment"]."','".$_POST["post_id"]."')";
          if ($dbh->query($sql)) {
          echo "<script type= 'text/javascript'>alert('New Record Inserted Successfully');</script>";
          header('Location: viewpost.php?id='.$_GET["id"], true, 303);
          exit;
          }
          else{
          echo "<script type= 'text/javascript'>alert('Data not successfully Inserted.');</script>";
          }

          $dbh = null;
        }
        catch(PDOException $e)
        {
          echo $e->getMessage();
        }
      };
    ?>

	</div>



<br><br><br>
</body>
</html>
