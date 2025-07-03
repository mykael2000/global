<?php
include "includes/header.php";

$userid = $_GET['id'];
$sqleu = "SELECT * FROM shipments WHERE id='$userid'";
$queryeu = mysqli_query($conn, $sqleu);
$usereu = mysqli_fetch_assoc($queryeu);
$message = "";
if (isset($_POST['submit'])) {
    
    $tracking_number = $_POST['tracking_number'];
    $products = $_POST['products'];
    $details = $_POST['details'];
    $weight = $_POST['weight'];
    $length = $_POST['length'];
    $mode_of_payment = $_POST['mode_of_payment'];
    $status = $_POST['status'];
    $location = $_POST['location'];
    $estimated_delivery = $_POST['estimated_delivery'];
    $delivery_fee = $_POST['delivery_fee'];
    $sender_address = $_POST['sender_address'];
    $sender_name = $_POST['sender_name'];
    $sender_phone = $_POST['sender_phone'];
    $receiver_address = $_POST['receiver_address'];
    $receiver_name = $_POST['receiver_name'];
    $receiver_phone = $_POST['receiver_phone'];

    $sqlup = "UPDATE shipments set tracking_id='$tracking_number', products='$products', details='$details', status='$status', location='$location', estimated_delivery='$estimated_delivery', delivery_fee='$delivery_fee', sender_address='$sender_address', sender_name='$sender_name', sender_phone='$sender_phone', receiver_address='$receiver_address', receiver_name='$receiver_name', receiver_phone='$receiver_phone', weightt = '$weight', lengthh = '$length', mode_of_payment = '$mode_of_payment' WHERE id='$userid'";
    $queryup = mysqli_query($conn, $sqlup);
    header("location: edit.php?id=$userid&message=success");
}
if (@$_GET['message'] == "success") {
    $message = '<div class="alert alert-success d-flex align-items-center" role="alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24">
                <use xlink:href="#check-circle-fill" />
            </svg>
            <div>Details Updated Successfully</div>
        </div>';
}

?>
<!-- Right side column. Contains the navbar and content of the page -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Shipment Edit

        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Home</a></li>
            <li class="#">shipments</li>
            <li class="active">edit</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-6">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Edit Shipment</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form action="" method="post" role="form">
                        <h2>Edit Shipment</h2>
                        <?php echo $message; ?>
                        <div class="box-body">

                            <div class="form-group">
                                <label for="exampleInputbtc">Tracking Number</label>
                                <input type="text" name="tracking_number" class="form-control" id="exampleInputbtc"
                                    placeholder="Enter Tracking Number" value="<?php echo $usereu['tracking_id']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputbtc">Products</label>
                                <input type="text" name="products" class="form-control" id="exampleInputbtc"
                                    placeholder="Enter Products" value="<?php echo $usereu['products']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputbtc">Details</label>
                                <input type="text" name="details" class="form-control" id="exampleInputbtc"
                                    placeholder="Enter Details" value="<?php echo $usereu['details']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputbtc">Weight</label>
                                <input type="text" name="weight" class="form-control" id="exampleInputbtc"
                                    placeholder="Enter Weight" value="<?php echo $usereu['weightt']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputbtc">Length</label>
                                <input type="text" name="length" class="form-control" id="exampleInputbtc"
                                    placeholder="Enter length" value="<?php echo $usereu['lengthh']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputbtc">Mode of Payment</label>
                                <select type="text" name="mode_of_payment" class="form-control" id="exampleInputbtc">
                                    <option value="<?php echo $usereu['mode_of_payment']; ?>">
                                        <?php echo $usereu['mode_of_payment']; ?></option>
                                    <option value="Wire Transfer">Wire Transfer</option>
                                    <option value="Cash">Cash</option>
                                    <option value="Cash app">Cash app</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputbtc">Status</label>
                                <input type="text" name="status" class="form-control" id="exampleInputbtc"
                                    placeholder="Enter Status" value="<?php echo $usereu['status']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputbtc">Location</label>
                                <input type="text" name="location" class="form-control" id="exampleInputbtc"
                                    placeholder="Enter location" value="<?php echo $usereu['location']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputbtc">Estimated Delivery Date</label>
                                <input type="datetime-local" name="estimated_delivery" class="form-control"
                                    id="exampleInputbtc" placeholder="Enter date"
                                    value="<?php echo $usereu['estimated_delivery']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputbtc">Delivery Fee</label>
                                <input type="text" name="delivery_fee" class="form-control" id="exampleInputbtc"
                                    placeholder="Enter amount" value="<?php echo $usereu['delivery_fee']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputbtc">Sender Address</label>
                                <input type="text" name="sender_address" class="form-control" id="exampleInputbtc"
                                    placeholder="Enter Address" value="<?php echo $usereu['sender_address']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputbtc">Sender Name</label>
                                <input type="text" name="sender_name" class="form-control" id="exampleInputbtc"
                                    placeholder="Enter Name" value="<?php echo $usereu['sender_name']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputbtc">Sender Phone</label>
                                <input type="text" name="sender_phone" class="form-control" id="exampleInputbtc"
                                    placeholder="Enter Phone" value="<?php echo $usereu['sender_phone']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputbtc">Receiver Address</label>
                                <input type="text" name="receiver_address" class="form-control" id="exampleInputbtc"
                                    placeholder="Enter Address" value="<?php echo $usereu['receiver_address']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputbtc">Receiver Name</label>
                                <input type="text" name="receiver_name" class="form-control" id="exampleInputbtc"
                                    placeholder="Enter Name" value="<?php echo $usereu['receiver_name']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputbtc">Receiver Phone</label>
                                <input type="text" name="receiver_phone" class="form-control" id="exampleInputbtc"
                                    placeholder="Enter Phone" value="<?php echo $usereu['receiver_phone']; ?>">
                            </div>
                        </div><!-- /.box-body -->

                        <div class="box-footer">
                            <button name="submit" type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div><!-- /.box -->



            </div>
            <!--/.col (left) -->
        </div>
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<?php
include "includes/footer.php";

?>