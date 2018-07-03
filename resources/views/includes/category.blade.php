
	<div class="row">

	  		<div class="panel-body">
	  			<div class="row">
	  				<div class="col-md-3">
	  					<h3>Category List</h3>
				        <ul id="tree1">
				            @foreach($categories as $category)
				                <li>
				                    {{ $category->title }}
				                    @if(count($category->childs))
				                        @include('includes.manageChild',['childs' => $category->childs])
				                    @endif
				                </li>
				            @endforeach
				        </ul>
	  				</div>
	  				<div class="col-md-9">
	  					<h3>Add New Category</h3>

				  			{!! Form::open(['route'=>'add.category']) !!}

				  				@if ($message = Session::get('success'))
									<div class="alert alert-success alert-block">
										<button type="button" class="close" data-dismiss="alert">×</button>
									        <strong>{{ $message }}</strong>
									</div>
								@endif

				  				<div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
									{!! Form::label('Title:') !!}
									{!! Form::text('title', old('title'), ['class'=>'form-control', 'placeholder'=>'Enter Title']) !!}
									<span class="text-danger">{{ $errors->first('title') }}</span>
								</div>

								<div class="form-group">
									<button class="btn btn-success">Add New</button>
								</div>

								<div class="form-group {{ $errors->has('parent_id') ? 'has-error' : '' }}">
									{!! Form::label('Category:') !!}
									{!! Form::select('parent_id',$allCategories, old('parent_id'), ['class'=>'form-control']) !!}
									<span class="text-danger">{{ $errors->first('parent_id') }}</span>
								</div>



				  			{!! Form::close() !!}
							<a id="remove_category" class="btn btn-primary">Remove Category</a>

	  				</div>
	  			</div>


	  		</div>
    </div>

		<script>
		$(function(){
			$('#remove_category').click(function(e){

				$(this).attr('href', './remove-category/' + $('[name="parent_id"]').val());
		//		$.ajax({
		//			type: "get",
		//			url: '/remove-category/' + $('[name="parent_id"]').val(),
		//			success: function(result){
		//				alert(result);
		//			},

		//		});
			});
		});

		</script>
