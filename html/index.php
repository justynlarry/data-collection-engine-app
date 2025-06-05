<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/main.css" />
    <script src="main/populateStates.js"></script>
    <title>Roof Brokers Realtor Registration</title>
</head> 
<body >



<header>    
<nav>
    <ul class="left">
        <li><a href="https://www.roofbrokersinc.com/Home/" target="blank"><img src="images/RBi_logo_black_blue.png" alt="Roof Brokers Blue Logo" width="auto" height="55"/></a></li>        
        <li><a href="https://www.roofbrokersinc.com/Home/About/" target="blank">About</a></li>
        <li><a href="https://www.roofbrokersinc.com/Home/Contact/" target="blank">Contact</a></li>
    </ul>
    <ul class="right">
        <li><a href="https://www.roofbrokersinc.com/Home/" target="blank">Home</a></li>
    </ul>
</nav>
</header>

<div class="main-content">
<div class="flex-container">    
    <h3>Roof Brokers Account Registration</h3>
        <div class="flex-containter">
        <form action="includes/formhandler.inc.php" method="post">
            <p>First Name <i>(required)</i></p>
            <input type="text" name="fname" placeholder="First Name (required)" required>
            <p>Last Name <i>(required)</i></p>
            <input type="text" name="lname" placeholder="Last Name">
            <p>E-mail <i>(required)</i></p>
            <input type="text" name="email" placeholder="E-Mail">
            <p>Cc Email </p>
            <input type="text" name="cc_email" placeholder="Cc Email">
            <p>Cell Phone <i>(required)</i></p>
            <input type="text" name="cell_phone" placeholder="Cell Phone Number">
            <p>Work Phone </p>
            <input type="text" name="work_phone" placeholder="Work Phone Number">
            <p>Home Phone </p>
            <input type="text" name="home_phone" placeholder="Home Phone Number">
            <p>Fax Number </p>
            <input type="text" name="fax" placeholder="Fax Number">
            <p>Company Name </p>
            <input type="text" name="company_name" placeholder="Company Name">
            <p>Company Address </p>
            <input type="text" name="company_addr1" placeholder="Company Address Line 1">
            <p>Company Address </p>
            <input type="text" name="company_addr2" placeholder="Company Address Line 2">
            <p>Company City </p>
            <input type="text" name="company_city" placeholder="City">
            <p>Company State </p> 
            
            <!-- State drop-down for all states included in main/populateState.js -->
            <select id="company_state" name="company_state">
                <option value="CO" selected>Select a State</option>
            </select>
            <p>Company Zip Code </p>
            <input type="text" name="company_zip" placeholder="Zip Code">
            

            <button type="submit">Register</button>
        </form>


    </div>  

</div>   

</div>




<footer>
<div class="links">    

    <a href="https://www.roofbrokersinc.com/Home/Privacy" target="blank">Privacy Policy</a>
    <a href="https://www.roofbrokersinc.com/Home/Terms" target="blank">Terms of Use</a>
</div> 
<div class="footer-links">
    <div class="rbi-logo">
        <a href="https://www.roofbrokersinc.com/Account/LoginRegister" target="blank"><img class="rbi_logo" src="images/RBi_logo_black_blue.png" alt="Roof Brokers Blue Logo" width="auto" height="55"/></a> 
    </div>

    <div class="social-media">
   
        <a href="https://www.facebook.com/roof.inspectionsbyRBI/" target="blank"><img src="images/facebook-icon.png" alt="Facebook Logo"></a>
        <a href="https://x.com/RoofBrokersInc" target="blank"><img src="images/twitter-icon.png" alt="Twitter/X Logo"></a>
        <a href="https://www.linkedin.com/in/roof-brokers-1221062a/" target="blank"><img src="images/linkedin-icon.png" alt="LinkedIn Logo"></a>
    </div>
</div>
<hr width="95%" size=".5" color="white">

<div class="accred">

    <a href="https://www.bbb.org/us/co/aurora/profile/roofing-contractors/roof-brokers-inc-1296-30277/#sealclick" target="blank"><img class="bbb" src="images/blue-seal-bbb.png" alt="Better Business Bureau Logo"></a>
    <a href="https://www.coloradoroofing.org/" target="blank"><img class="cra" src="images/cra-member.png" alt="CRA Member Logo"></a>
</div>
<hr width="95%" size=".5" color="white">
</footer>




</body> 
</html>