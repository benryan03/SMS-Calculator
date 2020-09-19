<?php

use Twilio\Twiml\MessagingResponse;

header("content-type: text/xml");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";

session_start();

function saveSessionVariables(){
    $_SESSION['operation'] = $operation;
    $_SESSION['firstNum'] = $firstNum;
    $_SESSION['secondNum'] = $secondNum;
}

// Import session variables if they exist
$firstNum = null;
$secondNum = null;
if(isset($_SESSION['firstNum'])){
    $firstNum = $_SESSION['firstNum'];
}
if(isset($_SESSION['secondNum'])){
    $secondNum = $_SESSION['secondNum'];
}

// Parse input
$input = $_REQUEST['Body'];

// CLEAR
if (strtolower($input) == "clear" | strtolower($input) == "c"){
    session_unset();
    $output = "Cleared.";
}

// OPERATION
elseif (!isset($_SESSION['operation'])){
    $operation = $input;
    $output = $operation . ": Enter the first number.";
    saveSessionVariables();
}

// FIRST NUMBER
elseif ($firstNum == null) {
    $operation = $_SESSION['operation'];
    $firstNum = $_REQUEST['Body'];
    $output = "Enter the second number.";
    saveSessionVariables();
}

// SECOND NUMBER - CALCULATE RESULT
elseif($firstNum != null & $secondNum == null) {
    $operation = $_SESSION['operation'];
    $secondNum = $_REQUEST['Body'];
    switch($operation){
        case "+":
            $result = $firstNum + $secondNum;
        case "-":
            $result = $firstNum - $secondNum;
        case "*":
            $result = $firstNum * $secondNum;
        case "/":
            $result = $firstNum / $secondNum;
    }
    $output = $firstNum . " " . $operation . " " . $secondNum . " = " . $result;
    session_unset();
}

?>

<!-- This is "TwiML" code. The Twilio API is expecting these tags. -->
<Response>
        <Message><?php echo $output ?></Message>
</Response>