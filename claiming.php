<?php
// Include authentication and database configuration
include('session.php');
include('config.php');

// Get current user ID from session
$user_id = $_SESSION['id'];

// Process claim submission if form was submitted
if(isset($_POST['submit_claim'])) {
    $claim_description = mysqli_real_escape_string($link, $_POST['claim_description']);
    $points_claimed = abs(mysqli_real_escape_string($link, $_POST['points_claimed'])) * -1; // Convert to negative
    
    // Check if user has enough points
    $check_points_sql = "SELECT points FROM users WHERE id = ?";
    $stmt_check = mysqli_prepare($link, $check_points_sql);
    mysqli_stmt_bind_param($stmt_check, "i", $user_id);
    mysqli_stmt_execute($stmt_check);
    $result_check = mysqli_stmt_get_result($stmt_check);
    $user_data = mysqli_fetch_assoc($result_check);
    
    if($user_data['points'] + $points_claimed < 0) {
        $claim_error = "Not enough points to claim this reward.";
    } else {
        // Insert into scan_history with negative points value
        $insert_sql = "INSERT INTO scan_history (user_id, points_added, description) 
                       VALUES (?, ?, ?)";
        $stmt_insert = mysqli_prepare($link, $insert_sql);
        mysqli_stmt_bind_param($stmt_insert, "ids", $user_id, $points_claimed, $claim_description);
        
        if(mysqli_stmt_execute($stmt_insert)) {
            // Update user's total points
            $update_sql = "UPDATE users SET points = points + ? WHERE id = ?";
            $stmt_update = mysqli_prepare($link, $update_sql);
            mysqli_stmt_bind_param($stmt_update, "di", $points_claimed, $user_id);
            mysqli_stmt_execute($stmt_update);
            
            $claim_success = "Reward claimed successfully!";
            
            // Redirect to refresh the page and prevent resubmission
            header("Location: claiming.php?claimed=success");
            exit();
        } else {
            $claim_error = "Error recording your claim. Please try again.";
        }
    }
}

// Fetch the user's points history with proper JOIN
$sql = "SELECT 
            sh.scan_time, 
            sh.points_added, 
            COALESCE(qc.booth_name, CASE WHEN sh.points_added < 0 THEN 'Reward Claim' ELSE 'Manual Addition' END) AS booth_name, 
            COALESCE(sh.description, 'No description provided') AS description 
        FROM 
            scan_history sh
        LEFT JOIN 
            qr_codes qc ON sh.qr_code_id = qc.id
        WHERE 
            sh.user_id = ?
        ORDER BY 
            sh.scan_time DESC";

// Use prepared statement for better security
$stmt = mysqli_prepare($link, $sql);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Calculate total points
$total_points = 0;
$history_records = [];

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $history_records[] = $row;
        $total_points += $row['points_added'];
    }
}

// Get current user points from database to ensure accuracy
$current_points_sql = "SELECT points FROM users WHERE id = ?";
$stmt_current = mysqli_prepare($link, $current_points_sql);
mysqli_stmt_bind_param($stmt_current, "i", $user_id);
mysqli_stmt_execute($stmt_current);
$result_current = mysqli_stmt_get_result($stmt_current);
$user_current = mysqli_fetch_assoc($result_current);
$current_points = $user_current['points'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Points History | PWU Event</title>
    <link rel="icon" type="image/png" href="img/pwu_logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        
        h1, h2, p, th {
            font-family: Montserrat;
            color: white;
        }

        :root {
            --pwu-maroon: #800000;
            --pwu-gold:rgb(255, 255, 255);
        }
        
        body {
            font-family: 'Montserrat', sans-serif;
            background-image: url('img/pwu_bg.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
            color: white;
            padding: 20px 0;
        }
        
        .page-container {
            max-width: 900px;
            margin: 0 auto;
            padding: 15px;
        }
        
        .card {
            background-color: rgba(0, 0, 0, 0.7);
            border-radius: 15px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
            overflow: hidden;
        }
        
        .card-header {
            background-color: rgba(128, 0, 0, 0.7);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            padding: 15px 20px;
        }
        
        .points-summary {
            background-color: rgba(255, 255, 255, 0.49);
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;
            text-align: center;
        }
        
        .points-value {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--pwu-gold);
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.5);
        }
        
        .table {
            color: white;
            border-color: rgba(255, 255, 255, 0.2);
        }
        
        .table thead th {
            background-color: rgb(167, 39, 39);
            border-color: rgba(255, 255, 255, 0.2);
            position: sticky;
            top: 0;
        }
        
        .table-responsive {
            max-height: 60vh;
            overflow-y: auto;
        }
        
        .back-btn {
            position: absolute;
            top: 20px;
            left: 20px;
            z-index: 100;
        }
        
        .empty-state {
            text-align: center;
            padding: 40px 20px;
        }
        
        .empty-state i {
            font-size: 3rem;
            margin-bottom: 15px;
            color: rgba(255, 255, 255, 0.5);
        }
        
        .claim-form {
            background-color: maroon;
            border-radius: 10px;
            padding: 15px;
            margin-top: 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .claim-form h5 {
            color: white;
            margin-bottom: 15px;
        }
        
        .points-negative {
            color: #ff6b6b !important;
        }
        
        @media (max-width: 768px) {
            .card-header h2 {
                font-size: 1.5rem;
            }
            
            .points-value {
                font-size: 2rem;
            }
            
            .table {
                font-size: 0.85rem;
            }
        }
    </style>
</head>
<body>
    <a href="student_dashboard.php" class="btn btn-light back-btn">
        <i class="bi bi-arrow-left"></i> Back
    </a>
    
    <div class="page-container">
        <div class="card">
            <div class="card-header">
                <h2 class="text-center m-0">Points History</h2>
            </div>
            <div class="card-body">
                <div class="points-summary">
                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="mb-0">Available Points</h5>
                            <div class="points-value"><?php echo $current_points; ?></div>
                        </div>
                    </div>
                </div>
                
                <!-- Claim Form -->
                <div class="claim-form">
                    <h5><i class="bi bi-gift"></i> Claim a Reward</h5>
                    
                    <?php if(isset($claim_error)): ?>
                        <div class="alert alert-danger"><?php echo $claim_error; ?></div>
                    <?php endif; ?>
                    
                    <?php if(isset($_GET['claimed']) && $_GET['claimed'] == 'success'): ?>
                        <div class="alert alert-success">Reward claimed successfully! <br> Make sure you claimed your prize on the booth counter!</div>
                    <?php endif; ?>
                    
                    <form method="post" action="">
                        <div class="mb-3">
                            <label for="claim_description" class="form-label" style="color:white;">Reward Description</label>
                            <input type="text" class="form-control" id="claim_description" name="claim_description" 
                                   placeholder="e.g., T-shirt, Food Voucher, etc." required>
                        </div>
                        <div class="mb-3">
                            <label for="points_claimed" class="form-label" style="color:white;">Points to Redeem</label>
                            <input type="number" class="form-control" id="points_claimed" name="points_claimed" 
                                   min="1" max="<?php echo $current_points; ?>" required>
                        </div>
                        <button type="submit" name="submit_claim" class="btn btn-warning">Claim Reward</button>
                    </form>
                </div>
                
                <?php if (count($history_records) > 0): ?>
                    <div class="table-responsive mt-4">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Date & Time</th>
                                    <th>Source</th>
                                    <th>Description</th>
                                    <th class="text-end">Points</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($history_records as $record): ?>
                                    <tr>
                                        <td><?php echo date('M d, Y g:i A', strtotime($record['scan_time'])); ?></td>
                                        <td><?php echo htmlspecialchars($record['booth_name']); ?></td>
                                        <td><?php echo htmlspecialchars($record['description']); ?></td>
                                        <td class="text-end <?php echo ($record['points_added'] < 0) ? 'points-negative' : ''; ?>">
                                            <?php echo ($record['points_added'] > 0 ? '+' : ''); ?><?php echo $record['points_added']; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="empty-state">
                        <i class="bi bi-clock-history"></i>
                        <h4>No History Yet</h4>
                        <p class="text-muted">Your points earning activity will appear here</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
