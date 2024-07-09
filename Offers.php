<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Offers</title>
        <link rel="stylesheet" type="text/css" href="invent.css">
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <header class="relative bg-gradient-to-r from-cyan-600 to-cyan-100 w-screen">
        <nav class="mx-auto max-w-7xl px-4 h-sm:px-6 lg:px-8" aria-label="Top">
          <div class="flex w-full items-center justify-between border-b border-grey-500 py-6 lg:border-none">
            <div class="flex items-center">
              <a href="main.php"><!-- logo -->
                <img src="logo4.png" class="object-scale-down h-20 w-30">
              </a>
              <div class="ml-10 hidden space-x-8 lg:block">
                <a href="Offers.php" class="text-base font-medium text-white hover:text-gray-500">Offers</a>
                <a href="inventaire.php" class="text-base font-medium text-white hover:text-gray-500">Inventory</a>
                <a href="#" class="text-base font-medium text-white hover:text-gray-500">Drops</a>
                <a href="#" class="text-base font-medium text-white hover:text-gray-500">On work</a>
              </div>
            </div>

            <?php
                session_start();
                if(!isset($_SESSION['id']))
                {   
                    echo"
                    <div class='ml-10 space-x-4'>
                    <a href='login.php' class='inline-block rounded-md border border-transparent bg-gray-500 py-2 px-4 text-base font-medium text-white bg-opacity-20 hover:bg-opacity-100'>Sign in</a>
                    <a href='signin.php' class='inline-block rounded-md border border-transparent bg-white py-2 px-4 text-base font-medium text-gray-600 hover:bg-opacity-10'>Sign up</a>
                    </div>";
                }
                else{
                    $iduser = $_SESSION['id'];
                    include 'database.php';
                    global $db;

                    $req = $db->prepare("SELECT * FROM utilisateur WHERE iduser = :id");
                    $req->execute(['id' => $iduser]);
                    $result = $req->fetch();
                    if ($result == true){
                      if($result['profilepicture']==null){
                        echo "<div class='ml-10 space-x-4'>
                          <a href='user.php' class='hover:animate-pulse inline-block rounded-md border border-transparent bg-white py-2 px-4 text-base font-medium text-gray-600 bg-opacity-0'>
                              <img class='inline-block h-14 w-14 rounded-full' src='https://www.unamur.be/sciences/chimie/cbo/members/membres-fichiers/anonymity.jpg' alt=''>
                          </a>
                          <form class='inline-block rounded-md border border-transparent bg-cyan-500 py-2 px-4 text-base font-medium text-gray-600 bg-opacity-0 hover:opacity-50' method='post'><input type='submit' name='Logout' id='Logout' value='Log out'></form>
                          </div>
                              ";
                      }else{
                        echo "<div class='ml-10 space-x-4'>
                        <a href='user.php' class='hover:animate-pulse inline-block rounded-md border border-transparent bg-white py-2 px-4 text-base font-medium text-gray-600 bg-opacity-0'>
                            <img class='inline-block h-14 w-14 rounded-full' src=".$result['profilepicture']." alt=''>
                        </a>
                        <form class='inline-block rounded-md border border-transparent bg-cyan-500 py-2 px-4 text-base font-medium text-gray-600 bg-opacity-0 hover:opacity-50' method='post'><input type='submit' name='Logout' id='Logout' value='Log out'></form>
                        </div>
                            ";
                        }          
                      }
                    }
                if(isset($_POST['Logout'])){
                    session_unset();
                    session_destroy();
                    header("location:main.php");
                }
            ?>
          </div>
        </nav>
    </header>
    <body>

        <h1 class="font-bold text-xl mt-8" >Offers</h1>
        <div class="trait"></div>

        <div class="relative pr-6 pl-6 grid grid-cols-1 gap-y-12 sm:grid-cols-2 sm:gap-x-6 lg:grid-cols-4 xl:gap-x-8 mt-8">
        <?php
            $req = $db->prepare("SELECT * FROM item");
            $req->execute();
            $data = $req->fetchAll(PDO::FETCH_ASSOC);
            shuffle($data);
            if($data == true)
            {   
                foreach ($data as $item) {
                    $mysql = $db->prepare("SELECT * FROM utilisateur WHERE iduser = :id");
                    $mysql->execute(['id' => $item['UserID']]);
                    $result = $mysql->fetch();
                    if ($result == true){
                      if($result['profilepicture']==null){
                        echo "<div class=''>
                      <a href=profile.php?id=".$item['UserID'].">
                            <div id='user'>
                              <img id='profile' src='https://www.unamur.be/sciences/chimie/cbo/members/membres-fichiers/anonymity.jpg'>
                              <p>".$result['name']." ".$result['surname']."</p>
                            </div>
                        </a>";
                      }else{
                        echo "<div class=''>
                      <a href=profile.php?id=".$item['UserID'].">
                            <div id='user'>
                              <img id='profile' src=".$result['profilepicture'].">
                              <p>".$result['name']." ".$result['surname']."</p>
                            </div>
                        </a>";
                        }          
                      }
                    
                      echo "<div class='relative hover:drop-shadow-xl'>
                        <div class='relative h-72 w-full overflow-hidden rounded-lg'>
                          <img src=".$item['ItemPicture']." alt='Front of zip tote bag with white canvas, black canvas straps and handle, and black zipper pulls.' class='h-full w-full object-cover object-center'>
                        </div>
                        <div class='relative mt-4'>
                          <h3 class='text-sm font-medium text-gray-900'>".$item["Name"]."</h3>
                          <p class='mt-1 text-sm text-gray-500'>".$item['Size']."</p>
                          <a href='#' class='hover:bg-red-500'>
                            <svg id='heart' xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-suit-heart' viewBox='0 0 16 16'>
                            <path d='m8 6.236-.894-1.789c-.222-.443-.607-1.08-1.152-1.595C5.418 2.345 4.776 2 4 2 2.324 2 1 3.326 1 4.92c0 1.211.554 2.066 1.868 3.37.337.334.721.695 1.146 1.093C5.122 10.423 6.5 11.717 8 13.447c1.5-1.73 2.878-3.024 3.986-4.064.425-.398.81-.76 1.146-1.093C14.446 6.986 15 6.131 15 4.92 15 3.326 13.676 2 12 2c-.777 0-1.418.345-1.954.852-.545.515-.93 1.152-1.152 1.595L8 6.236zm.392 8.292a.513.513 0 0 1-.784 0c-1.601-1.902-3.05-3.262-4.243-4.381C1.3 8.208 0 6.989 0 4.92 0 2.755 1.79 1 4 1c1.6 0 2.719 1.05 3.404 2.008.26.365.458.716.596.992a7.55 7.55 0 0 1 .596-.992C9.281 2.049 10.4 1 12 1c2.21 0 4 1.755 4 3.9' 0 2.069-1.3 3.288-3.365 5.227-1.193 1.12-2.642 2.48-4.243 4.38z'/>
                          </svg></a>
                        </div>
                        <div class='absolute inset-x-0 top-0 flex h-72 items-end justify-end overflow-hidden rounded-lg p-4'>
                          <div aria-hidden='true' class='absolute inset-x-0 bottom-0 h-36 bg-gradient-to-t from-black opacity-50'></div>
                          <p class='relative text-lg font-semibold text-white'>".$item['Price']."£</p>
                        </div>
                      </div>
                    </div>
                    ";
                    
                }
            }
        ?>
        </div>

    </body>

    <footer class="bg-gray-300">
      <div class="mx-auto max-w-7xl overflow-hidden py-12 px-4 sm:px-6 lg:px-8">
        <nav class="-mx-5 -my-2 flex flex-wrap justify-center" aria-label="Footer">
          <div class="px-5 py-2">
            <a href="#" class="text-base text-gray-500 hover:text-gray-900">Lorem.</a>
          </div>
    
          <div class="px-5 py-2">
            <a href="#" class="text-base text-gray-500 hover:text-gray-900">Lorem.</a>
          </div>
    
          <div class="px-5 py-2">
            <a href="#" class="text-base text-gray-500 hover:text-gray-900">Lorem.</a>
          </div>
    
          <div class="px-5 py-2">
            <a href="#" class="text-base text-gray-500 hover:text-gray-900">Lorem.</a>
          </div>
    
          <div class="px-5 py-2">
            <a href="#" class="text-base text-gray-500 hover:text-gray-900">About us</a>
          </div>
        </nav>
        <div class="mt-8 flex justify-center space-x-6">
          <a href="#" class="text-gray-400 hover:text-gray-500">
            <span class="sr-only">Facebook</span>
            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
              <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" />
            </svg>
          </a>
    
          <a href="#" class="text-gray-400 hover:text-gray-500">
            <span class="sr-only">Instagram</span>
            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
              <path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" />
            </svg>
          </a>
    
          <a href="#" class="text-gray-400 hover:text-gray-500">
            <span class="sr-only">Twitter</span>
            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
              <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
            </svg>
          </a>
    
          <a href="#" class="text-gray-400 hover:text-gray-500">
            <span class="sr-only">GitHub</span>
            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
              <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd" />
            </svg>
          </a>
        </div>
        <p class="mt-8 text-center text-base text-gray-400">&copy; 2022 Shoesur, Inc. All rights reserved.</p>
      </div>
    </footer>
</html>