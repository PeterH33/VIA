<?php
//Secure page check for login and permission
//I believe that the same logic as for the manager can be applied, the worker is baseically our default state
session_start();

if (!isset($_SESSION['userName'])){
    header('Location: login.php');
    exit;
}

//I feel like I need some logic to flag this as a user and check for user... but perhaps not?
if ($_SESSION['isManager']){
    header('Location: managerDashboard.php');
    exit;
}

require_once 'sani.php';

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Worker Dashboard</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="CSS/mainStyle.css">
    </head>

    <body>
        <header class="dash-header">
            <div class="site-logo">logo</div>
            <a class="small-link" href="logout.php">Log Out</a>
        </header>

        <div class="container">
            <div class="row">
                <div class="col">
                    Task Image goes here
                </div>
                <div class="col">
                    Details of the Task goes here
                </div>
            </div>
        </div>

        <h3>Available Tasks</h3>

        <!-- Carousel goes here -->
         <!-- Slideshow container -->
        <div class="slideshow-container">

        <!-- Full-width images with number and caption text -->
            <div class="mySlides fade">
                <div class="numbertext">1 / 3</div>
                <img src="IMAGES/q1.png" style="width:100%">
                <div class="text">Caption Text</div>
            </div>

            <div class="mySlides fade">
                <div class="numbertext">2 / 3</div>
                <img src="IMAGES/q2.png" style="width:100%">
                <div class="text">Caption Two</div>
            </div>

            <div class="mySlides fade">
                <div class="numbertext">3 / 3</div>
                <img src="IMAGES/q3.png" style="width:100%">
                <div class="text">Caption Three</div>
            </div>

        <!-- Next and previous buttons -->
            <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
            <a class="next" onclick="plusSlides(1)">&#10095;</a>
        </div>
        <br>

        <!-- The dots/circles -->
        <div style="text-align:center">
            <span class="dot" onclick="currentSlide(1)"></span>
            <span class="dot" onclick="currentSlide(2)"></span>
            <span class="dot" onclick="currentSlide(3)"></span>
        </div> 
        

        <!-- I need to fetch all of the current tasks and put them up as cards -->


        <?php include 'footer.php';?>
       <script>
            let slideIndex = 1;
            showSlides(slideIndex);

            // Next/previous controls
            function plusSlides(n) {
                showSlides(slideIndex += n);
            }

            // Thumbnail image controls
            function currentSlide(n) {
                showSlides(slideIndex = n);
            }

            function showSlides(n) {
                let i;
                let slides = document.getElementsByClassName("mySlides");
                let dots = document.getElementsByClassName("dot");
                if (n > slides.length) {slideIndex = 1}
                if (n < 1) {slideIndex = slides.length}
                for (i = 0; i < slides.length; i++) {
                    slides[i].style.display = "none";
                }
                for (i = 0; i < dots.length; i++) {
                    dots[i].className = dots[i].className.replace(" active", "");
                }
                slides[slideIndex-1].style.display = "block";
                dots[slideIndex-1].className += " active";
            } 
       </script>
        
    </body>
</html>