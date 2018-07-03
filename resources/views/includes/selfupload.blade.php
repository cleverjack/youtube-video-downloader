    <form id="formAdd" class="form-horizontal" method="POST" action="upload-myvideo" enctype="multipart/form-data">
        {{ csrf_field() }}
        
        <div class="form-group">
            <label for="name" class="col-md-2 control-label" style="text-align: left;">Video Upload:</label>
            <div class="col-md-6" style="margin-top: 6px;">
                <input id="input-file" type="file" name="video" required>
            </div>
        </div>
        
        <div class="form-group">
            <label for="name" class="col-md-2 control-label" style="text-align: left;">Thumbnail Upload:</label>
            <div class="col-md-6" style="margin-top: 6px;">
                <input id="input-file" type="file" name="thumbnail" required>
            </div>
        </div>
        
        
        <div class="row">

	  		<div class="panel-body">

				<div class="row">

								<input type="hidden" id="local_hidden"/>
				  				<div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
									{!! Form::label('Title:') !!}
									{!! Form::text('local_title', old('local_title'), ['class'=>'form-control', 'placeholder'=>'Enter Title', 'required']) !!}
									<span class="text-danger">{{ $errors->first('title') }}</span>
								</div>

								<div class="form-group">
									{!! Form::label('Description:') !!}
									{!! Form::textarea('local_description', old('local_description'), ['class'=>'form-control', 'placeholder'=>'Enter Description']) !!}
								</div>


								<div class="form-group">
									{!! Form::label('Category:') !!}
									<select class='btn btn-default' id='local_parent_id' name='local_category_id'>

										@foreach($allCategories as $key=>$item)
									  	<option value="{{$key}}">{{$item}}</option>
										@endforeach
									</select>
									
								</div>
								
								<div class="form-group" >
									{!! Form::label('Age:') !!}
									<select class='btn btn-default' id='local_age_id' name='local_age_id'>
									    <option value=1>School Age</option>
									    <option value=2>PreSchool Age</option>
									</select>
								</div>
								<div class="form-group">
									<button id="local_btn" name="local" type="submit">Upload</button>
								</div>
							
	  			</div>


	  		</div>
        </div>

    </form>
    
	


<!--
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
-->