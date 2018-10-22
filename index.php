
<?php

//connect to mysql database
$con = mysqli_connect("localhost", "root", "", "testdb") 
or die("Error " . mysqli_error($con));
//Upload Image
 if(isset($_POST['submit']))
 {
 $imgFile = $_FILES['picture']['name'];
 $tmp_dir = $_FILES['picture']['tmp_name'];
 $imgSize = $_FILES['picture']['size']; 
 
 if(!empty($imgFile))
 {
 $upload_dir = 'image/'; // upload directory
 
 $imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION)); // get image extension
 
 // valid image extensions
 $valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions
 
 // rename uploading image
 $coverpic = rand(1000,1000000).".".$imgExt;
 
 // allow valid image file formats
 if(in_array($imgExt, $valid_extensions)){ 
 // Check file size '5MB'
 if($imgSize < 5000000) {
 move_uploaded_file($tmp_dir,$upload_dir.$coverpic);
 }
 else{
 $errMSG = "Sorry, your file is too large.";
 }
 }
 else{
 $errMSG = "Sorry, only JPG, JPEG, PNG & GIF files are allowed."; 
 }
//For Database Insertion
 // if no error occured, continue ....
 if(!isset($errMSG))
 {
 $que = "INSERT INTO image(b_image) VALUES('" . $coverpic . "')";
 if(mysqli_query($con, $que))
 {
 echo "<script type='text/javascript'>alert('Posted succesfully.');</script>";
 }
 else
 {
 echo "<script type='text/javascript'>alert('error while inserting....');</script>";
 }
 
 }
 
 }
}
 
 //Get Last Inserted Id
 $last_id = mysqli_insert_id($con);
 //Fetch Qquery
 $que = "SELECT * FROM image where id='$last_id' ";
 $result = mysqli_query($con, $que);
 $row=mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html>
<head>
 <title></title>
</head>
<body>

<form method="post" enctype="multipart/form-data">
 <p><input type="file" name="picture" required="required" /></p>
 <p><input type="submit" name="submit" style="background-color: rgb(255, 102, 0);" class="btn btn-warning" value="Upload"/></p>
</form>

<!--Display Image-->
<div>
 <label>Image : </label><br><img src="image/<?php echo $row['b_image']; ?> " alt="image">
</div>
</body>
</html>