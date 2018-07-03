
    
	<div class="row">

		<div id="fileuploader">Upload</div>

	  		<div class="panel-body">
	  			<div id="video_container" class="row">
	  				
	  				
				</div>


				<div class="row">

								<input type="hidden" id="register_hidden"/>
				  				<div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
									{!! Form::label('Title:') !!}
									{!! Form::text('register_title', old('register_title'), ['class'=>'form-control', 'placeholder'=>'Enter Title']) !!}
									<span class="text-danger">{{ $errors->first('title') }}</span>
								</div>

								<div class="form-group">
									{!! Form::label('Description:') !!}
									{!! Form::textarea('register_description', old('register_description'), ['class'=>'form-control', 'placeholder'=>'Enter Description']) !!}
								</div>


								<div class="form-group">
									{!! Form::label('Category:') !!}
									<select class='btn btn-default' id='register_parent_id'>

										@foreach($allCategories as $key=>$item)
									  	<option value="{{$key}}">{{$item}}</option>
										@endforeach
									</select>
									
								</div>
								
								<div class="form-group" >
									{!! Form::label('Age:') !!}
									<select class='btn btn-default' id='register_age_id'>
									    <option value=1>School Age</option>
									    <option value=2>PreSchool Age</option>
									</select>
								</div>
								<div class="form-group">
									<button id="register_btn" name="register">Register</button>
								</div>
							
	  			</div>


	  		</div>
    </div>




<script>

$(function()
{
	$('#register_btn').click(function(e){
	    
	   
       var item = $('#register_hidden').val();
	    
	    if($('#register_parent_id').find(":selected").val() == null){
	      alert("Please add the category");
	    }else{
		    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

		    if($.isNumeric(item)){
	    		

		    	$.ajax({
		      		type: 'post',
		      		data: {_token:CSRF_TOKEN, id: item, category_id:$('#register_parent_id').find(":selected").val(), age_id:$('#register_age_id').val(), video_title: $('[name="register_title"]').val(), video_description: $('[name = "register_description"]').val(), },
		      		url: 'update-video',
		      		success: function(result){
		      			alert("update successfully")
		      		},

		   	 	});
			
			}else{

		    	var video_url = $('#register_video').attr('src');

		    	$.ajax({
		      		type: 'post',
		      		data: {_token:CSRF_TOKEN, video_url: video_url, category_id:$('#register_parent_id').find(":selected").val(), age_id:$('#register_age_id').val(), video_id: $('#register_hidden').val(), video_title: $('[name="register_title"]').val(), video_description: $('[name = "register_description"]').val(), },
		      		url: 'upload-video',
		      		success: function(result){
		          		alert(result);
		      		},

		   	 	});
			}
	    }
  });
});
</script>
