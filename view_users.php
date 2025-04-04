<?php
include('session.php');
include('config.php');

// Check if user is logged in and is an admin
if (!isset($_SESSION['id']) || $_SESSION['role'] != 'admin') {
    header("Location: student_dashboard.php?message=Unauthorized access");
    exit();
}

// Fetch all users from the database
$sql = "SELECT id, username, role, points, reg_date, name, email FROM users ORDER BY id ASC";
$result = mysqli_query($link, $sql);

// Format datetime for display
function formatDateTime($timestamp) {
    return date('M d, Y h:i A', strtotime($timestamp));
}

// Handle user deletion if requested
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $delete_id = mysqli_real_escape_string($link, $_GET['delete']);
    
    // Don't allow deleting self
    if ($delete_id != $_SESSION['id']) {
        // First delete any scan history entries
        $delete_history = "DELETE FROM scan_history WHERE user_id = '$delete_id'";
        mysqli_query($link, $delete_history);
        
        // Then delete the user
        $delete_user = "DELETE FROM users WHERE id = '$delete_id'";
        if (mysqli_query($link, $delete_user)) {
            header("Location: view_users.php?message=User deleted successfully");
            exit();
        } else {
            header("Location: view_users.php?error=Failed to delete user");
            exit();
        }
    } else {
        header("Location: view_users.php?error=You cannot delete your own account");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="img/pwu_logo.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users Overview</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        body {
            background-image: url(img/pwu_bg.jpg);
            background-size: cover;
            background-position: center;
            min-height: 100vh;
            padding: 20px 0;
            font-family: Montserrat, sans-serif;
        }

        .container {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            padding: 20px;
            margin-top: 20px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
        }

        h1, h2 {
            color: #dc3545;
            text-align: center;
            margin-bottom: 20px;
        }

        .table {
            background-color: white;
        }

        .back-btn {
            margin-top: 20px;
        }

        .admin-row {
            background-color: #ffeeee;
        }
        
        .badge {
            font-size: 0.9em;
        }
        
        .action-buttons a {
            margin-right: 5px;
        }
        
        .search-container {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="text-center mb-4">
            <img class="animate__animated animate__fadeInDown" src="img/pwu_logo.png" width="75px" alt="PWU Logo">
            <h1 class="animate__animated animate__fadeIn">Users Overview</h1>
        </div>
        
        <?php if (isset($_GET['message'])): ?>
            <div class="alert alert-success">
                <?php echo htmlspecialchars($_GET['message']); ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger">
                <?php echo htmlspecialchars($_GET['error']); ?>
            </div>
        <?php endif; ?>
        
        <div class="search-container">
            <input type="text" id="searchInput" class="form-control" placeholder="Search by username, name, or email...">
        </div>

        <?php if (mysqli_num_rows($result) > 0): ?>
            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="usersTable">
                    <thead class="table-danger">
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Points</th>
                            <th>Registered Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = mysqli_fetch_assoc($result)): 
                            $isAdmin = $row['role'] == 'admin';
                            $rowClass = $isAdmin ? 'admin-row' : '';
                            $isSelf = $row['id'] == $_SESSION['id'];
                        ?>
                            <tr class="<?php echo $rowClass; ?>">
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo htmlspecialchars($row['username']); ?></td>
                                <td><?php echo htmlspecialchars($row['name'] ? $row['name'] : 'Not set'); ?></td>
                                <td><?php echo htmlspecialchars($row['email'] ? $row['email'] : 'Not set'); ?></td>
                                <td>
                                    <?php if($row['role'] == 'admin'): ?>
                                        <span class="badge bg-danger">Admin</span>
                                    <?php elseif($row['role'] == 'faculty'): ?>
                                        <span class="badge bg-info">Faculty</span>
                                    <?php else: ?>
                                        <span class="badge bg-primary">Student</span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo $row['points']; ?></td>
                                <td><?php echo formatDateTime($row['reg_date']); ?></td>
                                <td class="action-buttons">
                                   <!-- <a href="edit_user_points.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-primary btn-disabled">
                                        Update Points
                                    </a> !-->
                                    <?php if(!$isSelf): ?>
                                    <a href="view_users.php?delete=<?php echo $row['id']; ?>" 
                                       class="btn btn-sm btn-danger"
                                       onclick="return confirm('Are you sure you want to delete this user? This action cannot be undone.')">
                                        Delete
                                    </a>
                                    <?php else: ?>
                                    <span class="badge bg-secondary">Current User</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-info">No users found in the database.</div>
        <?php endif; ?>

        <div class="text-center back-btn">
            <a href="student_dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
        </div>
    </div>

    <script>
        // Simple search functionality
        document.getElementById('searchInput').addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();
            const table = document.getElementById('usersTable');
            const rows = table.getElementsByTagName('tr');
            
            // Start from index 1 to skip the header row
            for (let i = 1; i < rows.length; i++) {
                const row = rows[i];
                const username = row.cells[1].textContent.toLowerCase();
                const name = row.cells[2].textContent.toLowerCase();
                const email = row.cells[3].textContent.toLowerCase();
                
                if (username.includes(searchTerm) || name.includes(searchTerm) || email.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>
</html>