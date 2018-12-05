<?php 
	/*
		
		1.將1+2*3/2 變成 +1+2*3/2
		2.將符號與數字分開為陣列儲存 => NumArray('1','2','3','2'); OprArray('+','+','*','/')
		3.逆序以遞迴方式結合(左向右運算),result初始為0 

		=> (/)->(2)  和  (*)->(3)  和  (+)-> 2  => result = ((0+2)*3)/2 = 3
		=> (+)->(1)  =>  result = 3+1 = 4
		
	*/
	class Cal{

		private $memTag = 0;//數字陣列的索引
		private $statusCode = 0;
		//數字與符號陣列
		private $testOpr = array();
		private $testNum = array();

		private function CalRecur($pos){
			$result = 0;
			if ($this->testOpr[$pos] == "*" ) {
				$result = $this->CalRecur($pos+1) * $this->testNum[$pos];
			}

			if ($this->testOpr[$pos] == "/"){
				$divide = $this->CalRecur($pos+1);
				$divisor = $this->testNum[$pos];

				if($divisor == 0){
					$this->statusCode = 1;
				}
				if($divide == 0 and $divisor == 0){
					$this->statusCode = 2;
				}
				if ($this->statusCode > 0) {
					return;
				}
				$result = $divide / $divisor;
			}

			if ($this->testOpr[$pos] == "+" or $this->testOpr[$pos] == "-") {
				$result = (float)($this->testOpr[$pos].$this->testNum[$pos]);
			}
			$this->memTag ++;

			return $result;
		}

		//運算字串分為符號陣列與數字陣列
		private function StrToArray($testStr){
			//比對用陣列
			$opr = array('+', '-', '*', '/');
			$num = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '.');

			//1.對字串符號正規化1+1 => +1+1
			if($testStr[0] != "+" and $testStr[0] != "-")$testStr = "+".$testStr;

			//1+11將11存到strTemp後,數字存到testNum,符號存到testOpr 
			$strTemp = "";
			for ($i = strlen($testStr)-1; $i >= 0; $i--) {
				$oprflag = 0;

				//是否為符號，是就把字串push，符號push，完成單元化
				foreach ($opr as $value) {
					if ($value == $testStr[$i]) {
						$oprflag += 1;
						break;
					}
				}

				if ($oprflag) {
					array_push($this->testOpr, $testStr[$i]);
					array_push($this->testNum, $strTemp);
					$strTemp = "";
					continue;
				}

				$strTemp = $testStr[$i].$strTemp;

			}
			
		}

		function Caculate($testStr){
			if(empty($testStr) or !isset($testStr) or !is_string($testStr))return "NaN";

			$this->StrToArray($testStr);
			$this->statusCode = 0;
			$result = 0;

			echo "原始字串:".$testStr."</br>";

			while ($this->memTag < count($this->testNum)) {
				if ($this->statusCode == 1 or $this->statusCode == 2) {
					$result = "NaN";
					break;
				}
				$result += $this->CalRecur($this->memTag);		
			}
			return $result;
		}
	}
 ?>