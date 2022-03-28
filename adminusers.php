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

                            <td><a class="btn btn-info" href="adminusers_update.php?user_id=<?php echo $row['user_id']; ?>">Edit</a>&nbsp;</td>
                        </tr>
                <?php       }
                }
                ?>
            </tbody>
        </table>
        <div>
            <p id="succmessage">
            </p>
        </div>
    </div>



    <script>
        var succmessage = getCookie("succmessage");
        if (succmessage == null) {
            succmessage = " ";
        }
        document.getElementById('succmessage').innerHTML += succmessage;
    </script>

</body>