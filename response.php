<?php

use Twilio\Twiml\MessagingResponse;

// start the session
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


$input = $_REQUEST['Body'];

// CLEAR
if ($input == "Clear"){
    session_unset();
    $firstNum = null; // DEBUG
    $secondNum = null; // DEBUG
    $operation = null; // DEBUG
    $output = "Cleared.";
}

// OPERATION OR NUMBER
else { // OPERATION
    if(!isset($_SESSION['operation'])) {
        $operation = $input;
        $output = $operation . ": Enter the first number.";
    }
    else { // NUMBER
        $operation = $_SESSION['operation'];
        if ($firstNum == null) { // FIRST NUMBER
            $firstNum = $_REQUEST['Body'];
            $output = "Enter the second number.";}

        elseif($firstNum != null & $secondNum == null) { // SECOND NUMBER
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

        
    }

    // Save session variables
    $_SESSION['operation'] = $operation;
    $_SESSION['firstNum'] = $firstNum;
    $_SESSION['secondNum'] = $secondNum;
}

header("content-type: text/xml");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";

?>
<Response>
        <Message><?php echo $output ?></Message>
</Response>