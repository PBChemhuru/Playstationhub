<!-- resources/views/emails/contact.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $data['subject'] }}</title>
</head>
<body>
    <h1>Contact Us Message</h1>
    <p><strong>Subject:</strong> {{ $data['subject'] }}</p>
    <p><strong>Message:</strong></p>
    <p>{{$data['messages'] }}</p>  <!-- Display the message content -->
    <p><strong>Email:</strong> {{ $data['email'] }}</p>  <!-- Display the email address -->
    <p><strong>Phone Number:</strong> {{ $data['phonenumber'] }}</p>  <!-- Display the phone number -->
</body>
</html>
