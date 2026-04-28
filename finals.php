<?php
$processes = [
    ["pid" => "P1", "at" => 0, "bt" => 5], // Process 1
    ["pid" => "P2", "at" => 2, "bt" => 3], // Process 2
    ["pid" => "P3", "at" => 4, "bt" => 1], // Process 3
];
usort($processes, function($a, $b) {
    return $a['at'] <=> $b['at'];
});
$currentTime = 0; // current time ng CPU
$totalWT = 0;     // total Waiting Time
$totalTAT = 0;    // total Turnaround Time

echo "<h2>FCFS Scheduling</h2>";

echo "<table border='1' cellpadding='8'>
<tr>
<th>PID</th><th>AT</th><th>BT</th>
<th>CT</th><th>TAT</th><th>WT</th>
</tr>";
$gantt = [];   // list ng process order
$timeline = []; // list ng time

foreach ($processes as &$p) {

    // Kung idle ang CPU (walang process pa)
    if ($currentTime < $p['at']) {
        $currentTime = $p['at']; // lilipat sa arrival time
    }

    $startTime = $currentTime; // oras kung kailan magsisimula ang process

    $p['ct'] = $currentTime + $p['bt']; // Completion Time
    $p['tat'] = $p['ct'] - $p['at'];    // Turnaround Time
    $p['wt'] = $p['tat'] - $p['bt'];    // Waiting Time

    // I-update ang current time pagkatapos ng process
    $currentTime = $p['ct'];

    // I-add sa total para sa average
    $totalWT += $p['wt'];
    $totalTAT += $p['tat'];

    // SAVE DATA FOR GANTT CHART
    
    $gantt[] = $p['pid'];     // order ng process
    $timeline[] = $startTime; // start time


    echo "<tr>
        <td>{$p['pid']}</td>
        <td>{$p['at']}</td>
        <td>{$p['bt']}</td>
        <td>{$p['ct']}</td>
        <td>{$p['tat']}</td>
        <td>{$p['wt']}</td>
    </tr>";
}

$timeline[] = $currentTime;

echo "</table>";

$n = count($processes); // bilang ng processes

echo "<h3>Average WT: " . round($totalWT / $n, 2) . "</h3>";
echo "<h3>Average TAT: " . round($totalTAT / $n, 2) . "</h3>";

echo "<h3>Gantt Chart:</h3>";

// display ng process boxes
echo "<div style='display:flex;'>";
foreach ($gantt as $p) {
    echo "<div style='padding:30px; border:1px solid black;'>$p</div>";
}
echo "</div>";

// display ng timeline 
echo "<div style='display:flex;'>";
foreach ($timeline as $t) {
    echo "<div style='width:77px;'>$t</div>";
}
echo "</div>";
?>