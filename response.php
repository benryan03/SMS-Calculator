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
                $output = $firstNum . $operation . $secondNum;
                session_unset();
            }

            
        }

        // Save session variables
        $_SESSION['operation'] = $operation;
        $_SESSION['firstNum'] = $firstNum;
        $_SESSION['secondNum'] = $secondNum;
    }

    
    $output = $operation . "-" . $firstNum . "-" . $secondNum . "---" . $output; // DEBUG







    header("content-type: text/xml");
    echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";

?>
<Response>
        <Message><?php echo $output ?></Message>
</Response>