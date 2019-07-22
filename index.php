<?php
$databasehost='127.0.0.1';
$databaseuser='root';
$databasepass='';
$databasename='laravel_join';
$tablename="demo";
$sql="select * from ".$tablename;


$db=mysqli_connect($databasehost,$databaseuser,$databasepass,$databasename) or die ("Connection failed!");
$result =  mysqli_query($db, $sql);



while($row=mysqli_fetch_assoc($result)){
    $id[] = htmlentities($row['id']);
    $ammount[] = htmlentities($row['ammount']);
    $profit[] = htmlentities($row['profit']);
    $loss[] = htmlentities($row['loss']);
    $gain[] = htmlentities($row['gain']);
    $month[] = htmlentities($row['month']);
}
echo "<table>";

echo "<tr><td>id</td>";
for ($i=0; $i<count($id);$i++) {
    echo "<td>".$id[$i]."</td>";
}
echo "</tr><tr><td>ammount</td>";
for ($i=0; $i<count($ammount);$i++) {
    echo "<td>".$ammount[$i]."</td>";
}
echo "</tr><tr><td>profit</td>";
for ($i=0; $i<count($profit);$i++) {
    echo "<td>".$profit[$i]."</td>";
}
echo "</tr><tr><td>loss</td>";
for ($i=0; $i<count($loss);$i++) {
    echo "<td>".$loss[$i]."</td>";
}
echo "</tr><tr><td>gain</td>";
for ($i=0; $i<count($gain);$i++) {
    echo "<td>".$gain[$i]."</td>";
}
echo "</tr><tr><td>month</td>";
for ($i=0; $i<count($month);$i++) {
    echo "<td>".$month[$i]."</td>";
}

echo "</table>";


echo("NB:This is the Static Way");