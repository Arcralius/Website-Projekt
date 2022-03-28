<!DOCTYPE HTML>

<head>
    <title>Users</title>
    <?php
    include 'header.php';
    ?>
</head>

<body>
    <?php
    include 'navbar.php';
    include 'adminsession.php';
    ?>

    <?php

    require("conn.php");


    $sql = "SELECT * FROM users";
    $result = $conn->query($sql);

    ?>

    <div class="container">
        <h2>Users</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                ?>

                        <tr>
                            <td><?php echo $row['user_id']; ?></td>
                            <td><?php echo $row['fname']; ?></td>
                            <td><?php echo $row['lname']; ?></td>
                            <td><?php echo $row['username']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['role']; ?></td>
                            <td>
                                <form action="adminusers_update.php" method="post">
                                    <input type="hidden" id="user_id" name="user_id" value="<?php echo $row['user_id']; ?>">
                                    <button type="submit" class="btn btn-info btn-md" style=" width: 100px;  display: inline-block; vertical-align: top;">Edit</button>
                                </form>
                            </td>
                        </tr>
                <?php       }
                }
                ?>
            </tbody>
        </table>
        <div>
            <p id="succmessage">
            </p>
            <p id="errormsg">
            </p>
        </div>

        <script>
            var succmessage = getCookie("succmessage");
            if (succmessage == null) {
                succmessage = " ";
            }
            document.getElementById('succmessage').innerHTML += succmessage;

            var errormsg = getCookie("errorMsg");
            if (errormsg == null) {
                errormsg = " ";
            }
            document.getElementById('errormsg').innerHTML += errormsg;
        </script>

</body>