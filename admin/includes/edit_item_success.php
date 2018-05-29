<?php 

$jump_secs = 2;
echo "<p class='bg-success'>Item Updated. <a href='items.php'>Click here</a> to jump or the page will be jumped in {$jump_secs} secs </p>";
       header( "refresh:{$jump_secs};url=items.php" );

?>