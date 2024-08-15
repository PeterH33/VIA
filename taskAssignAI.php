<?php
//NOTE: I think that there should be more work put into cleaning this query from potential bad information or malicious code, but I am unsure at the moment, pattern has been used elsewhere when pulling from the db... would have to look into it more

require 'dbDash.php';

$SQLString = "
    SELECT t.taskName, t.costEstimate, u.userName
    FROM tasks t
    LEFT JOIN assignments a ON t.taskId = a.taskId
    LEFT JOIN users u ON a.userId = u.userId
    WHERE u.userName IS NOT NULL
";

$result = $mysqli->query($SQLString);

if ($result->num_rows > 0){
    $taskData = array();

    while ($row = $result->fetch_assoc()){
        $taskData[] = array(
            'taskName' => $row['taskName'],
            'costEstimate' => $row['costEstimate'],
            'userName' => $row['userName']
        );
    }

    $jsonData = json_encode($taskData);

    echo $jsonData;
}

$mysqli->close();

?>