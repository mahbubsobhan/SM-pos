<!DOCTYPE html>
<html lang="en">
<head>
  <style>
    /* সাধারণ স্টাইল */
    body {
      font-family: Helvetica, Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f4f4f4;
    }

    .email-container {
      max-width: 700px;
      margin: 50px auto;
      background: #ffffff;
      border-radius: 8px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      overflow: hidden;
      animation: fadeIn 1.5s ease;
    }

    .email-header {
      background: linear-gradient(45deg, #00466a, #007bb5);
      color: #ffffff;
      padding: 20px;
      text-align: center;
    }

    .email-header a {
      color: #ffffff;
      text-decoration: none;
      font-size: 1.5em;
      font-weight: 700;
    }

    .email-body {
      padding: 30px;
    }

    .email-body h2 {
      background: #00466a;
      color: #ffffff;
      border-radius: 4px;
      padding: 10px;
      display: inline-block;
      animation: pulse 1s infinite;
    }

    .email-footer {
      padding: 20px;
      text-align: right;
      font-size: 0.8em;
      color: #aaa;
      background: #f9f9f9;
    }

    /* এনিমেশন */
    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @keyframes pulse {
      0%, 100% {
        transform: scale(1);
      }
      50% {
        transform: scale(1.1);
      }
    }
  </style>
</head>
<body>
  <div class="email-container">
    <div class="email-header">
      <a href="#">Your Brand</a>
    </div>
    <div class="email-body">
      <p style="font-size:1.1em">Hi,</p>
      <p>
        Thank you for choosing Your Brand. Use the following OTP to complete your 
        Sign Up procedures. OTP is valid for 5 minutes.
      </p>
      <h2>{{ $otp }}</h2>
      <p style="font-size:0.9em;">Regards,<br />Your Brand</p>
    </div>
    <div class="email-footer">
      <p>Your Brand Inc</p>
      <p>1600 Amphitheatre Parkway</p>
      <p>California</p>
    </div>
  </div>
</body>
</html>
