<?php
 @include '../Configuration/connect.php';
 session_start();
 if(!isset($_SESSION['agent_name']) AND !isset($_SESSION['agent_last_name']))
 {
   header('location:../Register/log-in.php');
 }
 $success=0;
 $failure=0;
 if(isset($_POST['postReview']))
 {
    $reviewerName= $_SESSION['agent_name'];
    $reviewerLastName = $_SESSION['agent_last_name'] ;
    $starsRating = $_POST['starsRating'];
    $comment = $_POST['comment'];
    //checking empty condition
    if($starsRating=='' or $comment=='')
    {
      $failure=1;
    }
    else
    {
      //insert query
      $insert_review="insert into `review` (reviewerName, reviewerLastName, starsRating, comment) values ('$reviewerName', '$reviewerLastName', '$starsRating', '$comment')";
      $result = $connect->query($insert_review);
      if($result)
      {
        $success=1;
      }
    }
  }

?>



<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/all.min.css">
        <link rel="stylesheet" href="../CssFiles/review.css">
        <title>Review</title>
    </head>
    <body>
    <?php
     if($failure)
     {
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
              Please fill all fields.
              </div>';
      }
      if($success)
      {
         echo '<div style="background:rgb(212,237,218); color:rgb(53,112,67);" class="alert alert-warning alert-dismissible fade show" role="alert">
                Thank you for your review!
               </div>';
      }
   ?>
      <header style="height:100px;">
        <a href="../Home/home_agent.php"><img style="height: 180px;" src="../img/Logo/ZiriLogoBlack.png" alt=""></a>
      </header>
     
        <section class="modal container">
           

            <div class="modal__container" id="modal-container">
                <div class="modal__content">
                    <div class="modal__close close-modal" title="Close">
                    <a href="../AgentSession/agent-page.php"><i class="fa-solid fa-xmark"></i></a>
                    </div>
                    <form method="post">
                    <div class="names">
                        <p><span name="reviewerName"><?php echo $_SESSION['agent_name']?></span>&nbsp;<span name="reviewerLastName"><?php echo $_SESSION['agent_last_name']?></span></p>
                    </div>
                    <h1 class="modal__title">Please rate your experience!</h1>
                    
                    <div align="center" style="background: none; color:#7e7eb5; position:relative;top:10px;">
                       <i class="fa fa-star fa-2x" data-index="0"></i>
                       <i class="fa fa-star fa-2x" data-index="1"></i>
                       <i class="fa fa-star fa-2x" data-index="2"></i>
                       <i class="fa fa-star fa-2x" data-index="3"></i>
                       <i class="fa fa-star fa-2x" data-index="4"></i>
                       <br><br>
                        
                   </div>
                    
                    <p class="modal__description">Leave a comment</p>

                    
                       <textarea maxlength="145" type="text" placeholder="Write here..." name="comment" class="input"></textarea>
                       <input type="hidden" id="rating" name="starsRating">
                    

                    <button type="submit" name="postReview" class="modal__button-link close-modal">
                        Submit
                    </button>
        </form>
                </div>
            </div>
        </section>

        
        
    </body>
    <script>
     
       /*=============== CLOSE MODAL ===============*/
       const closeBtn = document.querySelectorAll('.close-modal')
        function closeModal(){
     const modalContainer = document.getElementById('modal-container')
     modalContainer.classList.remove('show-modal')
       }
        closeBtn.forEach(c => c.addEventListener('click', closeModal))
     </script>
     <script src="http://code.jquery.com/jquery-3.4.0.min.js" integrity="sha256-BJeo0qm959uMBGb65z40ejJYGSgR7REI4+CW1fNKwOg=" crossorigin="anonymous"></script>
     <script>
        var ratedIndex = -1, uID = 0;

        $(document).ready(function () {
            resetStarColors();

            if (localStorage.getItem('ratedIndex') != null) {
                setStars(parseInt(localStorage.getItem('ratedIndex')));
                uID = localStorage.getItem('uID');
            }

            $('.fa-star').on('click', function () {
               ratedIndex = parseInt($(this).data('index'));
               localStorage.setItem('ratedIndex', ratedIndex);
               saveToTheDB();
            });

            $('.fa-star').mouseover(function () {
                resetStarColors();
                var currentIndex = parseInt($(this).data('index'));
                setStars(currentIndex);
            });

            $('.fa-star').mouseleave(function () {
                resetStarColors();

                if (ratedIndex != -1)
                    setStars(ratedIndex);
            });
        });

        function saveToTheDB() {
            $.ajax({
               url: "index.php",
               method: "POST",
               dataType: 'json',
               data: {
                   save: 1,
                   uID: uID,
                   ratedIndex: ratedIndex
               }, success: function (r) {
                    uID = r.id;
                    localStorage.setItem('uID', uID);
               }
            });
        }

        function setStars(max) {
            for (var i=0; i <= max; i++)
                $('.fa-star:eq('+i+')').css('color', '#edc531');
        }

        function resetStarColors() {
            $('.fa-star').css('color', '#7e7eb5');
        }
        const stars = document.querySelectorAll('.fa-star');
const ratingInput = document.getElementById('rating');

stars.forEach((star, index) => {
  star.addEventListener('click', () => {
    ratingInput.value = index + 1;
    updateStarRating(index);
  });
});

function updateStarRating(selectedIndex) {
  stars.forEach((star, index) => {
    if (index <= selectedIndex) {
      star.classList.add('selected');
    } else {
      star.classList.remove('selected');
    }
  });
}


    </script>
</html>