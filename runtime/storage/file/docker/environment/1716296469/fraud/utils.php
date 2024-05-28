<?php
require_once './config/db.php';

function ipCount($count)
{
    global $conn;
    $count = $count-1;
    $ip = $_SERVER['REMOTE_ADDR'];
    $result = controls("SELECT count,update_time FROM ip_counts WHERE ip = ?",$ip);

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if($row['count']>=$count){
                if (time() - strtotime($row['update_time'])<60){
                    return true;
                }else{
                    controls("UPDATE ip_counts SET count = 0 WHERE ip = ?",$ip);
                }
            }else{
                controls("UPDATE ip_counts SET count = count+1 WHERE ip = ?",$ip);
            }
        }
    }else{
        controls("INSERT INTO ip_counts (ip,count) VALUES (?,0)",$ip);
    }

    return false;
}
