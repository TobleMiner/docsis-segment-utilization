<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="refresh" content="60">
    <style>
      body {
        background-color: #222222;
        color: #eeeeee;
        overflow: hidden;
        margin: 0;
        font-family: sans-serif;
      }

      h1, h2 {
        margin: 2px;
        padding: 1px;
      }

      .throughput {
        font-size: 20vw;
      }
    </style>
  </head>
  <body>
<?php
  $channel_capacity = 50000;
  $color = array(0, 0, 72);
  $display_throughput = 'No data';
  $data = file_get_contents('/tmp/segmentdata.log');
  if($data) {
    $num_channels = 0;
    $throughput = 0;
    $lines = explode("\n", $data);
    foreach($lines as $line) {
      $parts = explode(':', $line);
      if(count($parts) != 2) {
        continue;
      }
      $throughput += floatval($parts[1]);
      $num_channels++;
    }
    $capacity = $channel_capacity * $num_channels;
    $utilization = $throughput / $capacity;
    $available = 1 - $utilization;
    $hue = 120 * $available;
    $color = array($hue, 100, 50);
    $display_throughput = sprintf("%.2f Mbit/s", $throughput / 1000);
    $display_capacity = sprintf("%.0f Mbit/s", $capacity / 1000);
  }
?>
  <h1>DOCSIS Status</h1>
  <h1 class="throughput" style="color: hsl(<?=$color[0] ?>, <?=$color[1] ?>%, <?=$color[2] ?>%);"><?=$display_throughput ?></h1>
  <h2>Capacity: <?=$display_capacity ?></h1>
  </body>
</html>
