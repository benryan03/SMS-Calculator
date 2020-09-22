<?php

use Twilio\Twiml\MessagingResponse;

header("content-type: text/xml");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";

session_start();

// Import session variables if they exist
$firstNum = null;
$operation = null;
$secondNum = null;
if(isset($_SESSION['firstNum'])){
    $firstNum = $_SESSION['firstNum'];
}
if(isset($_SESSION['operation'])){
    $operation = $_SESSION['operation'];
}
if(isset($_SESSION['secondNum'])){
    $secondNum = $_SESSION['secondNum'];
}

// Parse input
$input = $_REQUEST['Body'];

// CLEAR
if (strtolower($input) == "clear" | strtolower($input) == "c"){
    session_unset();
    $firstNum = null;
    $operation = null;
    $secondNum = null;
    $output = "Cleared.";
}

// FIRST NUMBER
elseif ($firstNum == null){
    if (is_numeric($input)){
        $firstNum = $input;
        $output = "Enter the operation: ";
    }
    else {
        $output = "Error: Enter a number.";
    }
}

// OPERATION
elseif ($operation == null){
    if ($input == "+" | $input == "-" | $input == "*" | $input == "/"){
        $operation = $input;
        $output = "Enter the second number: ";
    }
    else {
        $output = "Error: Supported operations are +, -, *, or /";
    }
}

// SECOND NUMBER
elseif ($secondNum == null){
    if (is_numeric($input)){
        $secondNum = $input;

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
    else {
        $output = "Error: Enter a number.";
    }
}

// Save session variables
$_SESSION['firstNum'] = $firstNum;
$_SESSION['operation'] = $operation;
$_SESSION['secondNum'] = $secondNum;

?>

<!-- This is "TwiML" code. The Twilio API is expecting these tags. -->
<Response>
        <Message><?php echo $output ?></Message>
</Response>