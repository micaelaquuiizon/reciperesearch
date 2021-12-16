<!DOCTYPE html>
<html>
<head>
  <title>Recipe Search Results</title>
</head>
<body>
  <h1>Recipe Search Results</h1>
  <?php
    // create short variable names
    $searchtype="recipe.category_id";
	$searchterm="category.id";

    $db = new mysqli('localhost', 'root', '', 'cookbook');
    if (mysqli_connect_errno()) {
       echo '<p>Error: Could not connect to database.<br/>
       Please try again later.</p>';
       exit;
    }

    $query = "SELECT recipe.id, recipe.name, content, creation, category.name FROM recipe, category WHERE ? = ? ORDER BY content";
    $stmt = $db->prepare($query);
    $stmt->bind_param('dd', $searchtype, $searchterm);	
    $stmt->execute();
    $stmt->store_result();
  
    $stmt->bind_result($recipe_id, $recipe_name, $content, $creation, $category_name);

    echo "<p>Number of recipes found: ".$stmt->num_rows."</p>";

    while($stmt->fetch()) {
      echo "<p><strong>ID: ".$recipe_id."</strong>";
      echo "<br />Name: ".$recipe_name;
      echo "<br />Content: ".$content;
      echo "<br />Category_ID: ".$category_name."</p>";
    }

    $stmt->free_result();
    $db->close();
  ?>
</body>
</html>
