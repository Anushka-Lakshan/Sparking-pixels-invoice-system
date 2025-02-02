<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Anushka Lakshan">

    <title>Sparkling Pixels </title>

    <!-- Custom fonts for this template-->
    <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link rel="stylesheet" href="assets/css/CKstyles.css">
    <link href="assets/css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/sweetAlert.css">
    <link href="assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="assets/favicon.ico" type="image/x-icon">
    <link rel="icon" href="assets/favicon.ico" type="image/x-icon">

    <script src="assets/js/CKeditor/CKeditor.js"></script>


    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <!-- <script>window.$ = window.jQuery = require('http://localhost:8000/assets/vendor/jquery/jquery.min.js');</script> -->
    <script src="http://localhost:8000/assets/vendor/jquery/jquery.min.js" onload="window.$ = window.jQuery = module.exports;"></script>
    <script src="assets/js/sweetAlert.js"></script>
    <script>
  window.addEventListener("beforeunload", function () {
    fetch("http://localhost:4000/quit"); // Notify Electron to quit
  });
  window.addEventListener("unload", function () {
    fetch("http://localhost:4000/quit"); // Notify Electron to quit
  })
</script>

    <style>
        .bg-image {
            background-image: url(assets/images/bg.jpg);
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center center;
            /* background-attachment: fixed; */
        }
    </style>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-image sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/<?= BASE_URL ?>">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fa fa-star"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Sparkling Pixels <sup><i class="fa fa-star"></i></sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="/<?= BASE_URL ?>">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>



            <!-- Heading -->
            <div class="sidebar-heading">
                Options
            </div>

            <!-- Nav Item - Pages Collapse Menu -->


            <!-- Nav Item - Charts -->
            <li class="nav-item">
                <a class="nav-link" href="<?= BASE_URL ?>?page=Clients">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Clients</span></a>
            </li>

            <!-- Nav Item - Tables -->
            <li class="nav-item">
                <a class="nav-link" href="<?= BASE_URL ?>?page=Packages">
                    <i class="fas fa-fw fa-camera-retro"></i>
                    <span>Packages</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?= BASE_URL ?>?page=Invoices">
                    <i class="fas fa-fw fa-paper-plane"></i>
                    <span>Invoices</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?= BASE_URL ?>?page=Payments">
                    <i class="fas fa-fw fa-dollar-sign"></i>
                    <span>Payments</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <!-- <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div> -->

            <!-- Sidebar Message -->


        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->


                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <?php

                        if (isset($_SESSION['temp_msg'])) {
                            echo '
                                <script>
                                    Swal.fire({
                                        title: "' . $_SESSION['temp_msg'] . '",
                                        text: "' . (isset($_SESSION['temp_msg_secondery']) ? $_SESSION['temp_msg_secondery'] : '') . '",
                                        icon: "' . (isset($_SESSION['temp_msg_type']) ? $_SESSION['temp_msg_type'] : 'success') . '",
                                        showCancelButton: false,
                                        confirmButtonText: "Continue"
                                    });
                                </script>
                                ';
                            unset($_SESSION['temp_msg']);
                            unset($_SESSION['temp_msg_secondery']);
                            unset($_SESSION['temp_msg_type']);
                        }

                        ?>






                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Sparkling Pixels</span>

                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">

                                <a class="dropdown-item" href="<?= BASE_URL ?>?page=Settings">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Settings
                                </a>
                                <a class="dropdown-item" href="<?= BASE_URL ?>?page=backupRestore">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Backup and Restore
                                </a>

                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->

                <div class="container-fluid">
                    <?php include("app/views/pages/" . $subpage . ".view.php"); ?>
                </div>

                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Developed by : Anushka Lakshan</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>



    <!-- Bootstrap core JavaScript-->

    <script src="assets/js/moment.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="assets/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="assets/js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="assets/vendor/chart.js/Chart.min.js"></script>

    <!-- Page level plugins -->
    <script src="assets/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>


    <script>
        $(document).ready(function() {
            $('#DataTable').DataTable({
                "columnDefs": [{
                        "orderable": true,
                        "targets": 0
                    } // ID column (index 0) is sortable
                ],
                "order": [
                    [0, 'desc']
                ] // Sort the first column (index 0) in descending order by default
            });
        });

        $(document).ready(function() {
            $("input[type='date']").each(function() {
                $(this).on("change", function() {
                    $(this).attr(
                        "data-date",
                        moment($(this).val(), "YYYY-MM-DD").format($(this).attr("data-date-format"))
                    );
                }).trigger("change");
            });
        });
    </script>

    <style>
        input[type="date"] {
            position: relative;
            box-sizing: border-box;
            padding: 10px;
            line-height: 30px;
            color: white;
        }

        input[type="date"]:before {
            position: absolute;
            top: 3px;
            left: 10px;
            content: attr(data-date);
            display: inline-block;
            color: black;
        }

        input[type="date"]::-webkit-datetime-edit,
        input[type="date"]::-webkit-inner-spin-button,
        input[type="date"]::-webkit-clear-button {
            display: none;
        }

        input[type="date"]::-webkit-calendar-picker-indicator {
            position: absolute;
            top: 7px;
            right: 10px;
            /* background: blue; */
            scale: 1.1;
            padding: 3px;
            color: black;
            opacity: 1;
        }
    </style>

</body>

</html>