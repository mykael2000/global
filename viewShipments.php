<?php
include "includes/header.php";
$sqlship = "SELECT * FROM shipments";
$shipquery = mysqli_query($conn, $sqlship);

$message = "";

if (isset($_POST['submit'])) {

    $tracking_number = $_POST['tracking_number'];
    $products = $_POST['products'];
    $details = $_POST['details'];
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
    $weight = $_POST['weightt'];
    $length = $_POST['lengthh'];
    $mode_of_payment = $_POST['mode_of_payment'];
    $delivery_confirmation_message = $_POST['delivery_confirmation_message'];
    $upsql = "INSERT into shipments (tracking_id,products,details,delivery_confirmation_message,status,location,estimated_delivery,delivery_fee,sender_address,sender_name,sender_phone,receiver_address,receiver_name,receiver_phone,weightt,lengthh,mode_of_payment) VALUES ('$tracking_number','$products','$details','$delivery_confirmation_message','$status','$location','$estimated_delivery','$delivery_fee','$sender_address','$sender_name','$sender_phone','$receiver_address','$receiver_name','$receiver_phone','$weight','$length','$mode_of_payment')";
    $upquery = mysqli_query($con, $upsql);
    $message = '<div class="alert alert-success d-flex align-items-center" role="alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24">
                <use xlink:href="#check-circle-fill" />
            </svg>
            <div>Shipment Added Successfully</div>
        </div>';

}
?>
<!-- Right side column. Contains the navbar and content of the page -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Add/Edit/Delete Shipment

        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Home</a></li>
            <li class="active">shipment</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Total Shipment</h3>
                        <div class="box-tools">
                            <div class="input-group">
                                <input type="text" name="table_search" class="form-control input-sm pull-right"
                                    style="width: 150px;" placeholder="Search" />
                                <div class="input-group-btn">
                                    <button class="btn btn-sm btn-default"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                    </div><!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <tr>


                                <th>Tracking Number</th>
                                <th>Products</th>
                                <th>Details</th>
                                <th>Status</th>
                                <th>Edit</th>
                                <th>Delete</th>
                                <th>Add History</th>
                            </tr>
                            <?php while ($fetch = mysqli_fetch_assoc($shipquery)) {?>
                            <tr>


                                <td><?php echo $fetch['tracking_id']; ?></td>
                                <td><?php echo $fetch['products']; ?></td>
                                <td><?php echo $fetch['details']; ?></td>
                                <td><?php echo $fetch['status']; ?></td>

                                <td><a href="edit.php?id=<?php echo $fetch['id']; ?>"
                                        class="btn btn-block btn-success btn-xs">edit</a></td>
                                <td><a href="delshipment.php?id=<?php echo $fetch['id']; ?>"
                                        class="btn btn-block btn-danger btn-xs">Delete</a></td>
                                <td><a href="addhistory.php?id=<?php echo $fetch['id']; ?>&track_id=<?php echo $fetch['tracking_id']; ?>"
                                        class="btn btn-block btn-warning btn-xs">Add history</a></td>

                            </tr>
                            <?php }?>
                        </table>
                    </div><!-- /.box-body -->
                    <form action="" method="post" role="form">
                        <h2>Add New Shipment</h2>
                        <?php echo $message; ?>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="exampleInputbtc">Tracking Number</label>
                                <input type="text" name="tracking_number" class="form-control" id="exampleInputbtc"
                                    placeholder="Enter Tracking Number">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputbtc">Products</label>
                                <input type="text" name="products" class="form-control" id="exampleInputbtc"
                                    placeholder="Enter Products">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputbtc">Details</label>
                                <input type="text" name="details" class="form-control" id="exampleInputbtc"
                                    placeholder="Enter Details">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputbtc">Deliver Confirmation Message</label>
                                <input type="text" name="delivery_confirmation_message" class="form-control" id="exampleInputbtc"
                                    placeholder="Enter Message">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputbtc">Weight</label>
                                <input type="text" name="weightt" class="form-control" id="exampleInputbtc"
                                    placeholder="Enter Details" placeholder="Enter Weight">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputbtc">Length</label>
                                <input type="text" name="lengthh" class="form-control" id="exampleInputbtc"
                                    placeholder="Enter length" placeholder="Enter Length">
                            </div>
                            
                            <div class="form-group">
                                <label for="exampleInputbtc">Status</label>
                                <input type="text" name="status" class="form-control" id="exampleInputbtc"
                                    placeholder="Enter Status">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputbtc">Location</label>
                                <input type="text" name="location" class="form-control" id="exampleInputbtc"
                                    placeholder="Enter location">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputbtc">Estimated Delivery Date</label>
                                <input type="datetime-local" name="estimated_delivery" class="form-control"
                                    id="exampleInputbtc" placeholder="Enter date">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputbtc">Delivery Fee</label>
                                <input type="text" name="delivery_fee" class="form-control" id="exampleInputbtc"
                                    placeholder="Enter amount">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputbtc">Sender Address</label>
                                <input type="text" name="sender_address" class="form-control" id="exampleInputbtc"
                                    placeholder="Enter Address">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputbtc">Sender Name</label>
                                <input type="text" name="sender_name" class="form-control" id="exampleInputbtc"
                                    placeholder="Enter Name">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputbtc">Sender Phone</label>
                                <input type="text" name="sender_phone" class="form-control" id="exampleInputbtc"
                                    placeholder="Enter Phone">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputbtc">Receiver Address</label>
                                <input type="text" name="receiver_address" class="form-control" id="exampleInputbtc"
                                    placeholder="Enter Address">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputbtc">Receiver Name</label>
                                <input type="text" name="receiver_name" class="form-control" id="exampleInputbtc"
                                    placeholder="Enter Name">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputbtc">Receiver Phone</label>
                                <input type="text" name="receiver_phone" class="form-control" id="exampleInputbtc"
                                    placeholder="Enter Phone">
                            </div>
                        </div><!-- /.box-body -->

                        <div class="box-footer">
                            <button name="submit" type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div><!-- /.box -->
            </div>
        </div>
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<?php
include "includes/footer.php";

?>