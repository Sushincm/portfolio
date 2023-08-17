<?php
$my_email = "sushinofficial@gmail.com";
$continue = "sushinofficial@gmail.com";
$errors = array();
// Remove $_COOKIE elements from $_REQUEST.
if(count($_COOKIE)){foreach(array_keys($_COOKIE) as $value){unset($_REQUEST[$value]);}}
// Check all fields for an email header.
function recursive_array_check_header($element_value)
{
global $set;
if(!is_array($element_value)){if(preg_match("/(%0A|%0D|\n+|\r+)(content-type:|to:|cc:|bcc:)/i",$element_value)){$set = 1;}}
else
{
foreach($element_value as $value){if($set){break;} recursive_array_check_header($value);}
}
}
recursive_array_check_header($_REQUEST);
if($set){$errors[] = "You cannot send an email header";}
unset($set);
// Validate email field.
if(isset($_REQUEST['email']) && !empty($_REQUEST['email']))
{
if(preg_match("/(%0A|%0D|\n+|\r+|:)/i",$_REQUEST['email'])){$errors[] = "Email address may not contain a new line or a colon";}
$_REQUEST['email'] = trim($_REQUEST['email']);
if(substr_count($_REQUEST['email'],"@") != 1 || stristr($_REQUEST['email']," ")){$errors[] = "Email address is invalid";}else{$exploded_email = explode("@",$_REQUEST['email']);if(empty($exploded_email[0]) || strlen($exploded_email[0]) > 64 || empty($exploded_email[1])){$errors[] = "Email address is invalid";}else{if(substr_count($exploded_email[1],".") == 0){$errors[] = "Email address is invalid";}else{$exploded_domain = explode(".",$exploded_email[1]);if(in_array("",$exploded_domain)){$errors[] = "Email address is invalid";}else{foreach($exploded_domain as $value){if(strlen($value) > 63 || !preg_match('/^[a-z0-9-]+$/i',$value)){$errors[] = "Email address is invalid"; break;}}}}}}
}
// Check referrer is from same site.
if(!(isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER']) && stristr($_SERVER['HTTP_REFERER'],$_SERVER['HTTP_HOST']))){$errors[] = "You must enable referrer logging to use the form";}
// Check for a blank form.
function recursive_array_check_blank($element_value)
{
global $set;
if(!is_array($element_value)){if(!empty($element_value)){$set = 1;}}
else
{
foreach($element_value as $value){if($set){break;} recursive_array_check_blank($value);}
}
}
recursive_array_check_blank($_REQUEST);
if(!$set){$errors[] = "You cannot send a blank form";}
unset($set);
// Display any errors and exit if errors exist.
if(count($errors)){foreach($errors as $value){print "$value<br>";} exit;}
if(!defined("PHP_EOL")){define("PHP_EOL", strtoupper(substr(PHP_OS,0,3) == "WIN") ? "\r\n" : "\n");}
// Build message.
function build_message($request_input){if(!isset($message_output)){$message_output ="";}if(!is_array($request_input)){$message_output = $request_input;}else{foreach($request_input as $key => $value){if(!empty($value)){if(!is_numeric($key)){$message_output .= str_replace("_"," ",ucfirst($key)).": ".build_message($value).PHP_EOL.PHP_EOL;}else{$message_output .= build_message($value).", ";}}}}return rtrim($message_output,", ");}
$message = build_message($_REQUEST);
$message = $message . PHP_EOL.PHP_EOL."-- ".PHP_EOL."";
$message = stripslashes($message);
$subject = "SUSHIN'S PORTFOLIO";
$headers = "From: " . $_REQUEST['Name'];
mail($my_email,$subject,$message,$headers);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <!-- Font Link -->
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@100;300;400;700&family=Signika+Negative:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Icon Link -->
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
    integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
</head>
<body> 
<style>
    body{
        background: #152136;
        color: #fff;
        font-family: 'Lato',sans-serif;
    }
    a{
        text-decoration: none;
        color: #fff;
        padding: 10px 20px;
        border: #7bab7f solid 2px;
        font-size: 13px;
    }
    .sent-body{
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
    }
    i{
        font-size: 90px;
        color: #8CC090;
    }
    .sent-body h2{
        font-weight: 400;
        font-size: 40px;        
    }
    .sent-body h4{
        margin-bottom: 40px;
        font-weight: 400;
    }
    @media (max-width:300px){
        body{
            display: none;
        }
    }
</style>

    <div class="sent-body">
        <i class="far fa-check-circle"></i>
        <h3>Thank You</h3>
        <h4>Your mail has been sent</h4>
        <a href="../index.html">BACK TO HOME</a>
    </div>
</body>
</html>