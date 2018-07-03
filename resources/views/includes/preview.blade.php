{!! Form::label('Age:') !!}
<select class='btn btn-default' id='preview_age_id'>
  <option value="1">School</option>
  <option value="2">Preschool</option>
</select>

{!! Form::label('Category:') !!}
<select class='btn btn-default' id='preview_parent_id'>

@foreach($allCategories as $key=>$item)
  <option value="{{$key}}">{{$item}}</option>
@endforeach
</select>



<div id="wrapper">
  <section>
      <div class="data-container"></div>
      <div id="pagination-demo2"></div>
  </section>
</div>

<script>
$('[href="#display"]').click(function(e){

$.ajax({
      dataType: "json",
      url: 'get-videos/' +  $('#preview_age_id').find(":selected").val() + '/' + $('#preview_parent_id').find(":selected").val(),
      success: function (preview_result) {
          // update your page with the result json
          
            console.log(preview_result);
            items = preview_result;
            createDemo('demo2', preview_result);
          
      },
    });
    
    
$('#preview_parent_id').on('change', function(){
    
    
    $.ajax({
      dataType: "json",
      url: 'get-videos/' + $('#preview_age_id').find(":selected").val() + '/' + $(this).find(":selected").val(),
      success: function (result) {
          // update your page with the result json
          
            console.log(result);
            items = result;
            createDemo('demo2', result);
          
      },
    });
});

$('#preview_age_id').on('change', function(){
    
    
    $.ajax({
      dataType: "json",
      url: 'get-videos/' + $(this).find(":selected").val() + '/' + $('#preview_parent_id').find(":selected").val(),
      success: function (result) {
          // update your page with the result json
          
            console.log(result);
            items = result;
            createDemo('demo2', result);
          
      },
    });
});

function createDemo(name, items) {


    if($('#table').length)
      $('#table').remove();
    var container = $('#pagination-' + name);
    var sources = function () {
        var result = [];

        for (var i = 0; i < items.length; i++) {
            result.push(items[i]);
        }

        return result;
    }();

    var options = {
        dataSource: sources,
        callback: function (response, pagination) {
            window.console && console.log(response, pagination);

            var dataHtml = '<table id="table" class="table">';
            dataHtml += '<thead><tr><th>#</th><th>Title</th><th>Option</th></tr></thead>'
            $.each(response, function (index, item) {

               
                dataHtml += '<tr><td>' + ((pagination.pageNumber - 1) * 10 + index + 1)
                              + '</td><td><a target="_blank" href="https://mywork.promoletter.com/storage/app/public/videos/' + item.video_url + '">'
                              + item.video_title + '</a></td><td><a id="edit_video" value="'
                              + item.id + '" onclick="editVideo(' + item.id + ')">edit</a>&nbsp;&nbsp;&nbsp;&nbsp;<a id="delete_video" value="'
                              + item.id + '" onclick="removeVideo(' + item.id + ')">delete</a></td></tr>';



            });

            dataHtml += '</table>';

            container.prev().html(dataHtml);

        }
    };

    //$.pagination(container, options);

    container.addHook('beforeInit', function () {
        window.console && console.log('beforeInit...');
    });
    container.pagination(options);

    container.addHook('beforePageOnClick', function () {
        window.console && console.log('beforePageOnClick...');
        //return false
    });

    return container;
}



});
</script>

<script>
function removeVideo(index){
  $.ajax({
    type: 'get',
    url: 'remove-video/' + index,
    success: function(result){
        $('#delete_video[value="'+index + '"]').parent().parent().remove();
    },
  });
}

function editVideo(index){
  $.ajax({
    type: 'get',
    url: 'edit-video/' + index,
    success: function(result){
      result = jQuery.parseJSON(result);
      $('[href="#messages"]').trigger('click');
      $('#register_hidden').val(result.id);
      $('[name="register_title"]').val(result.video_title);
      $('[name="register_description"]').val(result.video_description);
      $('#video_container').html('<video controls="" controlsList="nodownload" autoplay="" name="media"><source id="register_video" src="../storage/app/public/videos/' 
                          + result.video_url + '"></video>');
      $('#register_parent_id').val(result.category_id);
      $('#register_age_id').val(result.age_id);
      $('#register_btn').html('Update');
    },
  });
}
</script>
