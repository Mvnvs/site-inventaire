<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Edit Annonce</title>

</head>


<body>
<h1>Edit your annonce</h1>
<?php
  $url = $_SERVER['REQUEST_URI'];
  $part = explode ("?", $url);
  $lien = $part[1];
  $lien3 = explode("=", $lien);
  $id = $lien3[1];

  include 'database.php';
  global $db;

  $req = $db->prepare("SELECT * FROM item WHERE ItemID = :id");
  $req->execute(['id' => $id]);
  $result = $req->fetch();
  echo "
  <form method='post'>
    <div class='container'>
      <label for='picture'>Choose a picture:</label><br>
      <input type='file' id='picture' name='picture''accept='image/png, image/jpeg' value".$result['ItemPicture']."><br>
      <label for='Name'>Name</label><br>
      <input type='text' id='name' name='name' value=".$result['Name']."><br>
      <label for='size'>Size</label><br>
      <input type='text' id='size' name='size' value=".$result['Size']."><br>
      <label for='price'>Price</label><br>
      <input type='number' id='price' name='price' value=".$result['Price']."><br>
      <label for='description'>Description</label><br>
      <textarea id = 'description' name='description' rows='4' cols='50' value=".$result['Description']."></textarea>
    </div>
    <input type='submit' name='formsend' id='formsend' value='Save'>
  </form>";


       if(isset($_POST['formsend'])){
           extract($_POST);
           if(!empty($name) && !empty($size) && !empty($price) && !empty($description)){  
             $mysql =$db->prepare("UPDATE item SET ItemPicture = :picture, name = :name, size = :size, price = :price, description = :description WHERE ItemID= :id");
             $mysql ->execute([
                 'picture'=>$picture,
                 'name'=>$name,
                 'size'=>$size,
                 'price'=>$price,
                 'description' => $description,
                 'id'=>$id
             ]);
             echo "Successfully updated";          
          }
          else{
            echo "Please fill all fields";
          }    
       }
   ?>
</body>
</html>



