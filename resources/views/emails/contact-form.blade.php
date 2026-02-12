<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .content {
            background-color: #ffffff;
            padding: 20px;
            border: 1px solid #dee2e6;
            border-radius: 5px;
        }
        .field {
            margin-bottom: 15px;
        }
        .label {
            font-weight: bold;
            color: #495057;
        }
        .value {
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>New Contact Form Submission</h2>
        </div>
        
        <div class="content">
            <div class="field">
                <div class="label">Name:</div>
                <div class="value">{{ $contactData['name'] }}</div>
            </div>
            
            <div class="field">
                <div class="label">Email:</div>
                <div class="value">{{ $contactData['email'] }}</div>
            </div>
            
            @if(isset($contactData['phone']))
            <div class="field">
                <div class="label">Phone:</div>
                <div class="value">{{ $contactData['phone'] }}</div>
            </div>
            @endif
            
            <div class="field">
                <div class="label">Subject:</div>
                <div class="value">{{ $contactData['subject'] }}</div>
            </div>
            
            <div class="field">
                <div class="label">Message:</div>
                <div class="value">{{ $contactData['message'] }}</div>
            </div>
            
            <div class="field">
                <div class="label">Submitted:</div>
                <div class="value">{{ $contactData['submitted_at'] }}</div>
            </div>
        </div>
    </div>
</body>
</html>
