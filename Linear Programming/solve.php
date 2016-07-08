<?php
//GRAB AJAX DATA
	$M = $_POST["JSON"];
	$R = $_POST["size"];
	$C = $_POST["size2"];
	$R++;	
	$C = $C + $R + 1;
	$size = $R * $C;
	$x=0;
	$MATRIX[0][0] = null;
//BUILD MATRIX
	WHILE(($x<$size) &&  ($val = $M[$x])):
		$pos = explode(",",$val["name"]);
		$MATRIX[$pos[0]][$pos[1]] = $val["value"];
		$x++;
	ENDWHILE;
//INITIALIZE VARS
	$isObjFuncOK = 0;
	$isMatrixUnbounded = 0;
	$pivotRow = 0;
	$pivotCol = -1;
	$pivotRowVal = 0;
	$pivotColVal = 0;
	$step=0;
//MAKE CANONICAL
	for($a=1;$a<$R;$a++)
			if($MATRIX[$a][0]<0)
				for($b=0;$b<$C;$b++)
					$MATRIX[$a][$b]*=-1;
	echo ' <a href="#" class="list-group-item active">
								    <h4 class="list-group-item-heading">INITIAL TABLEAU S('.getBasic($MATRIX,$R,$C).')</h4>
								    <div class="row list-group-item-text">';
			printMatrix($MATRIX,$R,$C);
			echo "</div></a>";

//START OF LOOP
	WHILE($isMatrixUnbounded == 0 && $isObjFuncOK==0):
	$step++;
		
		$pivotCol = -1;
		$pivotColVal = 0;
		//SELECT PIVOT COLUMN
		for ($x=$C-1; $x >0 ; $x--){
			 //if($MATRIX[0][$x]<$pivotColVal){ //Smallest Index Rule
			if($MATRIX[0][$x]<0){   //Smallest Ratio Rule
				$pivotCol = $x;
				$pivotColVal = $MATRIX[0][$x];
			}
		}

		if($pivotCol==-1)
			$isObjFuncOK = 1;

		if($isObjFuncOK==0){
			$pivotRow = -1;
			$pivotRowVal = 0;
			//SELECT PIVOT ROW

			for ($x=$R-1; $x >0 ; $x--){
						//Smallest Ratio Rule
							if($MATRIX[$x][$pivotCol]==0)
								$ratio = 0;
							else if($MATRIX[$x][$pivotCol]==1)
								$ratio = $MATRIX[$x][0];
							else
								$ratio = $MATRIX[$x][0] / $MATRIX[$x][$pivotCol];

							if($x==$R-1){
								if($ratio > 0 ){
									$smallestRatio = $ratio;
									$pivotRow = $x;
									$pivotRowVal = $MATRIX[$x][$pivotCol];
								}else{
									$smallestRatio = 1000000;
								}
							}else{
								if($ratio<=$smallestRatio && $ratio>0){
									$smallestRatio = $ratio;
									$pivotRow = $x;
									$pivotRowVal = $MATRIX[$x][$pivotCol];
								}
							}
								
						//Smallest Index Rule
							/*if($MATRIX[$x][$pivotCol]>0){
								$pivotRow = $x;
								$pivotRowVal = $MATRIX[$x][$pivotCol];
							}*/
						}
						if($pivotRow==-1)
							$isMatrixUnbounded = 1;	
						if($isMatrixUnbounded==0){
							//MAKE PIVOT 1
							for($x=0;$x<$C;$x++)
								$MATRIX[$pivotRow][$x] /= $pivotRowVal; 

							//MAKE OTHERS 0
							for($y=0;$y<$R;$y++){
								$val = $MATRIX[$y][$pivotCol];
								if($y!=$pivotRow){
									for($x=0;$x<$C;$x++)
										$MATRIX[$y][$x] = $MATRIX[$y][$x] - ($val*$MATRIX[$pivotRow][$x]); 
											}
							}
						}
			}

			echo ' <a href="#" class="list-group-item">
				    	<h4 class="list-group-item-heading">'.$step.' : S('.getBasic($MATRIX,$R,$C).')</h4>
					    <div class="row list-group-item-text">';
			if($isMatrixUnbounded==0 && $isObjFuncOK==1){
					echo "<h5 class='col-lg-offset-1'><b>The Solution is Optimal</b></h5>";
					printSolution($MATRIX,$R,$C);
				 }
			else if($isMatrixUnbounded==1 && $isObjFuncOK==1){
					echo "<h5 class='col-lg-offset-1'><b>The Solution is Infeasible</b></h5>";
				 }
			else if($isMatrixUnbounded==0 && $isObjFuncOK==0){
					echo "<h5 class='col-lg-offset-1'><b>Continuously solving for a solution...</b></h5>";
			}
			else if($isMatrixUnbounded==1 && $isObjFuncOK==0){
					echo "<h5 class='col-lg-offset-1'><b>The Solution is Unbounded</b></h5>";
			}
			printMatrix($MATRIX,$R,$C);
		echo "</div></a>";
	ENDWHILE;

function printSolution($M,$row,$col){
	//PRINT SOLUTION
		for($b=1;$b<$col;$b++)
			for($a=0;$a<$row;$a++)
				if($M[$a][$b]==1){
					$sum=$row;
					for($z=0;$z<$row;$z++)
						if($M[$z][$b]==0)
							$sum--;
					if($sum==1){
						echo "<span class='col-lg-offset-1 col-lg-2 label label-success'>X".$b." = ".$M[$a][0]."</span><br/>";
						$a=$row;
					}
					
				}else{
					if($a==$row-1)
						echo "<span class='col-lg-offset-1 col-lg-2 label label-default'>X".$b." = 0</span><br/>";
				} 
		}
function getBasic($M,$row,$col){
	//DETERMINE BASIC VALUES
		$basic = 0;
		for($a=0;$a<$row;$a++)
			for($b=0;$b<$col;$b++)
				if($M[$a][$b]==1){
				$sum=$row;
				for($z=0;$z<$row;$z++)
					if($M[$z][$b]==0)
						$sum--;
				if($sum==1)
					if($basic!=0)
						$basic.=",".$b;
					else
						$basic=$b;
					
				}
	return $basic;
}


//MATRIX PRINTER
function printMatrix($M,$row,$col){
	echo '<div class="col-lg-8 col-lg-offset-2 well">';
	for($i=0;$i<$row;$i++){
		echo "<br/>";
		for($j=0;$j<$col;$j++){
			$frac = farey($M[$i][$j],100);
			if($j==0)
				$class="success";
			else
				$class="danger";

			if($M[$i][$j]==1){
				$sum1=0;
				$sum0=0;
				for($z=0;$z<$row;$z++){
					if($M[$z][$j]==1)
						$sum1++;
					else if($M[$z][$j]==0)
						$sum0++;
				}
				if($sum1==1 && $sum0==($row-1))
					$class="primary";
			}
			if($frac[1]==1)
				echo "<span class='label label-".$class." col-lg-1'>".$M[$i][$j]."</span>&nbsp;";
			else{
				echo "<span class='label label-".$class." col-lg-1'>".$frac[0]."/".$frac[1]."</span>&nbsp;";
			}
		}
	}
	echo '</div>';
}

//FRACTION SIMPLIFIER
	function farey($v, $lim) {
    // No error checking on args.  lim = maximum denominator.
    // Results are array(numerator, denominator); array(1, 0) is 'infinity'.
    if($v < 0) {
        list($n, $d) = farey(-$v, $lim);
        return array(-$n, $d);
    }
    $z = $lim - $lim;  
    list($lower, $upper) = array(array($z, $z+1), array($z+1, $z));
    while(true) {
        $mediant = array(($lower[0] + $upper[0]), ($lower[1] + $upper[1]));
        if($v * $mediant[1] > $mediant[0]) {
            if($lim < $mediant[1]) 
                return $upper;
            $lower = $mediant;
        }
        else if($v * $mediant[1] == $mediant[0]) {
            if($lim >= $mediant[1])
                return $mediant;
            if($lower[1] < $upper[1])
                return $lower;
            return $upper;
        }
        else {
            if($lim < $mediant[1])
                return $lower;
            $upper = $mediant;
        }
    }
}
?>