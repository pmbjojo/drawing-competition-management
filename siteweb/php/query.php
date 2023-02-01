<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/query.css" rel="stylesheet">
    <title>Document</title>
</head>
<body>
    <div class="container">
<?php
    include ("menu.php");
    include ("database.php");
    $query = $_POST["query"];
    //echo "<h1>".$query."</h1>";
    $result = freeQuery($query);
    // afficher les résultats
    echo "<div  class='table-scroll small-first-col table fixed-header'>";
        echo"<div class='fixed'>";
            echo"<div class='row'>";
                echo "<div class='cell p0'>";
                    echo "<div class='table'>";
                        echo"<div class='row head'>";
                            $fields = $result->fetch_fields();
                            foreach($fields as $field) {
                                echo "<div class='cell'>" . $field->name . "</div>";
                            }
                        echo "</div>";
                    echo "</div>";
                echo "</div>";
            echo "</div>";
        echo "</div>";
    while($row = mysqli_fetch_assoc($result)) {
        echo"<div class='row'>";
            echo "<div class='cell p0'>";
                echo "<div class='table'>";
                    echo"<div class='row'>";
                        foreach($row as $value) {
                            echo "<div class='cell'>" . $value . "</div>";
                        }
                    echo "</div>";
                echo "</div>";
            echo "</div>";
        echo "</div>";
    }
?>
    </div>
</body>
</html>

