<?php
 
  

  function display() /*correct */
  {
     if(require("../Configuration/connect.php"))
     {
        $req=$connect->prepare("SELECT * FROM property");
        $req->execute();
        $data = $req->fetchAll(PDO::FETCH_OBJ);
        return $data;
        $req->closeCursor();
        
     }
  }

  function displayToVerify() /*correct */
  {
     if(require("../Configuration/connect.php"))
     {
        $req=$connect->prepare("SELECT * FROM property WHERE Verified=''");
        $req->execute();
        $data = $req->fetchAll(PDO::FETCH_OBJ);
        return $data;
        $req->closeCursor();
        
     }
  }
  function displayRentalsToVerify() /**correct */
  {
     if(require("../Configuration/connect.php"))
     {
        $req=$connect->prepare("SELECT * FROM vacationrentals WHERE Verified=''");
        $req->execute();
        $data = $req->fetchAll(PDO::FETCH_OBJ);
        return $data;
        $req->closeCursor();
        
     }
  }
  
  function Admins()/* correct */
  {
     if(require("../Configuration/connect.php"))
     {
        $req=$connect->prepare("SELECT * FROM admintable");
        $req->execute();
        $data = $req->fetchAll(PDO::FETCH_OBJ);
        return $data;
        $req->closeCursor();
        
     }
  }

  function agents()/*correct */
  {
     if(require("../Configuration/connect.php"))
     {
        $req=$connect->prepare("SELECT * FROM user WHERE user_type='agent' AND Verified='yes'");
        $req->execute();
        $data = $req->fetchAll(PDO::FETCH_OBJ);
        return $data;
        $req->closeCursor();
        
     }
  }





  function users()/* correct */
  {
     if(require("../Configuration/connect.php"))
     {
        $req=$connect->prepare("SELECT * FROM user WHERE user_type = 'user'");
        $req->execute();
        $data = $req->fetchAll(PDO::FETCH_OBJ);
        return $data;
        $req->closeCursor();
        
     }
  }




  function displayPendingAgents() /*correct*/ 
  {
     if(require("../Configuration/connect.php"))
     {
        $req = $connect->prepare("SELECT * FROM user WHERE user_type = 'agent' AND license <> '' AND Verified='' ORDER BY id DESC");
        $req->execute();
        $data = $req->fetchAll(PDO::FETCH_OBJ);
        return $data;
        $req->closeCursor();
     }
  }

  function displayPendingReviews() /*correct*/ 
  {
     if(require("../Configuration/connect.php"))
     {
        $req = $connect->prepare("SELECT * FROM review WHERE Verified=''");
        $req->execute();
        $data = $req->fetchAll(PDO::FETCH_OBJ);
        return $data;
        $req->closeCursor();
     }
  }

  function DeleteAdmin($id){  /* correct*/
   if(require("../Configuration/connect.php"))
   {
      $req=$connect->prepare("DELETE FROM admintable WHERE id=?");
      $req->execute(array($id));
   }

  }

  function DeleteUser($id){  /* correct*/
   if(require("../Configuration/connect.php"))
   {
      $req=$connect->prepare("DELETE FROM user WHERE user_type = 'user' AND id=?");
      $req->execute(array($id));
   }

  }

  
  function DeletePendingAgent($id){  /*correct */
   if(require("../Configuration/connect.php"))
   {
      $req=$connect->prepare("DELETE FROM user WHERE user_type = 'agent' AND  id=?");
      $req->execute(array($id));
   }

  }

  function DeleteProperty($id){ 
   if(require("../Configuration/connect.php"))
   {
      $req=$connect->prepare("DELETE FROM property WHERE  id=?");
      $req->execute(array($id));
   }

  }

  function DeleteRental($id){  /*correct */
   if(require("../Configuration/connect.php"))
   {
      $req=$connect->prepare("DELETE FROM vacationrentals WHERE  id=?");
      $req->execute(array($id));
   }

  }

  function DeleteReview($id){ /*correct */
   if(require("../Configuration/connect.php"))
   {
      $req=$connect->prepare("DELETE FROM review WHERE id=?");
      $req->execute(array($id));
   }
  }
   
  function displayRent()
  {
     if(require("../Configuration/connect.php"))
     {
        $req=$connect->prepare("SELECT * FROM property WHERE propertyStatus='For rent'");
        $req->execute();
        $data = $req->fetchAll(PDO::FETCH_OBJ);
        return $data;
        $req->closeCursor();
        
     }
  }
  function displayRentals()
  {
     if(require("../Configuration/connect.php"))
     {
        $req=$connect->prepare("SELECT * FROM vacationrentals");
        $req->execute();
        $data = $req->fetchAll(PDO::FETCH_OBJ);
        return $data;
        $req->closeCursor();
        
     }
  }

  function myProperties()
  {
    if(require("../Configuration/connect.php"))
    {
       $req=$connect->prepare("SELECT * FROM property WHERE posterName= '{$_SESSION['agent_name']}' AND posterLastName= '{$_SESSION['agent_last_name']}'");
       $req->execute();
       $data = $req->fetchAll(PDO::FETCH_OBJ);
       $req->closeCursor();
       return $data;
    }
  }

  function myRentalsUser()/**correct */
  {
    if(require("../Configuration/connect.php"))
    {
       $req=$connect->prepare("SELECT * FROM vacationrentals WHERE rentalPosterName= '{$_SESSION['user_name']}' AND rentalPosterLastName= '{$_SESSION['user_last_name']}'");
       $req->execute();
       $data = $req->fetchAll(PDO::FETCH_OBJ);
       $req->closeCursor();
       return $data;
    }
  }

  function myRentalsAgent()/**correct */
  {
    if(require("../Configuration/connect.php"))
    {
       $req=$connect->prepare("SELECT * FROM vacationrentals WHERE rentalPosterName= '{$_SESSION['agent_name']}' AND rentalPosterLastName= '{$_SESSION['agent_last_name']}'");
       $req->execute();
       $data = $req->fetchAll(PDO::FETCH_OBJ);
       $req->closeCursor();
       return $data;
    }
  }

  
  function displayAgentsHome()/*correct */
  {
     if(require("../Configuration/connect.php"))
     {
        $req = $connect->prepare("SELECT * FROM user WHERE user_type = 'agent' AND Verified='yes'  ORDER BY id DESC LIMIT 9");
        $req->execute();
        $data = $req->fetchAll(PDO::FETCH_OBJ);
        return $data;
        $req->closeCursor();
     }
  }
  
  function Latest()/**correct */
  {
    if(require("../Configuration/connect.php"))
     {
        $req=$connect->prepare("SELECT * FROM property ORDER BY id DESC LIMIT 9");
        $req->execute();
        $data = $req->fetchAll(PDO::FETCH_OBJ);
        return $data;
        $req->closeCursor();
     }
  }
  function LatestRentals()/**correct */
  {
    if(require("../Configuration/connect.php"))
     {
        $req=$connect->prepare("SELECT * FROM vacationrentals ORDER BY id DESC LIMIT 9");
        $req->execute();
        $data = $req->fetchAll(PDO::FETCH_OBJ);
        return $data;
        $req->closeCursor();
     }
  }
  function LatestReviews()/**correct */
  {
    if(require("../Configuration/connect.php"))
     {
      $req = $connect->prepare("SELECT review.id, review.starsRating, review.comment, review.reviewerName, review.reviewerLastName, user.profilePicture, user.user_type FROM review INNER JOIN user ON review.reviewerName = user.name AND review.reviewerLastName = user.last_name WHERE review.Verified='yes' ORDER BY id DESC LIMIT 12");
        $req->execute();
        $data = $req->fetchAll(PDO::FETCH_OBJ);
        return $data;
        $req->closeCursor();
     }
  }
  
  function getProperty($id)
  {
    if(require("../Configuration/connect.php"))
     {
        $req=$connect->prepare("SELECT * FROM property WHERE id=?");
        $req->execute(array($id));
        if($req->rowCount() == 1){
         $data = $req->fetchALL(PDO::FETCH_OBJ);
         return $data;

        }else{
         return false;
        }
        $req->closeCursor();
     }
  }
  function getRental($id)
  {
    if(require("../Configuration/connect.php"))
     {
        $req=$connect->prepare("SELECT * FROM vacationrentals WHERE id=?");
        $req->execute(array($id));
        if($req->rowCount() == 1){
         $data = $req->fetchALL(PDO::FETCH_OBJ);
         return $data;

        }else{
         return false;
        }
        $req->closeCursor();
     }
  }
  
  function getAgentAdditionalInfos($id)
  {
    if(require("../Configuration/connect.php"))
     {
        $req=$connect->prepare("SELECT aboutMe, homeAddress, linkedinLink, facebookLink, instagramLink, agreement, profilePicture, license FROM user WHERE id = ? AND user_type='agent' ");
        $req->execute(array($id));
        if($req->rowCount() == 1){
         $data = $req->fetchALL(PDO::FETCH_OBJ);
         return $data;

        }else{
         return false;
        }
        $req->closeCursor();
     }
  }
  
  function EditProperty($propertyTitle, $propertyAddress, $propertyCity, $propertyCountry, $propertyType, $propertyStatus, $propertyPrice, $propertyMain_image, $propertyFirst_image, $propertySecond_image, $propertyThird_image, $propertyFourth_image, $propertyFifth_image, $propertySixth_image, $propertySize, $propertyFloors, $propertyNumber_of_bedrooms, $propertyNumber_of_bathrooms, $propertyGarage, $propertyOutdoors, $propertyDescription, $id )
  {
    if(require("../Configuration/connect.php"))
    {
        $req = $connect->prepare("UPDATE property SET `propertyTitle`=?, `propertyAddress`=?, `propertyCity`=?, `propertyCountry`=?, `propertyType`=?, `propertyStatus`=?, `propertyPrice`=?, `propertyMain_image`=?, `propertyFirst_image`=?, `propertySecond_image`=?, `propertyThird_image`=?, `propertyFourth_image`=?, `propertyFifth_image`=?, `propertySixth_image`=?, `propertySize`=?, `propertyFloors`=?, `propertyNumber_of_bedrooms`=?, `propertyNumber_of_bathrooms`=?, `propertyGarage`=?, `propertyOutdoors`=?, `propertyDescription`=? WHERE id=?");
        $req->execute(array($propertyTitle, $propertyAddress, $propertyCity, $propertyCountry, $propertyType, $propertyStatus, $propertyPrice, $propertyMain_image, $propertyFirst_image, $propertySecond_image, $propertyThird_image, $propertyFourth_image, $propertyFifth_image, $propertySixth_image, $propertySize, $propertyFloors, $propertyNumber_of_bedrooms, $propertyNumber_of_bathrooms, $propertyGarage, $propertyOutdoors, $propertyDescription, $id ));
        $req->closeCursor();
    }
  } 

 function EditRental($rentalTitle, $rentalAddress, $rentalCity, $rentalCountry, $rentalMainImage, $rentalFirstImage, $rentalSecondImage, $rentalThirdImage, $rentalFourthImage, $rentalFifthImage, $rentalSixthImage, $rentalListingType, $rentalType, $Bedrooms, $Bathrooms, $Amenities, $size, $HouseRules, $AvailabilityFrom, $AvailabilityTo, $rentalAskingPrice, $perWeekPerNight, $rentalCurrency, $rentalDescription, $notes, $HostName, $rentalStatus, $rentalGarage, $rentalOutdoors, $accommodation, $id)
{  /** *correct*/
    if (require("../Configuration/connect.php")) {
        $req = $connect->prepare("UPDATE vacationrentals SET `rentalTitle`=?, `rentalAddress`=?, `rentalCity`=?, `rentalCountry`=?, `rentalMainImage`=?, `rentalFirstImage`=?, `rentalSecondImage`=?, `rentalThirdImage`=?, `rentalFourthImage`=?, `rentalFifthImage`=?, `rentalSixthImage`=?, `rentalListingType`=?, `rentalType`=?, `Bedrooms`=?, `Bathrooms`=?, `Amenities`=?, `size`=?, `HouseRules`=?, `AvailabilityFrom`=?, `AvailabilityTo`=?, `rentalAskingPrice`=?, `perWeekPerNight`=?, `rentalCurrency`=?, `rentalDescription`=?, `notes`=?, `HostName`=?, `rentalStatus`=?, `rentalGarage`=?, `rentalOutdoors`=?, `accommodation`=? WHERE id=?");
        $req->execute(array($rentalTitle, $rentalAddress, $rentalCity, $rentalCountry, $rentalMainImage, $rentalFirstImage, $rentalSecondImage, $rentalThirdImage, $rentalFourthImage, $rentalFifthImage, $rentalSixthImage, $rentalListingType, $rentalType, $Bedrooms, $Bathrooms, $Amenities, $size, $HouseRules, $AvailabilityFrom, $AvailabilityTo, $rentalAskingPrice, $perWeekPerNight, $rentalCurrency, $rentalDescription, $notes, $HostName, $rentalStatus, $rentalGarage, $rentalOutdoors, $accommodation, $id));
        $req->closeCursor();
    }
}


  
  function addAgentInfos($aboutMe, $homeAddress, $phoneNumber, $linkedinLink, $facebookLink, $instagramLink, $agreement, $profilePicture, $license, $id)
  { /**correct */
    if(require("../Configuration/connect.php"))
    {
        $req = $connect->prepare("UPDATE user SET `aboutMe`=?, `homeAddress`=?, `phoneNumber`=?, `linkedinLink`=?, `facebookLink`=?, `instagramLink`=?, `agreement`=?, `profilePicture`=?, `license`=? WHERE id=?");
        $req->execute(array($aboutMe, $homeAddress, $phoneNumber, $linkedinLink, $facebookLink, $instagramLink, $agreement, $profilePicture, $license, $id ));
        $req->closeCursor();
    }
  } 

  function addUserInfos($phoneNumber, $agreement, $profilePicture, $id)
  { /**correct */
    if(require("../Configuration/connect.php"))
    {
        $req = $connect->prepare("UPDATE user SET `phoneNumber`=?, `agreement`=?, `profilePicture`=?  WHERE id=?");
        $req->execute(array($phoneNumber, $agreement, $profilePicture,  $id ));
        $req->closeCursor();
    }
  } 

  

  function getAgentProfile($id)/**correct */
  {
    if(require("../Configuration/connect.php"))
     {
        $req=$connect->prepare("SELECT * FROM user WHERE user_type='agent' AND id=?");
        $req->execute(array($id));
        if($req->rowCount() == 1){
         $data = $req->fetchALL(PDO::FETCH_OBJ);
         return $data;

        }else{
         return false;
        }
        $req->closeCursor();
     }
  }

  function getUserProfile($id)/**correct */
  {
    if(require("../Configuration/connect.php"))
     {
        $req=$connect->prepare("SELECT * FROM user WHERE user_type='user' AND id=?");
        $req->execute(array($id));
        if($req->rowCount() == 1){
         $data = $req->fetchALL(PDO::FETCH_OBJ);
         return $data;

        }else{
         return false;
        }
        $req->closeCursor();
     }
  }
  
  
  function getAgentProfileId()
  {
    if(require("../Configuration/connect.php"))
     {
        $req=$connect->prepare("SELECT * FROM user WHERE user_type='agent' AND id=?");
        $req->execute(array($id));
        if($req->rowCount() == 1){
         $data = $req->fetchALL(PDO::FETCH_OBJ);
         return $data;

        }else{
         return false;
        }
        $req->closeCursor();
     }
  }

  

  function getId() /**correct */
  {
     if(require("../Configuration/connect.php"))
     {
        $req=$connect->prepare("SELECT * FROM user WHERE name = '{$_SESSION['agent_name']}' AND last_name = '{$_SESSION['agent_last_name']}'");
        $req->execute();
        $data = $req->fetchAll(PDO::FETCH_OBJ);
        return $data;
        $req->closeCursor();
        
     }
  }

  function getIdUser() /**correct */
  {
     if(require("../Configuration/connect.php"))
     {
        $req=$connect->prepare("SELECT * FROM user WHERE name = '{$_SESSION['user_name']}' AND last_name = '{$_SESSION['user_last_name']}'");
        $req->execute();
        $data = $req->fetchAll(PDO::FETCH_OBJ);
        return $data;
        $req->closeCursor();
        
     }
  }

  

  


 

function EditProfile($name, $last_name, $email, $phoneNumber, $hashedPassword, $aboutMe, $profilePicture, $linkedinLink, $facebookLink, $instagramLink, $homeAddress ,$id)
{  /**correct */
    if (require("../Configuration/connect.php")) {
        $req = $connect->prepare("UPDATE user SET `name`=?, `last_name`=?, `email`=?, `phoneNumber`=?, `password`=?, `aboutMe`=?, `profilePicture`=?, `linkedinLink`=?, `facebookLink`=?, `instagramLink`=?, `homeAddress`=? WHERE user_type='agent' AND id=?");
        $req->execute(array($name, $last_name, $email, $phoneNumber, $hashedPassword, $aboutMe, $profilePicture, $linkedinLink, $facebookLink, $instagramLink, $homeAddress ,$id));
        $req->closeCursor();
    }
}

function EditProfileUser($name, $last_name, $email, $phoneNumber, $hashedPassword, $profilePicture, $id)
{  /**correct */
    if (require("../Configuration/connect.php")) {
        $req = $connect->prepare("UPDATE user SET `name`=?, `last_name`=?, `email`=?, `phoneNumber`=?, `password`=?, `profilePicture`=? WHERE user_type='user' AND id=?");
        $req->execute(array($name, $last_name, $email, $phoneNumber, $hashedPassword, $profilePicture, $id));
        $req->closeCursor();
    }
}


?>