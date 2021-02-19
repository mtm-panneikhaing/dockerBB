@extends("layouts.app")
@section("content")
<div class="container">
  @if(session('info'))
    <div class="alert alert-info">
      {{ session('info') }}
    </div>
  @endif
  <form method="GET">
    @csrf
    <div class="form-group row">
      <input type="text" class="col-lg-3 col-md-12 ml-3 mr-2 mb-2" placeholder="Search" name="search">
      <input type="submit" value="Search" class="btn btn-primary col-lg-2 col-md-6 mr-2 mb-2">

      <a href="{{url('/posts/add')}}" class="btn btn-primary col-lg-2 col-md-6 mr-2 mb-2">Add</a>
      <a href="{{url('/posts/upload')}}" class="btn btn-primary col-lg-2 col-md-6 mr-2 mb-2">Upload</a>
      <a href="{{ url('/posts/download') }}" class="btn btn-primary col-lg-2 col-md-6 mr-2 mb-2">Download</a>
      
    </div>
  </form>
  <table class="table table-striped mt-3 ">
    <tr>
      <th>Post Title</th>
      <th>Post Description</th>
      <th>Posted User</th>
      <th>Posted Date</th>
      @auth
        <th>Edit </th>
        <th>Delete</th>
      @endauth
      @foreach($posts as $post)
      <tr>
        <td>
          <a data-toggle="modal" data-target="#myModal" class="detail" data-title="{{ $post->title }}"
            data-description="{{ $post->description }}" data-create_user="{{ $post->user->name }}">
            {{$post->title}}
          </a>
        </td>
        <td>{{ $post->description }}</td>
        <td>{{ $post->user->name}}</td>
        <td>{{ $post->created_at->format('m/d/y') }}</td>
        <td>
            <a href='{{url("/posts/update/$post->id")}}' class="btn btn-success btn-xs">
            <i class="fas fa-edit"></i>Edit
            </a>
        </td>
        <td>
          <a href='{{url("/posts/update/$post->id")}}' class="btn btn-success btn-xs">
          <i class="fas fa-edit">
          </i>
          </a>
        </td>
      </tr>
      @endforeach
    </tr>
  </table>
  <div class="modal flade" id="myModal" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Post Detail</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <table id="classTable" class="table table-bordered">
            <tr>
              <th>Title</td>
              <td id="title"></td>
            </tr>
            <tr>
              <th>Description</td>
              <td id="description"></td>
            </tr>
            <tr>
              <th>Created User</td>
              <td id="create_user"></td>
            </tr>
          </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</div>  
<script>
  // photo review 
  $(document).ready(function() {
    $(".deleteDialog").click(function() {
      $('#post').val($(this).data('id'));
      $('#addBookDialog').modal('show');
    });
  });

  //posts detail
  $(document).ready(function() {
    $(document).on("click", ".detail", function() {
      $(".modal-body #title").text($(this).data('title'));
      $(".modal-body #description").text($(this).data('description'));
      $(".modal-body #create_user").text($(this).data('create_user'));
    });
  });

  // delete posts id to confirmation modal
  $(document).ready(function() {
    $(document).on("click", ".delete", function() {
      $(".modal-body #id").val($(this).data('id'));
    });
  });
</script>
@endsection