$(document).ready(function(){
		updateMatrixSize();
			$("#zoom").on("change",function(){
			var c = parseInt($("#vars").val());
			if(c==2){
				updateGraph();
			}else{
				$("#modal-graph").html("Ooops! We can only present graphs for 2 variables");
			}
		});
		$("#zIn").click(function(){ 
			var z = parseInt($("#zoom").val());
			
			if(z<=10) z-=1;
			else z-=5;
			if(z<=1) z=1;
			$("#zoom").val(z);
			var c = parseInt($("#vars").val());
			if(c==2){
				updateGraph();
			}else{
				$("#modal-graph").html("Ooops! We can only present graphs for 2 variables");
			}
		});
		$("#zOut").click(function(){ 
			var z = parseInt($("#zoom").val());
			if(z>=1000) z=1000;
			if(z<=10) z+=1;
			else z+=5;
			$("#zoom").val(z);
			var c = parseInt($("#vars").val());
			if(c==2){
				updateGraph();
			}else{
				$("#modal-graph").html("Ooops! We can only present graphs for 2 variables");
			}
		});
		$("#startGraph").click(function(){
			var c = parseInt($("#vars").val());
			if(c==2){
				updateGraph();
			}else{
				$("#modal-graph").html("Ooops! We can only present graphs for 2 variables");
			}
		});


		$("#cons").change(function(){
			$("#sect-list").empty();
			updateMatrixSize();
		});
		$("#vars").change(function(){
			$("#sect-list").empty();
			updateMatrixSize();
		});
		$("#btn-reset").on("click",function(event){
			event.preventDefault();
			$("#sect-list").empty();
      		$("#loaderReset").removeClass("hidden");
			updateMatrixSize();
            $("#loaderReset").addClass("hidden");
		});
		$("#btn-solve").click(function(){
      		$("#loaderSolve").removeClass("hidden");
			solveMatrix();
			$("#loaderSolve").addClass("hidden");
		});

		$("#form-matrix").on("change","td>input", function(event){

			$("#sect-list").html("<a href='#' class='list-group-item'><h4 class='list-group-item-heading'>Linear Programming Model</h4><p id='sect-lpm' class='list-group-item-text'></p></a>");
			event.preventDefault();
			updateLPM();

		});

		function updateGraph () {
				var c = parseInt($("#vars").val());
				var r = parseInt($("#cons").val());
				var z = parseInt($("#zoom").val());
	 			var dataMatrix = $("#form-matrix").serializeArray();
				$.post("graph.php",{ JSON : dataMatrix , size : r , size2 : c , zoom : z},function(data){
					$("#modal-graph").html(data);
				});
		}
		function updateMatrixSize(){ 
			$("#form-matrix").empty();
  			$("#miniLoader").fadeIn();
			var r = parseInt($("#cons").val());
			var c = parseInt($("#vars").val());
			var MatrixString = '<table class="table table-bordered table-hover table-condensed"><thead><th></th><th class="success">b</th>';
			for (var i = 0; i < c; i++)
				MatrixString+= '<th class="warning">X'+(i+1)+'</th>';
			for (var i = c; i <= (r+c); i++)
					MatrixString+= '<th class="danger">X'+(i+1)+'</th>';
			MatrixString+= '</thead><tbody>';
			for (var i = 0; i <= r; i++){
				var ii = "Z";
				if(i!=0){
					ii=i;
				}
				MatrixString+= '<tr><td relX="'+(i)+'" relY="-1"><span class="label label-info">Row '+(ii)+'</span></td><td class="success" relX="'+i+'" relY="0"><input name="'+i+',0" type="number" class="form-control" value="1"></td>';
				for (var j = 0; j < c; j++){
					MatrixString+= '<td class="warning" relX="'+i+'" relY="'+(j+1)+'"><input name="'+i+','+(j+1)+'" type="number" class="form-control" value="1"></td>';
				}
				for (var j = 0; j <= r; j++){
					var y = parseInt(c) + j + 1 ;
					if(i==j)
						MatrixString+= '<td class="danger" relX="'+i+'" relY="'+y+'" ><input name="'+i+','+y+'" type="number" class="form-control" value="1"></td>';
					else
						MatrixString+= '<td class="danger" relX="'+i+'" relY="'+y+'"><input name="'+i+','+y+'" type="number" class="form-control" value="0"></td>';
				}
			}
				MatrixString+= '	</tbody></table>';
				$("#miniLoader").hide(function(){
				      $("#form-matrix").html(MatrixString);
				     });
			updateLPM();
		}

		function updateLPM(){
			var string="";
			var sumrow=0;
			$("#form-matrix").find("td").each(function(){
				var x = parseInt($(this).attr("relX"));
				var y = parseInt($(this).attr("relY"));
				var val = parseInt($(this).find("input").val());
				var aval=parseInt(Math.abs(val));
				var valnext = parseInt($(this).next().find("input").val());
				if(y==-1)
					sumrow=0;
				else
					if(y>0)
						sumrow+=aval;
				if(x==0){
					if(y==-1)
						string+="OBJECTIVE FUNCTION :<br/>";
					if(y==1)
						if(val<0)
							string+=" -";
					if(y>0){
						if(val!=0){
							var aval=parseInt(Math.abs(val));
							if(val==1 || val==-1)
								string+=" <span class='label label-danger'>X"+y+"</span>";
							else
								string+=" <span class='label label-danger'>"+aval+"X"+y+"</span>";
						}
							
					}else if(y==0)
						string+=" <span class='label label-danger'>"+val+"</span> = ";
					
					if(y>0)
						if(valnext>0)
							if(sumrow>0)
								string+=" +";
					if(y>0)
						if(valnext<0)
							string+=" -";
				}else{
					if(y==-1)
						if(x==1)
							string+="<br/>CONSTRAINTS :<br/>";
						else
							string+="<br/>";
					if(y==1)
						if(val<0)
							string+=" -";
					if(y>0)
						if(val!=0)
							if(val==1 || val==-1)
								string+=" <span class='label label-danger'>X"+y+"</span>";
							else
								string+=" <span class='label label-danger'>"+aval+"X"+y+"</span>";
					else if(y==0)
						string+=" <span class='label label-danger'>"+val+"</span> = ";
					
					if(y>0)
						if(valnext>0)
							if(sumrow>0)
								string+=" +";
					if(y>0)
						if(valnext<0)
							string+=" -";

				}
			});
			$("#sect-lpm").html(string);
		}


		function solveMatrix(){
			var dataMatrix = $("#form-matrix").serializeArray();
			var r = parseInt($("#cons").val());
			var c = parseInt($("#vars").val());
			$.post("solve.php",{ JSON : dataMatrix , size : r , size2 : c},function(data){
				$("#sect-list").empty();
				$("#sect-list").html("<a href='#' class='list-group-item'><h4 class='list-group-item-heading'>Linear Programming Model</h4><p id='sect-lpm' class='list-group-item-text'></p></a>");
				updateLPM();
				$("#sect-list").append(data);
			});
		}
	});