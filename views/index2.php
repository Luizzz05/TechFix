<?php include_once 'menu.html'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .calendar {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ddd;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            border-radius: 8px;
        }
        .calendar-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .calendar-header h2 {
            margin: 0;
        }
        .days-of-week {
            display: flex;
            justify-content: space-between;
            background-color: #f4f4f4;
            padding: 10px 0;
        }
        .days-of-week div {
            width: 14.28%;
            text-align: center;
            font-weight: bold;
        }
        .dates {
            display: flex;
            flex-wrap: wrap;
        }
        .dates div {
            width: 14.28%;
            height: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
            border: 1px solid #ddd;
            box-sizing: border-box;
        }
        .dates div.today {
            background-color: #4CAF50;
            color: white;
        }
    </style>
</head>
<body>
    <div class="calendar">
        <div class="calendar-header">
            <h2>June 2024</h2>
        </div>
        <div class="days-of-week">
            <div>Sun</div>
            <div>Mon</div>
            <div>Tue</div>
            <div>Wed</div>
            <div>Thu</div>
            <div>Fri</div>
            <div>Sat</div>
        </div>
        <div class="dates">
            <!-- Days from the previous month -->
            <div></div><div></div><div></div><div></div>
            <!-- Days of the current month -->
            <?php
            $daysInMonth = 30;
            $startDay = 4; // Thursday, for example
            for ($i = 1; $i <= $daysInMonth; $i++) {
                $class = ($i == date('j')) ? 'today' : '';
                echo "<div class='$class'>$i</div>";
            }
            ?>
        </div>
    </div>
</body>
</html>
