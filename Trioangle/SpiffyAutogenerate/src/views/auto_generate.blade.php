<!DOCTYPE html>
<html>
<head>
	<title>Auto Generate Mangement</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.8.2/angular.min.js"></script>
</head>
<body>
	<div class="container" ng-app='myApp'>
		<div class="content-wrapper" ng-controller='auto_management'>
		  <!-- Content Header (Page header) -->
		  <section class="content-header">
		    <h3>
		      Add AutoGenerate
		    </h3>
		    
		  </section>

		  <!-- Main content -->
		  <section class="content">
		  	 
		    <div class="box box-info">
		      <!-- /.box-header -->
		      <!-- form start -->

		      	@if(Session::has('message_danger'))
		      	<div class="alert alert-danger">
		      	  {{ Session::get('message_danger')}}
		      	</div>
		      	@endif

		      	@if(Session::has('message_success'))
		      	<div class="alert alert-success">
		      	  {{ Session::get('message_success')}}
		      	</div>
		      	@endif
		        
		        <div class="box-body">
		        	<form action='{{ url('/auto_generate_management') }}' id='form_submit' method="post">
		        		@csrf
		          <div class="form-group">
		            <label for="input_short_name" class="col-sm-3 control-label">Management Name<em class="text-danger">*</em></label>

		            <div class="col-sm-6">
		              <input type="text" name="name" class ='form-control' placeholder = 'Management Name' id="input_short_name">
		              <span class="text-danger"></span>
		              <span class="text-danger" id="err_val1"></span>
		            </div>
		          </div>

		          

		          <div class="form-group">
		            <div class="col-sm-12" style="text-align: right;">
		                <button type="button" class="btn btn-info" value="ADD" ng-click='addNewType()'>ADD</button>
		              </div>
		          </div>

		          <div class="form-group" id='error_show' style="display:none;">
		            <div class="col-sm-5" style="text-align: right;">
		                <span class="text-danger" id="err_val"></span>
		              </div>
		          </div>
		          
		          <div class="form-group" ng-repeat='(key,value) in types track by $index'>
		            <div class="col-sm-4" style="text-align: right; display: inline-block;">
		                <input type="text" class="form-control" name="type_name[]" placeholder="Field Name">
		            </div>
		            <div class="col-sm-4" style="text-align: right; display: inline-block;">
		                <select class="form-control" name="type[]">
		                  <option>String</option>
		                  <option>Number</option>
		                </select>
		            </div>
		            <div class="col-sm-4" style="text-align: right; display: inline;">
		                <button type="button" class="btn btn-danger" ng-click='removeType($index)'>DELETE</button>
		            </div>
		          </div>
		        </div>
		        <!-- /.box-body -->
		        <div class="box-footer" style="text-align: center;">
		          <button type="submit" class="btn btn-info" name="submit" id='submit_button' value="submit">Generate</button>
		        </div>
		        <!-- /.box-footer -->
		      	</form>
		    </div>
		  </section>
		  <!-- /.content -->
		</div>
	</div>
</body>
</html>
<script type="text/javascript">
	var app = angular.module('myApp', []);
	app.controller('auto_management', function($scope) {
	  
		$scope.types = [1];

		$scope.addNewType = function(){
		  $scope.types.push(1);
		}

		$scope.removeType = function(index){
		  console.log(index);
		  $scope.types.splice(index, 1);
		}

	});


	$(document).ready(function() {
	      $("#form_submit").submit(function(e){
	           e.preventDefault();

	           let cond1 = cond2 = false;

	           let management_value = $('#input_short_name').val();

	           if(management_value.length < 3){
	              $('#err_val1').html('Minimum 3 character needed');
	              cond1 = false;
	           }else{
	              $('#err_val1').html('');
	              cond1 = true;
	           }


	           let types = $('input[name^=type_name]').map(function(idx, elem) {
	                        return $(elem).val().toLowerCase();
	                      }).get();
	           
	           let unique = types.filter((v, i, a) => a.indexOf(v) === i);

	           if(types.length !== unique.length){
	              $('#error_show').show();
	              $('#err_val').html('Create unique Field');
	              cond2 = false;
	           }else{
	              $('#error_show').hide();
	              $('#err_val').html('');
	              cond2 = true;
	           }
	           if(cond2 && cond1){
	               console.log('Checking');
	               $("#form_submit").unbind('submit').submit(); 
	               document.getElementById("submit_button").click();
	           }


	      });
	});
</script>