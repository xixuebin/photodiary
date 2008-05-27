<?php

$LNG_DATE_FORMAT = "DD-MM-YYYY";

$MENU_TITLE1 = "New shot";
$MENU_TITLE2 = "Shots archive";
$MENU_TITLE3 = "Configuration";
$MENU_TITLE4 = "Log-out";
$MENU_TITLE5 = "Comments archive";


$LNG_SELECTYOURLANGUAGE = "Select your language:"; 
$LNG_CONTINUA = "NEXT STEP"; 

$LNG_CONFIG_TXT = "<p>
Welcome to <b>photoDiary</b> installation process!.</p>
<p>Open the file <code>common/config.php</code> with Notepad e modify the values between double quote.<br />
If you're not the server administrator this information are supplied to you by your site mantainer.</p>
<ul>
	<li><strong>localhost</strong>: usually you don't need to chnge this value</li>
	<li><strong>db</strong>: the name of the mySQL database linked at your site</li>
	<li><strong>username</strong>: mySQL service username </li>
	<li><strong>password</strong>: mySQL service password</li>
</ul>
<p>Save the file and close it.<br />
	You must set also write permission to the folder <code>shots</code> where photoDiary will store all your pictures: if your're not the server administrator please contact your site mantainer.</p>
<p>Now you are reay to proceed with <strong>photoDiary</strong> installation.</p>";

$LNG_CONFIG_ERROR = "WARNING!<br>An error occurred during mySQL Database connection. Please verify the information you wrote in <code>common/config.php</code> and try again.";

$LNG_EXIST_ERROR = "<b>WARNING!</b><br>photoDiary is already installed on this server.<br>If you proceed with the installation all the data stored in the mySQL database should be lost.";

$LNG_CREATE_TABLES = "Please click on the <code>next step</code> button to create the Database tables required for <b>photoDiary</b> work. If you experience errors please verify all data you wrote in <code>common/config.php</code> and also the correct working of your mySQL server.";

$LNG_FILL_FORM = "All the database tables were succesfully created!<br>Fill in the following form with your <b>photoDiary</b> information then click on <code>NEXT STEP</code> button.";

$LNG_TITLE = "Your photoDiary title:";
$LNG_EMAIL = "Administrator e-mail address:";
$LNG_USERNAME = "Administrator's username:";
$LNG_PASSWORD = "Administrator's password:";
$LNG_REMINDER = "All information are mandatory or photoDiary won't work correctly.<br>Don't forget your Username and your Password.";

$LNG_SETUPCOMPLETE = "Setup complete!";

$LNG_REGARDS1 = "Great";
$LNG_REGARDS2 = "is now ready";
$LNG_REGARDS3 = "look here";
$LNG_REGARDS4 = "Have fun";

$LNG_ADMIN_TXT1 = "Enter the photoDiary administration area:";
$LNG_ADMIN_TXT1_1 = "Forgot your password?";
$LNG_ADMIN_TXT2 = "Post Archive.";
$LNG_ADMIN_TXT2_1 = "Manage all your posts.";
$LNG_ADMIN_TXT3a = "New post.";
$LNG_ADMIN_TXT3a_1 = "Insert a new post: text and picture.";
$LNG_ADMIN_TXT3b = "Edit post.";
$LNG_ADMIN_TXT3b_1 = "Modify the selected post's information.";
$LNG_ADMIN_TXT4 = "Comments related the post selected.";
$LNG_ADMIN_TXT4_1 = "Read and manage the comments sent by visitors.";
$LNG_ADMIN_TXT4_2 = "Comments archive.";
$LNG_ADMIN_TXT5 = "Settings.";
$LNG_ADMIN_TXT5_1 = "Manage your photoDiary setup information and preferences.";
$LNG_ADMIN_TXT6 = "Password reminder.";
$LNG_ADMIN_TXT6_1 = "Login information was sent to the following E-mail address: ";

$LNG_ADMIN_EMPTY = "No results.";
$LNG_ADMIN_CALENDAR = "Open the calendar";
$LNG_ADMIN_IMGNOTE = "<b>Warning.</b><br>The picture must be a JPG.";
$LNG_ADMIN_UPDATE = "UPDATE »";
$LNG_ADMIN_DELETE = "Cancel completed";
$LNG_ADMIN_UPD_SUCCESS = "Update completed!";
$LNG_ADMIN_INS_SUCCESS = "Insert completed!";

$LNG_ADMIN_IMGERROR[1] = "Error unknown! Try again.";
$LNG_ADMIN_IMGERROR[2] = "The picture selected don't have the correct extension .JPG";

$LNG_ADMIN_FIELD1 = "Date:";
$LNG_ADMIN_FIELD2 = "Picture:";
$LNG_ADMIN_FIELD3 = "Text:";
$LNG_ADMIN_FIELD4 = "Publish:";
$LNG_ADMIN_FIELD5 = "photoDiary title:";
$LNG_ADMIN_FIELD6 = "E-mail administrator:";
$LNG_ADMIN_FIELD7 = "Language:";
$LNG_ADMIN_FIELD8 = "Username:";
$LNG_ADMIN_FIELD9 = "Password:";

$LNG_ADMIN_FORGOTSUBJECT = "photoDiary: password reminder";
$LNG_ADMIN_FORGOTBODY = "As you requested we are sending you the login information to access the admin panel of your photoDiary.";

$LNG_ALT_DELETE = "Delete";
$LNG_ALT_EDIT = "Edit";
$LNG_ALT_IMGSIZE = "View real size picture";
$LNG_ALT_COMMENTS = "Manage comments";
$LNG_ALT_EMAIL = "E-mail address";
$LNG_ALT_WEBSITE = "Web site";



?>