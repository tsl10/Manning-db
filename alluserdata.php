<?php
include 'inc/header.php';
Session::CheckSession();

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "login";

// Create a new database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch CVs and rank percentages
$sql = "SELECT cvs.id, cvs.email, cvs.filename, cvs.uploaded_at, cvs.rank_percentage 
        FROM cvs";

$result = $conn->query($sql);

if ($result === false) {
    die("Error: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uploaded CVs</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Uploaded CVs</h2>
        
        <?php if ($result->num_rows > 0): ?>
            <table id="cvTable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Email</th>
                        <th>Filename</th>
                        <th>Uploaded At</th>
                        <th>Rank</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['email']) ?></td>
                        <td><?= htmlspecialchars($row['filename']) ?></td>
                        <td><?= htmlspecialchars($row['uploaded_at']) ?></td>
                        <td>
                            <?php 
                            // Ensure rank percentage is not null and display it with two decimals
                            if (isset($row['rank_percentage']) && !empty($row['rank_percentage'])) {
                                echo number_format((float)$row['rank_percentage'], 2) . '%'; // Format with 2 decimals
                            } else {
                                echo 'N/A';
                            }
                            ?>
                        </td>
                        <td>
                            <a href="uploads/<?= htmlspecialchars($row['filename']) ?>" target="_blank" class="btn btn-primary btn-sm">View</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="alert alert-warning">No CVs found.</div>
        <?php endif; ?>

        <?php $conn->close(); ?>
    </div>

    <script>
        $(document).ready(function() {
            $('#cvTable').DataTable();
        });
    </script>
</body>
</html>
