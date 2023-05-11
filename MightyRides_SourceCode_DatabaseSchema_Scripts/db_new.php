<?php
// PHP Data Objects(PDO) Sample Code:
try {
    $conn = new PDO("sqlsrv:server = tcp:mightyrides.database.windows.net,1433; Database = MightyRides", "CloudSAbcccfe50", "22aasF23s1t4");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e) {
    print("Error connecting to SQL Server.");
    die(print_r($e));
}

// SQL Server Extension Sample Code:
$connectionInfo = array("UID" => "CloudSAbcccfe50", "pwd" => "22aasF23s1t4", "Database" => "MightyRides", "LoginTimeout" => 30, "Encrypt" => 1, "TrustServerCertificate" => 0);
$serverName = "tcp:mightyrides.database.windows.net,1433";
$conn = sqlsrv_connect($serverName, $connectionInfo);
?>