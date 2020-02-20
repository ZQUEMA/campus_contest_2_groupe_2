<?php
$sql ="SELECT 
        ID AS BookID,
        copies_number
    FROM Books" ;
$result = mysqli_query($db,$sql);
while ($req=mysqli_fetch_array($result)){
    $sqlInsert = "INSERT INTO Stocks (ID_Books, amount) VALUES(".$req['BookID'].", ".$req['copies_number'].")";
    $result2 = mysqli_query($db,$sqlInsert);
}