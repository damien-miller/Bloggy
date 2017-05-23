<?php
//include config
require_once('../includes/config.php');

//if not logged in redirect to login page
if(!$user->is_logged_in()){ header('Location: login.php'); }

//show message from add / edit page
if(isset($_GET['delpost'])){

	$stmt = $db->prepare('DELETE FROM posts WHERE postID = :postID') ;
	$stmt->execute(array(':postID' => $_GET['delpost']));

	header('Location: index.php?action=deleted');
	exit;
}

?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Admin</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <link rel="stylesheet" href="../style/main.css">
  <script language="JavaScript" type="text/javascript">
  function delpost(id, title)
  {
	  if (confirm("Are you sure you want to delete '" + title + "'"))
	  {
	  	window.location.href = 'index.php?delpost=' + id;
	  }
  }
  </script>
</head>
<body>

	<div id="wrapper">

	<?php include('menu.php');?>

	<?php
	//show message from add / edit page
	if(isset($_GET['action'])){
		echo '<h3>Post '.$_GET['action'].'.</h3>';
	}
	?>

  <div class="navigation">
  <?php

    if($result && count($result) > 0)
    {
      echo "<h3>Total pages ($pages)</h3>";

      # first page
      if($number <= 1)
        echo "<span>&laquo; prev</span> | <a href=\"?page=$next\">next &raquo;</a>";

      # last page
      elseif($number >= $pages)
        echo "<a href=\"?page=$prev\">&laquo; prev</a> | <span>next &raquo;</span>";

      # in range
      else
        echo "<a href=\"?page=$prev\">&laquo; prev</a> | <a href=\"?page=$next\">next &raquo;</a>";
    }

    else
    {
      echo "<p>No results found.</p>";
    }

  ?>
  </div>

	<table>
	<tr>
		<th>Title</th>
		<th>Date</th>
		<th>Action</th>
	</tr>
	<?php
		try {

      if($result && count($result) > 0)
      {
          foreach($result as $key => $row)
          {
						echo '<tr>';
						echo '<td>'.$row['postTitle'].'</td>';
						echo '<td>'.date('jS M Y', strtotime($row['postDate'])).'</td>';
						?>

						<td>
							<a href="edit-post.php?id=<?php echo $row['postID'];?>">Edit</a> |
							<a href="javascript:delpost('<?php echo $row['postID'];?>','<?php echo $row['postTitle'];?>')">Delete</a>
						</td>

						<?php
						echo '</tr>';
          }

      }


		} catch(PDOException $e) {
		    echo $e->getMessage();
		}
	?>
	</table>

	<p><a href='add-post.php'>Add Post</a></p>

</div>

</body>
</html>
