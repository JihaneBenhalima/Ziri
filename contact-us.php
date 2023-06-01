<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Website/css/all.min.css">
    <link rel="stylesheet" href="../Website/CssFiles/style.css">
    <title>Contact us</title>
</head>
<body>
<section class="contact-section" id="contact-container">
     <div class="contact-page">
       <div class="contact-container">
         <div class="close-contact-page" id="contact-close-btn">
            <a style="color: white;" onclick="goBack()"><i class="fa-solid fa-xmark"></i></a>
         </div>
         <div class="contact-details">
            <h2>Contact details</h2>
            <div class="contact-details-box">
              <div class="contact-icon"><i class="fa-solid fa-phone"></i></div>
                <div class="contact-details-text">
                  <h3>Phone</h3>
                  <p>Talk to a Customer Service Representative for help with our site or finding an Agent</p>
                  <p>+213-777-999-000</p>
                </div>
             </div>
             <div class="contact-details-box">
               <div class="contact-icon"><i class="fa-solid fa-envelope-open-text"></i></div>
                  <div class="contact-details-text">
                    <h3>Email</h3>
                    <p>Send our Customer Service Team questions or feedback</p>
                    <p>Ziri.properties@gmail.com</p>
                  </div>
             </div>
             <div class="contact-details-box">
               <div class="contact-icon"><i class="fa-regular fa-clock"></i></div>
                  <div class="contact-details-text">
                    <h3>Hours</h3>
                    <p>Sunday to thursday<br>From 9am to 4pm</p>
                  </div>
             </div>
               <div class="contact-socials">
                 <a href="https://fr-fr.facebook.com/"><i class="fa-brands fa-facebook"></i></a>
                 <a href="https://www.instagram.com/"> <i class="fa-brands fa-instagram"></i></a>
                 <a href="https://www.linkedin.com/"><i class="fa-brands fa-linkedin"></i></a>
             </div>
           </div>
           <div class="vertical-line"></div>
           <div class="contact-form">
             <form method="post" >
                <h2>Get in touch</h2>
                <div class="contact-page-row">
                  <div class="contact-input-box">
                    <input type="text" id="name" name="senderName" required>
                    <label for="name"><i class="fa-solid fa-user"></i> Full name</label>
                  </div>
                  <div class="contact-input-box">
                    <input type="text" id="phone" name="senderPhoneNumber" required>
                    <label for="phone"><i class="fa-solid fa-phone-volume"></i> Phone number</label>
                  </div>
                 </div>
                 <div class="contact-input-box">
                      <input type="text" id="email" name="senderEmail" required>
                      <label for="email"><i class="fa-regular fa-envelope"></i> Email address</label>
                 </div>
                 <div class="contact-input-box">
                    <select id="my-select" name="subject">
                      <option disabled selected>Why are you contacting us ?</option>
                      <option>Looking for information</option>
                      <option>Looking to rent/buy a property</option>
                      <option>Have a property you want to rent/sell</option>
                      <option>An agent wants to work with us</option>
                      <option>Signaling a problem</option>
                      <option>Signaling a problem</option>
                   </select>
                 </div>
                 <div class="contact-input-box">
                    <textarea id="message" required rows="8" name="message"></textarea>
                    <label for="message"><i class="fa-regular fa-message"></i>Your message</label>
                 </div>
                 <div class="contact-input-box">
                    <input type="submit" value="Submit" name="send">
                 </div>
              </form>
          </div>
       </div>
      </div>
    </section>
</body>
<script>
function goBack() {
  window.history.back();
}
</script>
</html>