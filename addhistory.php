<?php
include "includes/header.php"; // Make sure this connects to your database as $conn

// IMPORTANT: Ensure $conn is the correct variable for your database connection
if (!isset($conn) || $conn->connect_error) {
    die("Database connection failed: " . ($conn->connect_error ?? "Unknown error"));
}

// Get the shipment_id from the URL (this is the ID from the `shipments` table)
$product_id = null; // Renamed from $product_id to avoid confusion, using this as the shipment's primary key ID
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $product_id = (int)$_GET['id'];
} else {
    // If no valid shipment ID is provided, redirect or show an error
    header("Location: viewShipments.php"); // Or wherever your main shipment list is
    exit();
}

// Fetch the main shipment details to display its tracking number
// Assuming your 'shipments' table has an 'id' and 'tracking_id'
$product_track_id = "N/A"; // This will hold the actual tracking number for display
$main_shipment_status = "N/A"; // To potentially update the main shipment's status
$stmt_shipment = $conn->prepare("SELECT tracking_id, status FROM shipments WHERE id = ?");
if ($stmt_shipment) {
    $stmt_shipment->bind_param("i", $product_id);
    $stmt_shipment->execute();
    $result_shipment = $stmt_shipment->get_result();
    if ($result_shipment->num_rows > 0) {
        $shipment_data = $result_shipment->fetch_assoc();
        $product_track_id = htmlspecialchars($shipment_data['tracking_id']);
        $main_shipment_status = htmlspecialchars($shipment_data['status']);
    } else {
        $message = '<div class="alert alert-danger d-flex align-items-center" role="alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24"><use xlink:href="#exclamation-triangle-fill" /></svg>
            <div>Shipment not found for ID: ' . $product_id . '. Cannot add history.</div>
        </div>';
        // Optionally, stop execution or redirect if the main shipment doesn't exist
        // exit();
    }
    $stmt_shipment->close();
} else {
    $message = '<div class="alert alert-danger d-flex align-items-center" role="alert">
        <svg class="bi flex-shrink-0 me-2" width="24" height="24"><use xlink:href="#exclamation-triangle-fill" /></svg>
        <div>Database error preparing shipment details query.</div>
    </div>';
}

$message = ""; // Initialize message for new history addition

if (isset($_POST['submit_history_entry'])) { // Changed submit button name
    $status = trim($_POST['status']);
    $description = trim($_POST['description']);
    $location = trim($_POST['location']);
    $date_time = trim($_POST['date_time']); // This will capture both date and time from datetime-local
    $is_delivered_status = isset($_POST['is_delivered_status']) ? 1 : 0; // Checkbox value is 1 if checked, 0 if not

    // Basic validation
    if (empty($status) || empty($location) || empty($date_time)) {
        $message = '<div class="alert alert-warning d-flex align-items-center" role="alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24"><use xlink:href="#exclamation-triangle-fill" /></svg>
            <div>Please fill in all required fields for the history entry (Status, Location, Date/Time).</div>
        </div>';
    } else {
        // Your INSERT query targeting shipment_history table
        // Ensure column names match your shipment_history table
        $upsql = "INSERT INTO shipment_history (shipment_id, status, description, location, date_time, is_delivered_status) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt_insert_history = $conn->prepare($upsql);

        if ($stmt_insert_history) {
            $stmt_insert_history->bind_param("issssi", $product_id, $status, $description, $location, $date_time, $is_delivered_status);

            if ($stmt_insert_history->execute()) {
                $message = '<div class="alert alert-success d-flex align-items-center" role="alert">
                    <svg class="bi flex-shrink-0 me-2" width="24" height="24"><use xlink:href="#check-circle-fill" /></svg>
                    <div>Shipment history Added Successfully!</div>
                </div>';

                // Optional: Update the main shipment's 'status' if this is the latest entry
                // and you want the main shipment's status to reflect the latest history update.
                // This is a common practice to keep the main shipment status current.
                $stmt_update_main_status = $conn->prepare("UPDATE shipments SET status = ? WHERE id = ?");
                if ($stmt_update_main_status) {
                    $stmt_update_main_status->bind_param("si", $status, $product_id);
                    $stmt_update_main_status->execute();
                    $stmt_update_main_status->close();
                }


            } else {
                $message = '<div class="alert alert-danger d-flex align-items-center" role="alert">
                    <svg class="bi flex-shrink-0 me-2" width="24" height="24"><use xlink:href="#exclamation-triangle-fill" /></svg>
                    <div>Error adding history: ' . htmlspecialchars($stmt_insert_history->error) . '</div>
                </div>';
            }
            $stmt_insert_history->close();
        } else {
            $message = '<div class="alert alert-danger d-flex align-items-center" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24"><use xlink:href="#exclamation-triangle-fill" /></svg>
                <div>Error preparing history insert statement: ' . htmlspecialchars($conn->error) . '</div>
            </div>';
        }
    }
}

// Fetch existing tracking history for the current shipment_id
$trackingHistoryRecords = []; // Renamed to avoid conflict with $trackingHistory in public page example
$sql_history_fetch = "SELECT * FROM shipment_history WHERE shipment_id = ? ORDER BY date_time DESC";
$stmt_history_fetch = $conn->prepare($sql_history_fetch);
if ($stmt_history_fetch) {
    $stmt_history_fetch->bind_param("i", $product_id);
    $stmt_history_fetch->execute();
    $result_history_fetch = $stmt_history_fetch->get_result();
    while ($row = $result_history_fetch->fetch_assoc()) {
        $trackingHistoryRecords[] = $row;
    }
    $stmt_history_fetch->close();
} else {
    $message .= '<div class="alert alert-danger d-flex align-items-center" role="alert">
        <svg class="bi flex-shrink-0 me-2" width="24" height="24"><use xlink:href="#exclamation-triangle-fill" /></svg>
        <div>Error fetching existing history records: ' . htmlspecialchars($conn->error) . '</div>
    </div>';
}

?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Manage Shipment History for Tracking ID: **<?php echo $product_track_id; ?>**
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="admin_shipments.php">Shipments</a></li> <li class="active">Shipment History</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Existing Tracking History</h3>
                    </div><div class="box-body table-responsive no-padding">
                        <?php if (!empty($trackingHistoryRecords)): ?>
                            <table class="table table-hover">
                                <tr>
                                    <th>Status</th>
                                    <th>Location</th>
                                    <th>Date & Time</th>
                                    <th>Description</th>
                                    <th>Delivered?</th>
                                    <th>Actions</th>
                                </tr>
                                <?php foreach ($trackingHistoryRecords as $history_item): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($history_item['status']); ?></td>
                                    <td><?php echo htmlspecialchars($history_item['location']); ?></td>
                                    <td><?php echo htmlspecialchars(date('M d, Y h:i A', strtotime($history_item['date_time']))); ?></td>
                                    <td><?php echo htmlspecialchars($history_item['description'] ?? 'N/A'); ?></td>
                                    <td><?php echo $history_item['is_delivered_status'] ? '<span class="label label-success">Yes</span>' : '<span class="label label-default">No</span>'; ?></td>
                                    <td>
                                        <a href="edit_history_entry.php?id=<?php echo $history_item['id']; ?>&shipment_id=<?php echo $product_id; ?>" class="btn btn-warning btn-xs">Edit</a>
                                        <a href="delete_history_entry.php?id=<?php echo $history_item['id']; ?>&shipment_id=<?php echo $product_id; ?>" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure you want to delete this history entry?');">Delete</a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </table>
                        <?php else: ?>
                            <div class="alert alert-info text-center">No tracking history found for this shipment yet.</div>
                        <?php endif; ?>
                    </div></div><div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Add New Tracking History Entry</h3>
                    </div>
                    <form action="" method="post" role="form">
                        <?php echo $message; // Display messages here ?>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="status">Status <span class="text-danger">*</span></label>
                                <input type="text" name="status" class="form-control" id="status" placeholder="e.g., In Transit, Delivered" required>
                            </div>
                            <div class="form-group">
                                <label for="location">Location <span class="text-danger">*</span></label>
                                <input type="text" name="location" class="form-control" id="location" placeholder="e.g., MEMPHIS TN DISTRIBUTION CENTER" required>
                            </div>
                            <div class="form-group">
                                <label for="date_time">Date & Time <span class="text-danger">*</span></label>
                                <input type="datetime-local" name="date_time" class="form-control" id="date_time" step="1" required>
                            </div>
                            <div class="form-group">
                                <label for="description">Description (Optional)</label>
                                <textarea name="description" class="form-control" id="description" rows="3" placeholder="e.g., Delivered, Front Door/Porch"></textarea>
                            </div>
                            <div class="form-group">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="is_delivered_status" value="1"> Mark as Delivered
                                    </label>
                                </div>
                            </div>
                        </div><div class="box-footer">
                            <button name="submit_history_entry" type="submit" class="btn btn-primary">Add History Entry</button>
                        </div>
                    </form>
                </div></div>
        </div>
    </section></div><?php
include "includes/footer.php";
?>