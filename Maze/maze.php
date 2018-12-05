<?php 
	class maze{

		private $mazeArray = array();//地圖二維陣列
		private $entrance = array(0,0);//起點(y,x)
		private $exit = array();//終點(y,x)	
		private $pathCount = array();//紀錄最小通道數

		//將地圖字串轉成陣列
		private function generateMaze($mazeString){
			$row = 0;
			$col = 0;
			for ($i=0; $i < strlen($mazeString); $i++,$col++) {
				if ($mazeString[$i] == "\n") {
					$row++;
					$col = -1;
					continue;
				}

				$this->dir[$row][$col] = 0;
				$this->mazeArray[$row][$col] = $mazeString[$i];

				if ($mazeString[$i] == "S") {
					$this->entrance[0] = $row;//y
					$this->entrance[1] = $col;//x
					$this->mazeArray[$row][$col] = "0";
				}

				if ($mazeString[$i] == "E") {
					$this->exit[0] = $row;//y
					$this->exit[1] = $col;//x
					$this->mazeArray[$row][$col] = "0";
				}	
			}
		}

		//開始尋找路徑
		private function findPath($mazeArray, $y, $x, $endy, $endx, $pathCount){
			
			//此點不為0則return
			if ($mazeArray[$y][$x]) return;

			//找到終點，儲存路徑後return
			$mazeArray[$y][$x] = "*";
			if ($mazeArray[$endy][$endx] == "*") {
				array_push($this->pathCount, $pathCount);	
				return;
			}

			//未找到終點，繼續找路(上下左右,路徑數+1)
			$this->findPath($mazeArray, $y, $x+1, $endy, $endx, $pathCount+1);
			$this->findPath($mazeArray, $y+1, $x, $endy, $endx, $pathCount+1);
			$this->findPath($mazeArray, $y, $x-1, $endy, $endx, $pathCount+1);
			$this->findPath($mazeArray, $y-1, $x, $endy, $endx, $pathCount+1);					
		}

		//顯示目前地圖
		function showMaze(){
			for ($i=0; $i < count($this->mazeArray); $i++) { 
				for ($j=0; $j < count($this->mazeArray[$i]); $j++) { 
					if ($i == $this->exit[0] and $j == $this->exit[1]) {
						echo "E";
					}
					elseif ($i == $this->entrance[0] and $j == $this->entrance[1]) {
						echo "S";
					}else{
						echo $this->mazeArray[$i][$j];
					}
				}
				echo "</br>";
			}
		}

		//得到最短路徑數
		function getShortestPath(){
			$shortest;
			if (!isset($this->pathCount[0])) {
				$shortest = -1;
			}

			for ($i=0; $i < count($this->pathCount); $i++) { 
				if($i == 0){
					$shortest = $this->pathCount[$i];
					continue;
				}
				if ($shortest > $this->pathCount[$i]) {
					$shortest = $this->pathCount[$i];
				}
			}
			return $shortest;
		}

		//迷宮初始化
		function mazeWalk($mazeString){
			if (strlen($mazeString) > 10000) {
				return ;
			}

			$this->generateMaze($mazeString);
			$nowPoint = $this->entrance;
			$end = $this->exit;

			$this->findPath($this->mazeArray, $nowPoint[0], $nowPoint[1], $end[0], $end[1], -1);
		}	
	}
 ?>