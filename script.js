
 
	//for mobile view
  const menuHamburger = document.querySelector("#menu-hamburger")
  const navLinks = document.querySelector(".navlinks")
  menuHamburger.addEventListener('click',()=>
  {
    navLinks.classList.toggle('mobile-menu')
  }
  )
  //to not display the header content while menu is open
  const icon = document.querySelector('#menu-hamburger');
  const content = document.querySelector('.header-content');
  icon.addEventListener('click', function() 
  {
    if (content.style.display === 'none')
    {
       content.style.display = 'block';
     } else 
     {
       content.style.display = 'none';
     }
  }
   );
   // change menu icon to close icon while open
   let changeIcon = function(close)
   {
     icon.classList.toggle('fa-xmark')
   }

  // get the contact button, contact container, contact form, and close button
  const contactBtn1 = document.getElementById('contact-btn-link');
const contactBtn = document.getElementById('contact-btn');
const registerBtn = document.getElementById('log-in-btn');
const logBtn =document.getElementById('to-log-btn')
const SignUpBtn =document.getElementById('sign-up-btn')
const contactContainer = document.getElementById('contact-container');
const registerPage = document.getElementById('register-page')
const signUpPage = document.getElementById('sign-up-page')
const main = document.getElementById('main');
const closeBtn = document.getElementById('close-btn');
const closeLogInPageBtn = document.getElementById('close-register-page-btn');
const closeSignUpPageBtn =document.getElementById('close-sign-up-page-btn')
const footer =document.getElementById('footer');
const header =document.getElementById('header');

// show the contact form and hide the page content when the contact button is clicked
contactBtn1.addEventListener('click', () => {
 contactContainer.style.display = 'block'; // show the contact container
 main.style.display = 'none'; // hide the page container
 footer.style.display = 'none';
 header.style.display = 'none';

});
contactBtn.addEventListener('click', () => {
 contactContainer.style.display = 'block'; // show the contact container
 main.style.display = 'none'; // hide the page container
 footer.style.display = 'none';
 header.style.display = 'none';

});

// hide the contact form and show the page content when the close button is clicked
closeBtn.addEventListener('click', () => {
 contactContainer.style.display = 'none'; // hide the contact container
 main.style.display = 'block'; // show the page container
 header.style.display = 'block';
 footer.style.display = 'block';

});
// show the log in form and hide the page content when the log in button is clicked
registerBtn.addEventListener('click', () => {
 registerPage.style.display = 'block'; // show the log in  container
 main.style.display = 'none'; // hide the page container
 footer.style.display = 'none';
 header.style.display = 'none';

});
// hide the log in form and show the page content when the close button is clicked
closeLogInPageBtn.addEventListener('click', () => {
 registerPage.style.display = 'none'; // hide the log in  container
 main.style.display = 'block'; // show the page container
 header.style.display = 'block';
 footer.style.display = 'block';

});
// show the log in form and hide the page content when the log in button is clicked
logBtn.addEventListener('click', () => {
 registerPage.style.display = 'block'; // show the log in  container
 main.style.display = 'none'; // hide the page container
 signUpPage.style.display = 'none'
 footer.style.display = 'none';
 header.style.display = 'none';


});

// show the sign up form and hide the page content when the sign up button is clicked
SignUpBtn.addEventListener('click', () => {
 signUpPage.style.display = 'block'; // show the sign up  page
 main.style.display = 'none'; // hide the page container
 registerPage.style.display = 'none'
 footer.style.display = 'none';
 header.style.display = 'none';

});
// hide the sign up form and show the page content when the close button is clicked
closeSignUpPageBtn.addEventListener('click', () => {
 signUpPage.style.display = 'none'; // hide the log in  page
 main.style.display = 'block'; // show the page container
 header.style.display = 'block';
 footer.style.display = 'block';

});

 // show and hide the password in log in form  
function showPassword(){
   var a = document.getElementById("password-input");
   var b = document.getElementById("hide");
   var c = document.getElementById("unhide");

   if( a.type === 'password'){
       a.type = "text";
       b.style.display = "block";
       c.style.display = "none";

   }
   else{
       a.type = "password";
       b.style.display = "none";
       c.style.display = "block";

   }

  }
  function showPasswordSignUp(){
   var u = document.getElementById("password-input");
   var i = document.getElementById("sign-up-hide1");
   var o = document.getElementById("sign-up-unhide1");
  

   if( u.type === 'password'){
       u.type = "text";
       i.style.display = "block";
       o.style.display = "none";

       

   }
   else{
       u.type = "password";
       i.style.display = "none";
       o.style.display = "block";

       

   }

  }
  function showConfirmPassword(){
   var q = document.getElementById("confirm-password-input");
   var w = document.getElementById("sign-up-hide2");
   var e = document.getElementById("sign-up-unhide2");
  

   if( q.type === 'password'){
       q.type = "text";
       w.style.display = "block";
       e.style.display = "none";

       

   }
   else{
       q.type = "password";
       w.style.display = "none";
       e.style.display = "block";

       

   }

  }
 

  var profileBtn = document.getElementById('profile-btn')
  var NormalUserBtn = document.getElementById('profile-btn1')
  var ProUserBtn = document.getElementById('profile-btn2')
  

function NormalUserClick() {
 profileBtn.style.left = '0'
   NormalUserBtn.style.color = "white";
   ProUserBtn.style.color = "grey";

  
  
}

function ProUserClick() {
 profileBtn.style.left = '120px'
   ProUserBtn.style.color = "white";
   NormalUserBtn.style.color = "grey";
}

    
    
    