<!DOCTYPE html>
<html>
	<head>
		<title>Linear Programming</title>		
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="styles/css/bootstrap.min.css">
		<script src="scripts/js/jquery-1.10.1.min.js"></script>
		<script src="scripts/js/bootstrap.min.js"></script>
		<style type="text/css">
			body   {   
					background:#ffffff url('styles/img/bg.JPG') no-repeat fixed 100% 100%;  
                    background-size: cover;    
                  }
            body { padding-top: 70px; }

            #form-matrix > .table tbody tr td { text-align: center; vertical-align: middle;}
            #form-matrix > .table thead th { text-align: center; vertical-align: middle;}
		</style>
	</head>
	<body >
		<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<a class="navbar-brand" href="../LP">Linear Programming with Graphical Method</a>
			</div>
		</nav>
		<div class="container">
			<div class="row">
				<div class="col-lg-3">
					<div class="panel">
					  <div class="panel-body">
					  	<form class="form-horizontal" role="form">
					  		<div class="form-group">
							    <label class="col-lg-8 control-label">Constraints</label>
							    <div class="col-lg-4">
									<input id="cons" type="number" class="form-control" min="2" max="5" value="3"/>
								</div>
							</div>
					  		<div class="form-group">
							    <label class="col-lg-8 control-label">Variables</label>
							    <div class="col-lg-4">
									<input id="vars" type="number" class="form-control" min="2" max="5" value="2"/>
								</div>
							</div>
						</form>
					  </div>
					  <div class="panel-footer">Note : Changing the Values will reset the Tableau's Elements</div>
					</div>
				</div>
				<div class="col-lg-9">
					<div class="panel">
					  	<div class="panel-body">
					  		<div id="miniLoader" style="text-align:center;display:none;">
		                        <h5 class="text-muted">This might take a little while.</h5>
                      		</div>
						  	<form id="form-matrix" role="form">
						  	</form>
						  	<div>
						  		<div class="list-group" id="sect-list">
								</div>
							</div>
						</div>
						<div class="panel-footer">
							<button id="btn-reset" class="btn btn-danger btn-sm">&nbsp;Clear</button>
							<button id="btn-solve" class="btn btn-success btn-sm">&nbsp;Simplex Algorithm</button>
                            <button id="startGraph" class="btn btn-success btn-sm" data-toggle="modal" href="#myModal"><span></span>Graphical Presentation<img id="startGraph" src="styles/img/loadGray.gif" class="hidden" style="width:16px;height:16px;display: inline-block; margin-left: 5px;" /></button>
							<span class="text-muted" style="float:right">Note : The Simplex Tableau is being solved with the Minimum Ratio Rule</span>
						</div>
					</div>
				</div>
			</div>
		</div>
				  <!-- Modal -->
		  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		    <div class="modal-dialog">
		      <div class="modal-content">
		        <div class="modal-header">
		          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		          <h4 class="modal-title">Graphical Representation</h4>
		        </div>
		        <div class="modal-body" style="text-align:center">
					<div  id="modal-graph"></div>
		        </div>
		        <div class="modal-footer">
		          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		          <button type="button" id="zIn" class="btn btn-primary"><span class="glyphicon glyphicon-zoom-in"></span></button>
		          <button type="button" id="zOut" class="btn btn-primary"><span class="glyphicon glyphicon-zoom-out"></span></button>
		          <input type="range"  id="zoom" min="1" max="100" value="5">
		        </div>
		      </div><!-- /.modal-content -->
		    </div><!-- /.modal-dialog -->
		  </div><!-- /.modal -->
	</body>
</html>
<script type="text/javascript" src="scripts/js/graph.js"></script>
<script type="text/javascript" src="scripts/js/solve.js"></script>