<?php
session_start();
if(isset($_SESSION['id']))
{
    $iduser = $_SESSION['id'];

}
else{
    header('Location: login.php');
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Edit Account</title>

</head>


<body>
<h1>Edit your account</h1>
<?php
  include 'database.php';
  global $db;

  $req = $db->prepare("SELECT * FROM utilisateur WHERE iduser = :id");
  $req->execute(['id' => $iduser]);
  $result = $req->fetch();
  echo "
  <form method='post'>
    <div class='container'>
      <label for='picture'>Choose a picture:</label><br>
      <input type='file' id='picture' name='picture''accept='image/png, image/jpeg'><br>
      <label for='Name'>Name</label><br>
      <input type='text' id='name' name='name' value=".$result['name']."><br>
      <label for='surname'>Surname</label><br>
      <input type='text' id='surname' name='surname' value=".$result['surname']."><br>
      <label for='phone'>Phone</label><br>
      <input type='number' id='phone' name='phone' value=".$result['phone']."><br>
      <label for='location'>Location</label><br>
      <input type='text' id='location' name='location' value=".$result['adress']."><br>
      <label for='description'>About me</label><br>
      <textarea id = 'description' name='description' rows='4' cols='50' value=".$result['description']."></textarea>
    </div>
    <input type='submit' name='formsend' id='formsend' value='Save'>
  </form>";


       if(isset($_POST['formsend'])){
           extract($_POST);
           if(!empty($name) && !empty($surname) ){  
             $mysql =$db->prepare("UPDATE utilisateur SET name = :name, surname = :surname, phone = :phone, adress=:adress, description = :description WHERE iduser= :iduser ");
             $mysql ->execute([
                 'name'=>$name,
                 'surname'=>$surname,
                 'phone'=>$phone,
                 'adress' =>$location,
                 'description' => $description,
                 'iduser'=>$iduser
             ]);
             echo "Successfully updated";          
          }

          else{
            echo "Please fill all fields : name and surname";
          }    
       }
   ?>
</body>
</html>



