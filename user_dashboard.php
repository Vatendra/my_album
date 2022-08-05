<?php
include "head.php";
require "session.php";
require "db.php";
?>
<body>
<!-- Change home link -->
<script>
    document.getElementById("home").href = "user_dashboard.php";
</script>
<table>
    <tr>
        <th>Album Name</th>
        <th>Description</th>
        <th>Created At</th>
        <th>View Slideshow</th>
    </tr>
    <?php
    if($_SESSION['role'] == 'viewer-premium'){
        $sql = "SELECT * FROM collection WHERE publish = 1";
    } else {
        $sql = "SELECT * FROM collection WHERE publish = 1 AND premium = 0";
    }
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $album_id = $row["id"];
            $album_name = $row["title"];
            $description = $row["description"];
            $created_at = $row["created_at"];
            echo "<tr>";
            echo "<td>".$album_name."</td>";
            echo "<td>".$description."</td>";
            echo "<td>".$created_at."</td>";
            echo "<td><a href='slideshow.php?album_id=".$album_id."'>View</a></td>";
            echo "</tr>";
        }
    }
    else{
        echo "No records found";
    }
    ?>
</table>
</body>