<?php
    include('SpaceMarketingService.php');

    $dateFrom = null;
    $dateTo = null;

    $spaceMarketing = new SpaceMarketingService();
    $daterange = null;
    if (isset($_GET['daterange'])) {
        $daterange = $_GET['daterange'];
        $period = explode('-', $daterange);
        if (count($period) == 2) {
            $dateFrom = (new DateTime($period[0]))->format('Y-m-d') . ' 00:00:00';
            $dateTo = (new DateTime($period[1]))->format('Y-m-d') . ' 23:59:59';
        }
    }
    $userStatuses = $spaceMarketing->getUsersStatuses(
        dateFrom: $dateFrom,
        dateTo: $dateTo,
    );
    $userStatuses = json_decode($userStatuses);

    $successMessage = null;

    session_start();
    if (isset($_SESSION["success_message"])) {
        $successMessage = $_SESSION["success_message"];
        unset($_SESSION["success_message"]);
    }
?>

<html>
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
</head>
<body>
    <div class="container">
	    <?php
	    if ($successMessage) {
		    ?>
            <div style="background-color: lightgreen; color: white;">
                <p><?php echo $successMessage; ?></p>
            </div>
		    <?php
	    }
	    ?>
        <br>
        <form action="index.php" id="dateRangeForm" method="get">
            <input type="text" name="daterange"/>
        </form>
        <br>
        <a href="add_lead.php" class="btn btn-default">Add new</a>
        <br>
        <div class="table-div">
            <table border="1"  class="table">
                <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Email</th>
                    <th scope="col">Status</th>
                    <th scope="col">FTD</th>
                </tr>
                </thead>
                <tbody>
		        <?php
		        foreach ($userStatuses->data as $userStatus) {
			        ?>
                    <tr>
                        <td><?php echo $userStatus->id;?></td>
                        <td><?php echo $userStatus->email;?></td>
                        <td><?php echo $userStatus->status;?></td>
                        <td><?php echo $userStatus->ftd;?></td>
                    </tr>
			        <?php
		        }
		        ?>
                </tbody>
            </table>
        </div>
        <script src="/js/script.js"></script>
    </div>
</body>

