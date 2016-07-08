<?php
//GRAB AJAX DATA
	$M = $_POST["JSON"];
	$R = $_POST["size"];
	$C = $_POST["size2"];
	$ZOOM = $_POST["zoom"];
	$R++;
	$C = $C + $R + 1;
	$size = $R * $C;
	$x=0;
	$MATRIX[0][0] = null;
	$minX = -10;
	$minY = -10;
	$maxX = 10;
	$maxY = 10;
	$EQ = null;
	$COLORS = array(1 => 'BLUE', 'RED', 'GREEN','ORANGE','BROWN','VIOLET');
//BUILD MATRIX
	WHILE(($x<$size) &&  ($val = $M[$x])):
		$pos = explode(",",$val["name"]);
		$MATRIX[$pos[0]][$pos[1]] = $val["value"];
		$x++;
	ENDWHILE;

if($ZOOM<1) $ZOOM=1;
if($ZOOM>10)
	$TICK = ceil($ZOOM / 10);
else
	$TICK = 1;
			echo '<div><br/>* Note : Points of the Line are computed through the Point Slope Form<br/> ( y = mx + b) , m = RISE / RUN</div>';

	echo '<canvas id="myCanvas" width="480" height="300" class="well"></canvas>';
	echo '<style>
			.legendColor {
				display: inline;
				padding: .2em .6em .3em;
				font-size: 75%;
				font-weight: bold;
				line-height: 1;
				color: #ffffff;
				white-space: nowrap;
				vertical-align: baseline;
				border-radius: .25em;
			}
			</style>';
	for($x=1; $x < $R; $x++){
			$thisB = $MATRIX[$x][0];
			$thisX = $MATRIX[$x][1];
			$thisY = $MATRIX[$x][2];
			if($thisY!=0){
				$thisM = (($thisX*-1)/$thisY);
				$thisBB = ($thisB/$thisY);
			}
			else{
				$thisM = 0;
				$thisBB = 0;
			}

			$frac = farey($thisM,100);
			$frac2 = farey($thisBB,100);
			if($frac[1]!=1 && $frac[1]!=0) $thisM =  $frac[0]."/".$frac[1];
			if($frac2[1]!=1 && $frac2[1]!=0) $thisBB =  $frac2[0]."/".$frac2[1];
			$thisEQ = "(".$thisM."x ) + ".$thisBB;
			
			echo "<span class='label label-default col-lg-3 col-lg-offset-1' >y = ".$thisEQ."</span>&nbsp;&nbsp;<span class='legendColor ' style='background-color: ".$COLORS[$x]."'></span><br/>";
	}
echo "<script type='text/javascript'>$(document).ready(function(){

  var myGraph = new Graph({
        canvasId: 'myCanvas',
        minX: ".($ZOOM*-1).",
        minY: ".($ZOOM*-1).",
        maxX: ".($ZOOM).",
        maxY: ".($ZOOM).",
        unitsPerTick: ".$TICK."
      });
";
	for($x=1; $x < $R; $x++){
			$thisB = $MATRIX[$x][0];
			$thisX = $MATRIX[$x][1];
			$thisY = $MATRIX[$x][2];
			if($thisY!=0){

				$thisYY = $thisB/$thisY;
				$thisM = (($thisX*-1)/$thisY);
				$thisBB = ($thisB/$thisY);
			}else{
				$thisYY = 0;
				$thisM = 0;
				$thisBB = 0;
			}
			if($thisM!=0)
				$thisXX = ($thisBB*-1)/$thisM;
			else
				$thisXX = 0;
			$frac = farey($thisM,100);
			$frac2 = farey($thisBB,100);
			$frac3 = farey($thisXX,100);
			if($frac[1]!=1 && $frac[1]!=0) $thisM =  $frac[0]."/".$frac[1];
			if($frac2[1]!=1 && $frac2[1]!=0) $thisBB =  $frac2[0]."/".$frac2[1];
			if($frac3[1]!=1 && $frac3[1]!=0) $thisXX =  $frac3[0]."/".$frac3[1];
			$thisEQ = "(".$thisM." * x ) + ".$thisBB;
			echo "
			myGraph.drawEquation(function(x) {  return ".$thisEQ."; }, '".$COLORS[$x]."', 3);
			myGraph.drawPoly( ".$thisXX.",".$thisBB.",'".$COLORS[$x]."', 3);";
	}
echo "});</script>";

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