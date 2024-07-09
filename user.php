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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="UI.css">
    <script src="js_user.js"></script>
    <title>Document</title>
</head>

<body class="z-0">    
  <div class="flex h-screen" id="body">
    <div id="editor" class="z-30" hidden>
      <div id="new_listing1" class="z-10 absolute top visible w-screen h-screen bg-gray-900 bg-opacity-50 grid place-items-center">  
        <div id="new_listing2" class="w-1/2 h-full/2 bg-gray-200  rounded-md ">    
          <button onclick="kill_edit()" class="inline-flex items-center rounded border border-transparent bg-indigo-100 px-2.5 py-1.5 text-xs font-medium text-indigo-700 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                  close
          </button>
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
                <input type='submit' name='formsend' id='formsend' value='Save'class='inline-flex items-center rounded border border-transparent bg-indigo-100 px-2.5 py-1.5 text-xs font-medium text-indigo-700 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2'>
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
        </div>   
      </div>
    </div>
    <div id="nw_offer" class="z-30" hidden>
      <div class="z-10 absolute top visible w-screen h-screen bg-gray-900 bg-opacity-50 grid place-items-center">  
        <div  class="w-1/2 h-full/2 bg-gray-200  rounded-md ">    
          <button onclick="kill_inventory()" class="inline-flex items-center rounded border border-transparent bg-indigo-100 px-2.5 py-1.5 text-xs font-medium text-indigo-700 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                  close
          </button>
          <h1>Create an annonce</h1>
  <form method="post">
    <div class="container">
      <label for="picture">Choose a picture:</label>
      <input type="file" id="picture" name="picture"accept="image/png, image/jpeg">
    </div>
  <div class="container">
    <label for="title"> Title </label><br>
    <input type="text" id="title" name="title" ><br>
    <label for="size">Size</label><br>
    <input type="text" id="size" name="size"><br>
    <label for="description">Describe the Item</label><br>
    <textarea id = "description" name="description" rows="4" cols="50"></textarea>
  </div>
  <div class="container">
    <label for="price">Price</label><br>
    <input type="text" id="price" name="price"><br>
  </div>
  <input type="submit" name="formsend" id="formsend" value="Post" class="inline-flex items-center rounded border border-transparent bg-indigo-100 px-2.5 py-1.5 text-xs font-medium text-indigo-700 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
</form>
  <?php
       if(isset($_POST['formsend'])){
           extract($_POST);
           if(!empty($picture) && !empty($title) && !empty($description) && !empty($size) && !empty($price)){  
             include 'database.php';
             global $db;

             $mysql =$db->prepare("INSERT INTO item(Name,Size,Price,ItemPicture,Description,UserID) VALUES(:name,:size,:price,:picture,:description,:user)");
             $mysql ->execute([
                 'name'=>$title,
                 'size'=>$size,
                 'price'=>$price,
                 'picture' =>$picture,
                 'description' =>$description,
                 'user' =>$iduser
             ]);
                       
              }      
       }
   ?>
        </div>   
      </div>
    </div>
        <div class="w-auto overflow-y-auto bg-gradient-to-b from-cyan-600 to-cyan-1000   md:block">
            <div class="flex w-full flex-col items-center py-6">
                <div class="flex flex-shrink-0 items-center">
                    <a href="">
                        <img class="h-8 w-auto" src="logo4.png">
                    </a>
            </div>
            <div class="mt-6 w-full flex-1 space-y-1 px-2">
                <a href="main.php" class="text-indigo-100 hover:bg-cyan-500 hover:text-white group w-full p-3 rounded-md flex flex-col items-center text-s font-medium">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house" viewBox="0 0 16 16">
                        <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V8.207l.646.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.707 1.5ZM13 7.207V13.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V7.207l5-5 5 5Z"/>
                    </svg>
                    Home
                </a>
                <a href="inventaire.php" class="text-indigo-100 hover:bg-cyan-500 hover:text-white group w-full p-3 rounded-md flex flex-col items-center text-s font-medium">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-fire" viewBox="0 0 16 16">
                        <path d="M8 16c3.314 0 6-2 6-5.5 0-1.5-.5-4-2.5-6 .25 1.5-1.25 2-1.25 2C11 4 9 .5 6 0c.357 2 .5 4-2 6-1.25 1-2 2.729-2 4.5C2 14 4.686 16 8 16Zm0-1c-1.657 0-3-1-3-2.75 0-.75.25-2 1.25-3C6.125 10 7 10.5 7 10.5c-.375-1.25.5-3.25 2-3.5-.179 1-.25 2 1 3 .625.5 1 1.364 1 2.25C11 14 9.657 15 8 15Z"/>
                      </svg>
                    Inventory
                </a>
                <button onclick="create_new_offer()" href="#" class="text-indigo-100 hover:bg-cyan-500 hover:text-white group w-full p-3 rounded-md flex flex-col items-center text-s font-medium">
                  <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                  </svg>
                    Creat Offer
                </button>
                <a href="Offers.php" class="text-indigo-100 hover:bg-cyan-500 hover:text-white group w-full p-3 rounded-md flex flex-col items-center text-s bottom font-medium">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box" viewBox="0 0 16 16">
                      <path d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5 8 5.961 14.154 3.5 8.186 1.113zM15 4.239l-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923l6.5 2.6zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464L7.443.184z"/>
                    </svg>
                  Offers
              </a>
              <a href="#" class="text-indigo-100 hover:bg-cyan-500 hover:text-white group w-full p-3 rounded-md flex flex-col items-center text-s bottom font-medium pt-32 invisible ">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box" viewBox="0 0 16 16">
                    <path d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5 8 5.961 14.154 3.5 8.186 1.113zM15 4.239l-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923l6.5 2.6zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464L7.443.184z"/>
                  </svg>
                Settings
                </a>
              <a href="user.php" class="hover:animate-pulse outline-offset-4 text-indigo-100 text-cyan-500 group w-full p-3 rounded-md flex flex-col items-center text-s bottom font-medium">
              <?php
                  $req = $db->prepare("SELECT * FROM utilisateur WHERE iduser = :id");
                  $req->execute(['id' => $iduser]);
                  $result = $req->fetch();
                  if ($result == true){
                  if($result['profilepicture']==null){
                  echo "<img class='inline-block h-14 w-14 rounded-full' src='https://www.unamur.be/sciences/chimie/cbo/members/membres-fichiers/anonymity.jpg' alt=''>";
                  }else{
                  echo "<img class='inline-block h-14 w-14 rounded-full' src=".$result['profilepicture']." alt=''>";
                  }}
                ?>
            </a>
            </div>
        </div>
    </div>
    <div class="flex flex-1 flex-col overflow-hidden">
        <div class="flex flex-1 items-stretch overflow-hidden">
            <main class="flex-1 overflow-y-auto bg-gradient-to-tr from-slate-100 via-white to-gray-600">
              <!-- Primary column -->
              <section aria-labelledby="primary-heading" class="flex h-full min-w-0 flex-1 flex-col lg:order-last">
                <article>
                  <!-- Profile header -->
                  <div>
                    <div>
                      <img class="h-32 w-full object-cover lg:h-48" src="https://i.pinimg.com/originals/bc/db/92/bcdb923cc8a06e93741afbc0f1acb5a1.jpg" alt="">
                    </div>
                    <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
                      <div class="-mt-12 sm:-mt-16 sm:flex sm:items-end sm:space-x-5">
                        <div class="flex">
                        <?php

                            $req = $db->prepare("SELECT * FROM utilisateur WHERE iduser = :id");
                            $req->execute(['id' => $iduser]);
                            $result = $req->fetch();
                            if ($result == true){
                              if($result['profilepicture']==null){
                                echo "<img class='h-24 w-24 rounded-full ring-4 ring-white sm:h-32 sm:w-32' src='https://www.unamur.be/sciences/chimie/cbo/members/membres-fichiers/anonymity.jpg'>";
                              }else{
                                echo "<img class='h-24 w-24 rounded-full ring-4 ring-white sm:h-32 sm:w-32' src=".$result['profilepicture'].">";
                              }
                              
                            }
                        ?>                   
                        </div>
                        <div class="mt-6 sm:flex sm:min-w-0 sm:flex-1 sm:items-center sm:justify-end sm:space-x-6 sm:pb-1">
                          <div class="mt-6 min-w-0 flex-1 sm:hidden 2xl:block">
                            <h1 class="truncate text-2xl font-bold text-gray-900">Ricardo Cooper</h1>
                          </div>
                          <div class="justify-stretch mt-6 flex flex-col space-y-3 sm:flex-row sm:space-y-0 sm:space-x-4">
                            <button onclick="edit()" type="button" class="inline-flex justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:ring-offset-2">
                              <span>Edit</span>
                            </button>
                            
                          </div>
                        </div>
                      </div>
                      <div class="mt-6 hidden min-w-0 flex-1 sm:block 2xl:hidden">
                        <?php
                            $req = $db->prepare("SELECT * FROM utilisateur WHERE iduser = :id");
                            $req->execute(['id' => $iduser]);
                            $result = $req->fetch();
                            if ($result == true){
                              echo "<h1 class='truncate text-2xl font-bold text-gray-900'>".$result['name']." ".$result['surname']."</h1>";
                            }
                        ?>
                      </div>
                    </div>
                  </div>
      
                  <!-- Tabs -->
                  <div class="mt-6 sm:mt-2 2xl:mt-5">
                    <div class="border-b border-gray-200">
                      <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
                        <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                            <a href="#" class="border-pink-500 text-gray-900 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm" x-state:on="Current" x-state:off="Default" aria-current="page" x-state-description="Current: &quot;border-pink-500 text-gray-900&quot;, Default: &quot;border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300&quot;">Profile</a>                          
                        </nav>
                      </div>
                    </div>
                  </div>
      
                  <!-- Description list -->
                  <div class="mx-auto mt-6 max-w-5xl px-4 sm:px-6 lg:px-8">
                    <dl class="grid  grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                      
                        <div class="sm:col-span-1 ">
                          <dt class="text-sm font-medium text-gray-500">Phone</dt>
                          <?php
                            $req = $db->prepare("SELECT * FROM utilisateur WHERE iduser = :id");
                            $req->execute(['id' => $iduser]);
                            $result = $req->fetch();
                            if ($result == true){
                              if($result['phone']==null){
                                echo"<dd class='mt-1 text-sm text-gray-900'>None</dd>";
                              }else{
                                echo"<dd class='mt-1 text-sm text-gray-900'>(44)".$result['phone']."</dd>";
                              }
                              
                            }
                          ?>
                        </div>
                      
                        <div class="sm:col-span-1 ">
                          <dt class="text-sm font-medium text-gray-500">Email</dt>
                          <?php
                            $req = $db->prepare("SELECT * FROM utilisateur WHERE iduser = :id");
                            $req->execute(['id' => $iduser]);
                            $result = $req->fetch();
                            if ($result == true){
                              echo "<dd class='mt-1 text-sm text-gray-900'>".$result['email']."</dd>";
                            }
                        ?>
                          
                        </div>
                        
                        <div class="sm:col-span-1 ">
                          <dt class="text-sm font-medium text-gray-500">Location</dt>
                          <?php
                            $req = $db->prepare("SELECT * FROM utilisateur WHERE iduser = :id");
                            $req->execute(['id' => $iduser]);
                            $result = $req->fetch();
                            if ($result == true){
                              if($result['adress']==null){
                                echo"<dd class='mt-1 text-sm text-gray-900'>None</dd>";
                              }else{
                                echo"<dd class='mt-1 text-sm text-gray-900'>".$result['adress']."</dd>";
                              }
                              
                            }
                          ?>
                          <br>
                          <dt class="text-sm font-medium text-gray-500">About me</dt>
                        <dd class="mt-1 max-w-prose space-y-5 text-sm text-gray-900"> 
                          <?php
                            $req = $db->prepare("SELECT * FROM utilisateur WHERE iduser = :id");
                            $req->execute(['id' => $iduser]);
                            $result = $req->fetch();
                            if ($result == true){
                              if($result['description']==null){
                                echo"<p>None</p>";
                              }else{
                                echo"<p>".$result['description']."</p>";
                              }
                              
                            }
                          ?>
            </dd>
                        </div>
                        <div class="sm:col-span-1 ">
                          <dt class="text-sm font-medium text-gray-500">Inventory</dt>

                          <div class="sm:col-span-1  bg-gray-500 rounded-l bg-opacity-10 overflow-hidden">
                              <div class="relative rounded-l overflow-auto">
                              <div class="w-full flex gap-12 snap-x overflow-x-auto py-14">
                                <?php
                                  $req = $db->prepare("SELECT * FROM item WHERE UserID = :id");
                                  $req->execute(['id' => $iduser]);
                                  $data = $req->fetchAll(PDO::FETCH_ASSOC);
                                  if($data == true)
                                  {   
                                      foreach ($data as $item) {
                                          echo "<div class='snap-start hover:drop-shadow-xl scroll-ml-6 shrink-0 relative first:pl-6 last:pr-[calc(100%-21.5rem)]'>
                                  <img class='relative shrink-0 w-80 h-40 rounded-lg shadow-xl bg-white' src=".$item['ItemPicture']."></div>"; 
                                      }
                                  }
                                ?>
                                
                                <button onclick="edit()" class="snap-start hover:drop-shadow-xl scroll-ml-6 shrink-0 relative first:pl-6 last:pr-[calc(100%-21.5rem)]">
                                  <img class="relative shrink-0 w-80 h-40 rounded-lg shadow-xl bg-white" src="plus.png">
                                </button>
                              </div>
                              </div><div class="absolute inset-0 pointer-events-none border border-black/5 rounded-xl dark:border-white/5"></div></div>
                          </div>
                      <div class="sm:col-span-2 ">       
                      </div> 
                    </dl>
                  </div>     
              </section>
            </main>
          </div>
    </div>
  </div> 
</body>
</html>