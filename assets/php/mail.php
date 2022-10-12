<?php

    // Only process POST reqeusts.
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get the form fields and remove whitespace.
        $name = strip_tags(trim($_POST["name"]));
		$name = str_replace(array("\r","\n"),array(" "," "),$name);
        $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
        $message = trim($_POST["message"]);

        // Check that data was sent to the mailer.
        if ( empty($name) OR empty($email) OR empty($message) OR !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // Set a 400 (bad request) response code and exit.
            http_response_code(400);
            echo "Please complete the form and try again.";
            exit;
        }

        // Set the recipient email address.
        // FIXME: Update this to your desired email address.
        $recipient = "m.grifantini@am-linkweb.it";

        // Set the email subject.
       $subject = "Nuovo Contatto da $name";

        // Build the email content.
        $email_content = "Nome: $name\n";
        $email_content = "Email: $email\n";
        $email_content = "Messaggio:$message\n";

        // Build the email headers.
        $email_headers = "From: $name <$email> Messaggio:$message\n";

        // Send the email.
        if (mail($recipient, $email_content, $email_headers)) {
            // Set a 200 (okay) response code.
            http_response_code(200);
			header("Location:../../contatti-mail-inviata.html");//echo "Message Sent!";
            //echo "Grazie! Il tuo Messaggio è stato inviato";
		
        } else {
            // Set a 500 (internal server error) response code.
            http_response_code(500);
            echo "Ops! Qualcosa è andato storto e non siamo riusciti a inviare il tuo messaggio.";
        }

    } else {
        // Not a POST request, set a 403 (forbidden) response code.
        http_response_code(403);
        echo "Si è verificato un problema con il tuo invio, riprova.";
    }

?>