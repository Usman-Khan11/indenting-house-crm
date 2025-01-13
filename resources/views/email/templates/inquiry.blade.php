<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inquiry</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f7f9fc;
            margin: 0;
            padding: 0;
        }

        .email-wrapper {
            max-width: 700px;
            margin: 30px auto;
            background-color: #ffffff;
            border: 1px solid #e0e4e8;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .email-header {
            background-color: #2e84a4;
            color: #ffffff;
            padding: 20px;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
        }

        .email-body {
            padding: 30px;
            color: #333333;
            line-height: 1.6;
        }

        .email-body p {
            margin: 10px 0;
        }

        .highlight-box {
            background-color: #eaf2fb;
            border: 1px solid #c2d9f4;
            padding: 15px;
            border-radius: 8px;
            font-size: 16px;
            margin: 20px 0;
            color: #1c3d7a;
        }

        .email-footer {
            background-color: #f4f6f9;
            text-align: center;
            padding: 20px;
            font-size: 14px;
            color: #555555;
        }

        .email-footer a {
            color: #2e84a4;
            text-decoration: none;
        }

        .email-footer a:hover {
            text-decoration: underline;
        }

        .contact-details {
            margin-top: 10px;
            line-height: 1.5;
            color: #555555;
        }

        .contact-details strong {
            display: block;
            margin-top: 8px;
            color: #333333;
        }
    </style>
</head>

@php
    $inquiry = $data['inquiry'];
    $items = $data['inquiry_items'];
@endphp

<body>
    <div class="email-wrapper">
        <div class="email-header">
            Inquiry Details
        </div>
        <div class="email-body">
            <p><strong>Dear Sir/Madam,</strong></p>
            <p>{{ @$inquiry->supplier->name }}</p>
            <p>Hope you are absolutely fine.</p>
            <div class="highlight-box">
                Kindly quote your best possible C&F by Sea Karachi L/C at Sight prices for the following item:
                @foreach ($items as $item)
                    <div>
                        <strong>{{ $item->qty }} {{ $item->unit }} - {{ @$item->item->name }}</strong>
                    </div>
                @endforeach
            </div>
            <p>Looking forward to hearing from you soon.</p>
            <p><strong>Best Regards,</strong></p>
            <p>FOR MRI Indenting House</p>
        </div>
        <div class="email-footer">
            <div class="contact-details">
                <strong>Address:</strong>
                Plot No 391, Office No 303, 3rd Floor, Al Reef Tower, Near Alamgir Masjid,<br>
                Block 3, Bahadur Yar Jung Cooperative Housing Society, Bahadurabad Karachi.<br>
                <strong>Tel:</strong> +92-21-34920554<br>
                <strong>Fax:</strong> +92-21-34920555<br>
                <strong>Email:</strong> <a href="mailto:mri@mri.com.pk">mri@mri.com.pk</a>
            </div>
        </div>
    </div>
</body>

</html>
