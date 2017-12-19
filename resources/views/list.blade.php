<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>AJAX To-Do List</title>
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" />
</head>
<body>
	<br>
 <div class="container">
 	<div class="row">
 		<div class="col-lg-offset-3 col-lg-6">
 			<div class="panel panel-default">
 			  <div class="panel-heading">
 			    <h3 class="panel-title">AJAX To-Do List <a href="#" id="addNew" class="pull-right"><i class="fa fa-plus" aria-hidden="true" data-toggle="modal" data-target="#myModal"></i></a></h3>
 			  </div>
 			  <div class="panel-body">
 			    <ul class="list-group" id="panel">
 			    	@foreach ($tasks as $task)
 			      	<li class="list-group-item tasks" data-toggle="modal" data-target="#myModal">{{ $task->task }}
 			      		<input type="hidden" id="taskId" value="{{ $task->id }}">
 			      	</li>
 			    	@endforeach
 			    </ul>
 			  </div>
 			</div>
 		</div>

 		<div class="col-lg-2">
 			<input type="text" placeholder="Search" id="searchTask" class="form-control">
 		</div>
		
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title" id="title">Add New Task</h4>
		      </div>
		      <div class="modal-body">
		      	<input type="hidden" id="id">
		        <p><input type="text" class="form-control" placeholder="Your Task Here" id="writeTask"> </p>
		      </div>
		      <div class="modal-footer">
		        <button style="display: none;" type="button" class="btn btn-warning" data-dismiss="modal" id="delete">Delete</button>
		        <button style="display: none;" type="button" class="btn btn-primary" data-dismiss="modal" id="saveChanges">Save Changes</button>
		        <button type="button" class="btn btn-primary" data-dismiss="modal" id="addBtn">Add Task</button>
		      </div>
		    </div><!-- /.modal-content -->
		  </div><!-- /.modal-dialog -->
		</div><!-- /.modal -->

 	</div>
 </div>
 
	{{ csrf_field() }}
	<script
			  src="https://code.jquery.com/jquery-3.2.1.min.js"
			  integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
			  crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
	<script>
		$(document).ready(function() {
			$(document).on('click', '.tasks', function(event) {
				var text = $(this).text();
				var id = $(this).find('#taskId').val();
				$('#title').text('Edit Task');
				var text = $.trim(text);
				$('#writeTask').val(text);
				$('#delete').show('400');
				$('#saveChanges').show('400');
				$('#addBtn').hide('400');
				$('#id').val(id);
				console.log(text);
			});

			$(document).on('click', '#addNew', function(event) {
				$('#title').text('Add New Task');
				$('#writeTask').val("");
				$('#delete').hide('400');
				$('#saveChanges').hide('400');
				$('#addBtn').show('400');
			});

			$('#addBtn').click(function(event) {
				var text = $('#writeTask').val();
				if (text == ""){
					alert('No Task Supplied!');
				}else{
					$.post('list', {'text': text, '_token': $('input[name=_token]').val()}, function(data) {
						$('#panel').load(location.href + ' #panel')
						console.log(data);
					});
				}
			});

			$('#delete').click(function(event) {
				var id = $('#id').val();
				$.post('delete', {'id': id, '_token': $('input[name=_token]').val()}, function(data) {
					$('#panel').load(location.href + ' #panel')
					console.log(data);
				});
			});

			$('#saveChanges').click(function(event) {
				var id = $('#id').val();
				var value = $('#writeTask').val();
				$.post('update', {'id': id, 'value': value, '_token': $('input[name=_token]').val()}, function(data) {
					$('#panel').load(location.href + ' #panel')
					console.log(data);
				});
			});

		});
	</script>
</body>
</html>