<!DOCTYPE HTML>
<html lang="en">
    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous"> 
        <link rel="stylesheet" href="/Website-Projekt/css/main.css">
        <script src="/Website-Projekt/js/main.js"></script>
    </head>
    <body>
        <main>
            <h1 class="text-left, text-right, text-center">Please wait while we sign you out</h1>
        </main>
        <?php include 'footer.php';?>
        <script>
            sleep(10000);
            window.location.href = "main.php";
        </script>
    </body>
</html>