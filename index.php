<?php require('includes/config.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Softgroup Test Task</title>
    <!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="style/normalize.css">
    <link rel="stylesheet" href="style/main.css">
</head>
<body>

	<div class="container">

    <div class="row">
  		<h2><a href="/index.php">myBlog</a></h2>
  		<hr />
    </div>

    <?php

      if($result && count($result) > 0)
      {
          foreach($result as $row)
          {
						echo '<div class="row">';
							echo '<h3><a href="viewpost.php?id='.$row['postID'].'">'.$row['postTitle'].'</a></h3>';
							echo '<p>Posted on '.date('jS M Y H:i:s', strtotime($row['postDate'])).'</p>';
							echo '<p>'.$row['postDesc'].'</p>';
							echo '<p><a href="viewpost.php?id='.$row['postID'].'">Read More</a></p>';
						echo '</div>';
          }

      }

    ?>

		<br>
    <div class="row">
    <?php

      if($result && count($result) > 0)
      {
        echo "<h5>Total pages ($pages)</h5>";

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

	</div>


</body>
</html>
