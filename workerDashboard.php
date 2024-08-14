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
        <link rel="stylesheet" href="CSS/carousel.css">
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

        <!-- This is the logic that we need to spawn with our call to the database and place in a mySlides class each -->

            <?php
                //establish connection
                require 'dbDash.php';
                //sql for getting remaining tasks Hmmmmm, is description a problem?
                $SQLString = "SELECT taskName, description, costEstimate FROM Tasks WHERE taskIsAssigned = 0";
                $result = $mysqli->query($SQLString);
                if ($result->num_rows > 0){
                    while ($row = $result->fetch_assoc()){
                        echo "
                            <div class='mySlides fade'>
                                <div class='card' style='width: 18rem;'>
                                    <img class='card-img-top' src='IMAGES/q1.png'>
                                    <div class='card-body>
                                        <div class='slideName'>" . $row["taskName"] . "</div>
                                        <div class='slideDescription'>" . $row["description"] . "</div>
                                        <div class='slideCostEstimate'>" . $row["costEstimate"] . "</div>
                                    </div>
                                </div>
                            </div>
                        ";
                    }
                    
                } else {
                    echo "<h3>No unassigned tasks</h3>";
                }
                $mysqli->close();
            ?>

        <!-- Next and previous buttons -->
            
            
        </div>
        <br>

        <!-- The dots/circles -->
        <div style="text-align:center">
            <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
            <span class="dot" onclick="currentSlide(1)"></span>
            <span class="dot" onclick="currentSlide(2)"></span>
            <span class="dot" onclick="currentSlide(3)"></span>
            <a class="next" onclick="plusSlides(1)">&#10095;</a>
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
                    slides[i].style.opacity = "0";
                    slides[i].style.display = "none";
                }
                for (i = 0; i < dots.length; i++) {
                    dots[i].className = dots[i].className.replace(" active", "");
                }
                slides[slideIndex-1].style.display = "block";
                slides[slideIndex-1].style.opacity = "1";
                dots[slideIndex-1].className += " active";
            } 
       </script>
        
    </body>
</html>