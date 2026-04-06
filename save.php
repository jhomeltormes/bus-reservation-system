<?
$conn = mysqli_connect("localhost", "root", "", "bus_system");

// INPUTS
$name = $_POST['name'];
$bus_id = $_POST['bus_id'];
$seat = $_POST['seat'];
$tickets = $_POST['tickets'];
$price = $_POST['price'];
$seat_type = $_POST['seat_type'];

// GET BUS DATA
$result = mysqli_query($conn, "SELECT * FROM buses WHERE id='$bus_id'");
$bus = mysqli_fetch_assoc($result);

$bus_name = $bus['bus_name'];
$route = $bus['source_city'] . " - " . $bus['destination_city'];
$time = $bus['time'];

// COMPUTE TOTAL
$total = $price * $tickets;

// DISCOUNT
if($seat_type == "senior") {
    $total = $total * 0.8; // 20% OFF
}
elseif($seat_type == "student") {
    $total = $total * 0.9; // 10% OFF
}

// INSERT INTO DATABASE
mysqli_query($conn, "INSERT INTO bookings 
(name, bus_name, route, time, seat_number, seat_type, tickets, price, total)
VALUES 
('$name', '$bus_name', '$route', '$time', '$seat', '$seat_type', '$tickets', '$price', '$total')");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Booking Successful</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;

            background: url('https://images.unsplash.com/photo-1506744038136-46273834b3fb') no-repeat center center fixed;
            background-size: cover;

            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.6);
            z-index: -1;
        }

        .card {
            background: rgba(255,255,255,0.95);
            padding: 30px;
            border-radius: 15px;
            width: 380px;
            text-align: center;
            box-shadow: 0 10px 25px rgba(0,0,0,0.3);
        }

        h2 {
            color: #4CAF50;
        }

        .details {
            text-align: left;
            margin-top: 15px;
        }

        .details p {
            margin: 6px 0;
            font-size: 15px;
        }

        .badge {
            display: inline-block;
            padding: 5px 10px;
            background: #4CAF50;
            color: white;
            border-radius: 8px;
            font-size: 12px;
        }

        .btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 15px;
            background: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 8px;
        }

        .btn:hover {
            background: #45a049;
        }
    </style>

</head>
<body>

<div class="card">

    <h2>✔ Booking Successful!</h2>

    <div class="details">
        <p><strong>Name:</strong> <?php echo $name; ?></p>
        <p><strong>Bus:</strong> <?php echo $bus_name; ?></p>
        <p><strong>Route:</strong> <?php echo $route; ?></p>
        <p><strong>Time:</strong> <?php echo $time; ?></p>
        <p><strong>Seat:</strong> <?php echo $seat; ?></p>
        <p><strong>Seat Type:</strong> 
            <span class="badge"><?php echo ucfirst($seat_type); ?></span>
        </p>
        <p><strong>Tickets:</strong> <?php echo $tickets; ?></p>
        <p><strong>Price:</strong> ₱<?php echo $price; ?></p>
        <p><strong>Total:</strong> ₱<?php echo number_format($total, 2); ?></p>
    </div>

    <a href="index.php" class="btn">Back to Home</a>

</div>

</body>
</html>