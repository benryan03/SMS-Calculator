<?php

use Twilio\Twiml\MessagingResponse;
session_start();

// Check session variables
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
}

// FIRST NUMBER
elseif ($firstNum == null) {
    $operation = $_SESSION['operation'];
    $firstNum = $_REQUEST['Body'];
    $output = "Enter the second number.";
}

// SECOND NUMBER
elseif($firstNum != null & $secondNum == null) {
    $operation = $_SESSION['operation'];
    $secondNum = $_REQUEST['Body'];

    // CALCULATE RESULT
    if ($operation == "+"){
        $result = $firstNum + $secondNum;
    }
    elseif ($operation == "-"){
        $result = $firstNum - $secondNum;
    }
    elseif ($operation == "*"){
        $result = $firstNum * $secondNum;
    }
    elseif ($operation == "/"){
        $result = $firstNum / $secondNum;
    }
    $output = $firstNum . " " . $operation . " " . $secondNum . " = " . $result;
    session_unset();
}

// Save session variables
$_SESSION['operation'] = $operation;
$_SESSION['firstNum'] = $firstNum;
$_SESSION['secondNum'] = $secondNum;

header("content-type: text/xml");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";

?>

<!-- This is "TwiML" code. The Twilio API is expecting these tags. -->
<Response>
        <Message><?php echo $output ?></Message>
</Response>