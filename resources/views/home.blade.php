@extends('layouts.app')

@section('content')
<div class="container">
  <div id="main" class="row">

         <!-- sidebar content -->
      

         <!-- main content -->
      <div id="content" class="col-md-12">
           <div>

             <!-- Nav tabs -->
             <ul class="nav nav-tabs" role="tablist">
               <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Upload Local Videos</a></li>
               <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Search Videos</a></li>
               <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Upload Remote Videos</a></li>
               <li role="presentation"><a href="#display" aria-controls="display" role="tab" data-toggle="tab">Preview</a></li>
             </ul>

             <!-- Tab panes -->
           <div class="tab-content">
             <div role="tabpanel" class="tab-pane fade in active" id="home">
                  @include('includes.selfupload')
             </div> 
             <div role="tabpanel" class="tab-pane fade" id="profile" style="margin-top:20px">
                  @include('includes.additem') 
             </div> 
             <div role="tabpanel" class="tab-pane fade" id="messages" style="margin-top:20px"> 
                  @include('includes.registervideo') 
             </div> 
             <div role="tabpanel" class="tab-pane fade" id="display" style="margin-top:20px"> 
                  @include('includes.preview') 
             </div> 
           </div> 

           </div> 
      </div> 

  </div> 
  @include('includes.footer') 
</div> 

@endsection 
