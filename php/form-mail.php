<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Define your email address where you want to receive the form submissions.
    $to_email = "your_email@example.com";

    // Get form data
    $name = $_POST["name"];
    $email = $_POST["email"];
    $message = $_POST["message"];

    // Validate input (you can add more validation)
    if (empty($name) || empty($email) || empty($message)) {
        echo "All fields are required.";
    } else {
        // Subject and email headers
        $subject = "New Contact Form Submission from $name";
        $headers = "From: $email";

        // Send the email
        if (mail($to_email, $subject, $message, $headers)) {
            echo "Thank you! Your message has been sent.";
        } else {
            echo "Oops! Something went wrong and we couldn't send your message.";
        }
    }
}
    // If the form was not submitted, you can handle this as needed (e.g., display the form).
    // Here, we'll simply display an HTML form.
?>