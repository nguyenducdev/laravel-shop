<div id="form-edit-categories-content">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="myModalLabel">Edit Categories</h4>
    <div id="loading-action" class="hidden" style="text-align: center;"><i class="fa fa-spinner fa-pulse fa-3x fa-fw margin-bottom"></i><h5>Please wait...</h5></div>
  </div>

  <div class="modal-body categories-content">
    <ul class="error hidden"></ul>

    {!! Form::open(array('url' => '/admin/category/update/'.$category->id, 'method' => 'POST', 'id' => 'form-edit-category', 'name' => 'form-edit-category','files' => true)) !!}
      {!! Form::token() !!}
      <div class="form-group">
        {!! Form::label('lbl_parentID', 'ParentID') !!} &nbsp;
        <select name="parent_id" id="parent_id" class="form-control">
            @if ($category->parent_id == 0)
                <option value="0" selected="true">Root</option>
            @else
                <option value="0">Root</option>
            @endif
                
            @foreach($list_category as $list_category)
                @if($category->parent_id == $list_category->id)
                    <option value="{{ $list_category->id }}" selected="true">{{ $list_category->title }}</option>
                @else
                    <option value="{{ $list_category->id }}">{{ $list_category->title }}</option>
                @endif
            @endforeach
        </select>
      </div>
      <div class="form-group">
        {!! Form::label('lbl_title', 'Title') !!}
        {!! Form::text('title', $category->title , array('class' => 'form-control')) !!}
      </div>
      <div class="form-group">
        {!! Form::label('lbl_description', 'Description') !!}
        {!! Form::text('description', $category->description ,array('class' => 'form-control')) !!}
      </div>

      <div class="form-group">
        <img src="{{ url('/') . '/' . $category->image }}" alt="img" width="200px" height="200px">
        <br>
        {!! Form::hidden('url_image', $category->image) !!}
        {!! Form::label('lbl_img', 'Image') !!}
        {!! Form::file('image', array('accept' => 'image/*', 'class' => 'img-upload')) !!}
      </div>

      <div class="form-group">
        {!! Form::label('lbl_status', 'Show') !!}
        @if ($category->status == 1)
            {!! Form::checkbox('status', '1', array('checked'=>true)) !!}
        @else
            {!! Form::checkbox('status', '1', array()) !!}
        @endif
      </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    {!! Form::submit('Update', array('id'=>'btn-submit', 'class' => 'btn btn-primary')) !!}
  </div>
  {!! Form::close() !!}
</div>
<script>
    $(document).ready(function($) {
        var errorElem = $('#form-edit-categories-content ul.error');
        $('#btn-submit').click(function (e) {
            console.log('ok');
            e.preventDefault();
            //Get form value
            $('#form-edit-categories-content .categories-content').slideToggle();
            $('#loading-action').slideToggle();
            var errors = new Array();
            $.ajax({
                type: "POST",
                url: "{{ url('/admin/category/update').'/'.$category->id }}",
                data: new FormData($('#form-edit-category')[0]),
                cache: false,
                processData: false,
                contentType: false,
                success: function(data) {
                  if (data['error'] == 1) {
                      errorElem.empty();
                      errorElem.append('<li>' + data['message'] + '</li>');
                      // show error popup
                      $('#form-edit-categories-content ul.error').removeClass('hidden');
                      // show hide form and loadding
                      $('#form-edit-categories-content .categories-content').slideToggle();
                      $('#loading-action').slideToggle();
                      return;
                  }
                  // hide reveal
                  $('#form-edit-categories-content .close').trigger('click');
                  // show add package result
                  alert(data["message"]);
                  location.reload();
                },
                error: function(jqXHR) {
                    errorElem.empty();
                    if (jqXHR.status == 422) {
                        $.each(jqXHR.responseJSON, function(key, value) {
                            errorElem.append('<li>' + value + '</li>');
                        })
                    } else {
                        errorElem.append('<li>Update Categories failed.</li>');
                    }
                    $('#form-edit-categories-content ul.error').removeClass('hidden');
                      // show hide form and loadding
                    $('#form-edit-categories-content .categories-content').slideToggle();
                    $('#loading-action').slideToggle();
                }
            });
        });
    });
</script>
