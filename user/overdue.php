<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Overdue Fine Notice</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            height: 100%;
        }

        .message-box {
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 500px;
            text-align: center;
        }

        .message-text {
            font-size: 18px;
            color: #333333;
            margin-bottom: 20px;
        }

        .back-button {
            background-color: #007bff;
            color: #ffffff;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .back-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="message-box">
            <p class="message-text">You cannot pay overdue fines from here. Please go to the nearest police station.</p>
            <button class="back-button" onclick="goBack()">Go Back</button>
        </div>
    </div>
    <script>
        function goBack() {
            window.history.back();
        }

    </script>
</body>

</html>