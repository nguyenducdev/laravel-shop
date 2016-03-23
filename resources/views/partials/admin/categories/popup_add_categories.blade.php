<div id="form-add-categories-content">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="myModalLabel">Add Categories</h4>
    <div id="loading-action" class="hidden" style="text-align: center;"><i class="fa fa-spinner fa-pulse fa-3x fa-fw margin-bottom"></i><h5>Please wait...</h5></div>
  </div>

  <div class="modal-body categories-content">
    <ul class="error hidden"></ul>

    {!! Form::open(array('url' => '/admin/category/postadd', 'method' => 'post', 'id' => 'form-add-category', 'name' => 'form-add-category','files' => true)) !!}
      {!! Form::token() !!}
      <div class="form-group">
        {!! Form::label('lbl_parentID', 'ParentID') !!} &nbsp;
        <select name="parent_id" id="parent_id" class="form-control">
          <option value="0">Root</option>
          @foreach($category as $category)
            <option value="{{ $category->id }}">{{ $category->title }}</option>
          @endforeach
        </select>
      </div>
      <div class="form-group">
        {!! Form::label('lbl_title', 'Title') !!}
        {!! Form::text('title','', array('class' => 'form-control')) !!}
      </div>
      <div class="form-group">
        {!! Form::label('lbl_description', 'Description') !!}
        {!! Form::text('description','',array('class' => 'form-control')) !!}
      </div>
      <div class="form-group">
        {!! Form::label('lbl_img', 'Image') !!}
        {!! Form::file('image', array('accept' => 'image/*', 'class' => 'img-upload')) !!}
      </div>
      <div class="form-group">
        {!! Form::label('lbl_status', 'Show') !!}
        {!! Form::checkbox('status', '1', array('checked'=>true)) !!}
      </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    {!! Form::submit('Save', array('id'=>'btn-submit', 'class' => 'btn btn-primary')) !!}
  </div>
  {!! Form::close() !!}
</div>
<script>
  $(document).ready(function($) {
      var errorElem = $('#form-add-categories-content ul.error');
      // var formElement = document.querySelector("form");
      $('#btn-submit').click(function (e) {
            e.preventDefault();
            //Get form value
            $('#form-add-categories-content .categories-content').slideToggle();
            $('#loading-action').slideToggle();
            var errors = new Array();
            $.ajax({
                type: "POST",
                url: "{{ url('/admin/category/postadd') }}",
                /*data: $('#form-add-category').serialize(),*/
                data: new FormData($('#form-add-category')[0]),
                cache: false,
                processData: false,
                contentType: false,
                success: function(data) {
                  if (data['error'] == 1) {
                      errorElem.empty();
                      errorElem.append('<li>' + data['message'] + '</li>');
                      // show error popup
                      $('#form-add-categories-content ul.error').removeClass('hidden');
                      // show hide form and loadding
                      $('#form-add-categories-content .categories-content').slideToggle();
                      $('#loading-action').slideToggle();
                      return;
                  }
                  // hide reveal
                  $('#form-add-categories-content .close').trigger('click');
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
                        errorElem.append('<li>Add Categories failed.</li>');
                    }
                    $('#form-add-categories-content ul.error').removeClass('hidden');
                      // show hide form and loadding
                    $('#form-add-categories-content .categories-content').slideToggle();
                    $('#loading-action').slideToggle();
                  }
            });
        });
  });
</script>
