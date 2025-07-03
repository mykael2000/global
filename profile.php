<?php
include "includes/header.php";

$sqleu = "SELECT * FROM users WHERE id='$userid'";
$queryeu = mysqli_query($conn, $sqleu);
$usereu = mysqli_fetch_assoc($queryeu);
$message = "";
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];

    $sqlup = "UPDATE users set name='$name', address='$address', phone='$phone' WHERE id='$userid'";
    $queryup = mysqli_query($conn, $sqlup);
    header("location: profile.php?id=$userid&message=success");
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
                        <h3 class="box-title">User Profile</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form action="" method="post" role="form">
                        <h2>Profile Details</h2>
                        <?php echo $message; ?>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="exampleInputbtc">Name</label>
                                <input type="text" name="name" class="form-control" id="exampleInputbtc"
                                    placeholder="Enter Name" value="<?php echo $usereu['name']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputbtc">Email</label>
                                <input type="text" name="email" class="form-control" id="exampleInputbtc"
                                    placeholder="Enter email" value="<?php echo $usereu['email']; ?>" disabled>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputbtc">Phone</label>
                                <input type="text" name="phone" class="form-control" id="exampleInputbtc"
                                    placeholder="Enter phone" value="<?php echo $usereu['phone']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputbtc">Address</label>
                                <input type="text" name="address" class="form-control" id="exampleInputbtc"
                                    placeholder="Enter address" value="<?php echo $usereu['address']; ?>">
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