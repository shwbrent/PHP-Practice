<?php
	include("maze.php");
	$map1 = "1111111\n1000001\n10S1001\n1001001\n10000E1\n1000001\n1111111";
	$map2 = "1111111\n10S1001\n10010E1\n1001001\n1111111";
	$map3 = "1111111\n1000001\n10S1001\n100E001\n1000001\n1000001\n1111111";
	
	$maze = new maze();
	$maze->mazeWalk($map1);
	$maze->showMaze();
	echo "Output:".$maze->getShortestPath();
 ?>