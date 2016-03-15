@extends('layouts.admin.master')

@section('title', 'Dashboard')

@section('css')
	<link href="{{ asset("/plugins/datatables/dataTables.bootstrap.css") }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset("/css/skins/_all-skins.min.css") }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')

<div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <a href="{{ url('/admin/category/add') }}" id="add-categories" class="btn btn-lg btn-primary" data-toggle="modal" data-target="#addCategory"><i class="fa fa-plus"></i> Add</a>
          
          <div id="addCategory" class="modal fade">
              <div class="modal-dialog">
                  <div class="modal-content">
                      <!-- Content  file  -->
                  </div>
              </div>
          </div>
          <br>
          @if (session('status'))
              <div class="alert alert-success">
                  {{ session('status') }}
              </div>
          @endif
          <br>
          <!-- /.box-header -->
          <div class="box-body">
            <table id="example2" class="table table-bordered table-hover">
              <thead>
              <tr>
                <th>ID</th>
                <th>Parent ID</th>
                <th>Title</th>
                <th>Description</th>
                <th>Image</th>
                <th>Status</th>
                <th colspan="2" class="text-center"> Option</th>
              </tr>
              </thead>
              <tbody>
              @foreach( $category as $category)
                <tr>
                  <td>{{ $category->id }}</td>
                  <td>{{ $category->parent_id }}</td>
                  <td>{{ $category->title }}</td>
                  <td>{{ $category->description }}</td>
                  <td>{{ $category->image }}</td>
                  <td>{{ $category->status }}</td>
                  <td> <!-- edit -->
                      <a href="{{ url('/admin/category/edit/'.$category->id) }}" id="edit-categories-{{ $category->id }}" data-toggle="modal" data-target="#addCategory-{{ $category->id }}"><i class="fa fa-pencil"></i>Edit</a>
            
                      <div id="addCategory-{{ $category->id }}" class="modal fade">
                          <div class="modal-dialog">
                              <div class="modal-content">
                                  <!-- Content  file  -->
                              </div>
                          </div>
                      </div>

                  </td>
                  <td><a href="{{ url('/admin/category/destroy/' . $category->id) }}" onClick="return confirm('Delete This account?')"><i class="fa fa-times"></i>Delete</a></td>
                </tr>
              @endforeach
              </tbody>
              <tfoot>
              <tr>
                <th>ID</th>
                <th>Parent ID</th>
                <th>Title</th>
                <th>Description</th>
                <th>Image</th>
                <th>Status</th>
                <th colspan="3" class="text-center"> Option</th>
              </tr>
              </tfoot>
            </table>
          </div>
          <!-- /.box-body -->
        </div>
      </div>
    </div>
  </div>
<!-- /.box -->
@endsection