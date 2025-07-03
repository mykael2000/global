<?php
include "includes/header.php";
$sqlship = "SELECT * FROM shipments";
$shipquery = mysqli_query($conn, $sqlship);
?>
<!-- Right side column. Contains the navbar and content of the page -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Shipments List

        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Home</a></li>
            <li class="active">shipments</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Total Shipments</h3>
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
                                <th>Location</th>
                                <th>Delivery Date</th>
                                <th>Delivery Fee</th>

                                <th>Sender Details</th>
                                <th>Receivers Details</th>

                            </tr>
                            <?php while ($shipment = mysqli_fetch_assoc($shipquery)) {?>
                            <tr>

                                <td><?php echo $shipment['tracking_id']; ?></td>
                                <td><?php echo $shipment['products']; ?></td>
                                <td><?php echo $shipment['details']; ?></td>
                                <td><?php echo $shipment['status']; ?></td>
                                <td><?php echo $shipment['location']; ?></td>
                                <td><?php echo $shipment['estimated_delivery']; ?></td>
                                <td><?php echo $shipment['delivery_fee']; ?></td>

                                <td><?php echo $shipment['sender_address']; ?></td>
                                <td><?php echo $shipment['receiver_address']; ?></td>

                            </tr>
                            <?php }?>
                        </table>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
        </div>
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<?php
include "includes/footer.php";

?>