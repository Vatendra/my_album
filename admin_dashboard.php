<?php
include "head.php";
include "db.php";
include "session.php";
if ($_SESSION["role"] != "admin") {
    header("Location: login.php");
    exit();
}
?>
<body>
<!-- Change home link -->
<scrip>
    <script>
        document.getElementById("home").href = "admin_dashboard.php";
    </script>
</scrip>
<!-- Create Album -->
<!-- Upload Multiple Images -->
<form method="post" name="create_album" class="create-album-form" enctype="multipart/form-data">
    <input type="text" name="album_name" placeholder="Album Name" required> <br>
    <input type="text" name="description" placeholder="Description"> <br>
    <input type="file" name="images[]" multiple required> <br>
    <div class="checkbox" style="display: inline-flex; margin: 8px">
        <label> Publish </label>
        <input type="checkbox" value="1" name="publish"/>
        <label> Premium </label>&nbsp
        <input type="checkbox" value="1" name="premium"/>
    </div>
    <input type="submit" value="Create Album">

</form>
</body>
<?php
if(isset($_POST["album_name"])) {
    $album_name = $_POST["album_name"];
    $description = $_POST["description"];
    $images = $_FILES["images"];
    $publish = isset($_POST["publish"]) ? 1 : 0;
    $premium = isset($_POST["premium"]) ? 1 : 0;
    $user_id = $_SESSION["user_id"];
    $created_at = date("Y-m-d H:i:s");
    $sql = "INSERT INTO collection (title, description, publish, premium, created_at) VALUES ('$album_name', '$description', '$publish', '$premium', '$created_at')";
    if($conn->query($sql) === TRUE) {
        $album_id = $conn->insert_id;
        $images_count = count($images["name"]);
        for($i = 0; $i < $images_count; $i++) {
            $image_name = rand(1, 1000)."-".$images["name"][$i];
            $extension = pathinfo($image_name, PATHINFO_EXTENSION);
            if ($extension == "jpg" || $extension == "png" || $extension == "jpeg") {
                $image_tmp_name = $images["tmp_name"][$i];
                $upload_dir = './uploads';
                if(move_uploaded_file($image_tmp_name, $upload_dir.'/'.$image_name)){
                    $sql = "INSERT INTO image (url, collection_id) VALUES ('$image_name','$album_id')";
                    $conn->query($sql);
                    ?>
                    <script>
                        alert("Image uploaded successfully");
                    </script>
                    <?php
                }
                else{
                    echo "Error uploading image";
                }
            }
            else{
                ?>
                <script>
                    alert("Invalid image format. Only png, jpeg and gif are allowed");
                </script>
                <?php
            }

        }
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>