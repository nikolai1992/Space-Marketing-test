<?php
    include('SpaceMarketingService.php');

    if(isset($_POST['submit']))
    {
        $spaceMarketing = new SpaceMarketingService();

        $userStatuses = json_decode($spaceMarketing->addLead($_POST));

        if ($userStatuses->status == 'true') {
            session_start();
            $_SESSION["success_message"] = 'Lead has been added successfully.';

            header('Location: index.php');
        }

        $error = $userStatuses->error;
    }
?>
<html>
    <head>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    </head>
    <body>
        <div class="container">
            <h3>Add new lead</h3>
	        <?php
	        if (isset($error)) {
		        ?>
                <div style="background-color: red; color: white;">
                    <p><?php echo $error; ?></p>
                </div>
		        <?php
	        }
	        ?>
            <form action="add_lead.php" method="POST">
                <div class="row">
                    <div class="col-md-6">
                        <label>First name</label>
                        <input type="text" name="firstName" class="form-control" value="<?php echo $_POST['firstName'] ?? null;?>">
                    </div>
                    <div class="col-md-6">
                        <label>Last name</label>
                        <input type="text" name="lastName" class="form-control" value="<?php echo $_POST['lastName'] ?? null;?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label>Phone</label>
                        <input type="text" name="phone" class="form-control" value="<?php echo $_POST['phone'] ?? null;?>">
                    </div>
                    <div class="col-md-6">
                        <label>Email</label>
                        <input type="text" name="email" class="form-control" value="<?php echo $_POST['email'] ?? null;?>">
                    </div>
                </div><br>
                <div>
                    <input type="submit" name="submit" value="Add lead" class="btn btn-primary">
                    <a href="index.php" class="btn btn-default">Cancel</a>
                </div>
            </form>
        </div>
    </body>
</html>
