@inject('settings', 'App\Settings\GeneralSettings')
<!DOCTYPE html>
<html>
<head>
    <title>Pesan Baru</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">

    <h2>Anda mendapat pesan Email Baru dari website Portfolio!</h2>

    <p><strong>Name:</strong> {{ $contact->name }}</p>
    <p><strong>Email:</strong> {{ $contact->email }}</p>
    
    <hr>
    
    <p><strong>Message:</strong></p>
    <p style="background: #f4f4f4; padding: 15px; border-left: 4px solid #00f0ff;">
        {{ $contact->message }}
    </p>

    <hr>
    
    <p style="font-size: 12px; color: #888;">
        Sent from {{ $settings->site_name }}.
    </p>

</body>
</html>