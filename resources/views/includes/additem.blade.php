
<div class="input-group custom-search-form">
    <input type="text" class="form-control" name="search" placeholder="Search..."/>
    <span class="input-group-btn">
        <button id="search_submit" class="btn btn-default-sm" type="submit">
            <i class="fa fa-search"></i>
        </button>
    </span>
</div>
<div>
  <h1>Select the videos</h1>
  <div id="wrapper">
    <section>
        <div class="data-container"></div>
        <div id="pagination-demo1"></div>
    </section>
  </div>

</div>

<script>
$(function(){
  var is_checked = [];
  var items = [];

  $('#search_submit').click(function(e){
      
      alert("Hello");

      $.ajax({
        dataType: "json",
        url: 'https://www.googleapis.com/youtube/v3/search?part=snippet&type=video&maxResults=50&key=AIzaSyCUKY6199WQyyns8bPwOQ1BXpgfEsRO80o&q=' + $('[name="search"]').val(),
        success: function (result) {
            // update your page with the result json
            console.log(result.items);
            items = result.items;
            createDemo('demo1', result.items);
        },
      });
  });

  function createDemo(name, items) {

      var container = $('#pagination-' + name);
      var sources = function () {
          var result = [];

          for (var i = 0; i < items.length; i++) {
              is_checked[i] = false;
              result.push(items[i]);
          }

          return result;
      }();


      var options = {
          dataSource: sources,
          callback: function (response, pagination) {
              window.console && console.log(response, pagination);

              var dataHtml = '<table class="table">';

              dataHtml += '<thead><tr><th>#</th><th>Title</th><th>Option</th></tr></thead>'
              dataHtml += '<tbody></tbody></table>';

              container.prev().html(dataHtml);
              $.each(response, function (index, item) {

                  var ischeck = '';

                  if(is_checked[(pagination.pageNumber - 1) * 10 + index])
                      ischeck = 'checked';
                  var tableInner = '<tr><td>' + ((pagination.pageNumber - 1) * 10 + index + 1)
                                + '</td><td><a target="_blank" href="https://www.youtube.com/watch?v=' + item.id.videoId + '">'
                                + item.snippet.title + '</a></td><td><button class="custom" id="' + item.id.videoId + '" value="' + item.id.videoId + '">Register</button></td></tr>';
                  $('tbody').append(tableInner);

                $('#'+item.id.videoId).click(function(e){

                  $('[href="#messages"]').trigger('click');
                  $('#register_btn').prop('disabled', true);
                  $('#register_hidden').val(item.id.videoId);
                  $('[name="register_title"]').val(item.snippet.title);
                  $('[name="register_description"]').val(item.snippet.description);
                  $('#register_btn').html('Register');
                  $('#video_container').empty();
                  $.ajax({
                       url:'download-url/' + $(this).val(),
                       type:'get',                         
                       success:function(result){
                           
                           var v = document.createElement("VIDEO");

                            v.addEventListener("error", function (e) {
                                $('#video_container').html('<h1>Fail to load this video, Please try again or try another</h1>');
                                $('#register_btn').prop('disabled', true);
                                $('#register_btn').prop('class', 'btn btn-primary disabled');
                            });

                            v.addEventListener("loadeddata", function () {
                                console.log("Video has started loading successfully!");
                                $('#register_btn').prop('disabled', false);
                                $('#register_btn').prop('class', 'btn btn-primary active');
                                
                                v.controlsList = "nodownload";
                            
                                $('#video_container').append(v);
                            });     
                            v.src = result;
                            v.id = "register_video";
                            v.autoplay = true;
                            v.controls = true;
                            
                       },
                       error: function(XMLHttpRequest, textStatus, errorThrown) { 
                           $('#video_container').html('<h1>Can not find download url for this video, Please try again or try another</h1>'); 
                        }, 
                  
                  });
                });
              });

              


          },
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