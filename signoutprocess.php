<!DOCTYPE HTML>
<html lang="en">
    <head>
        <?php
            session_start();
            session_destroy();
            include "header.php";
        ?>
    <link rel="stylesheet" href="/Website-Projekt/css/main.css">
    </head>
    <body>
        <main>
            <div class="center">
                <h1 class="text-left, text-right, text-center"> Please wait while we sign you out</h1>
            </div>
        </main>
        <?php include 'footer.php';?>
        <script>
            setTimeout(() => {  window.location = 'main.php'; }, 2000);
        </script>
    </body>
</html>