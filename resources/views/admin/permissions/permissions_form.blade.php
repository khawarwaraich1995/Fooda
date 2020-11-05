@extends('layouts.app', ['title' => __('Permissions')])

@section('content')
@include('users.partials.header', [
'title' => __('Add New Permissions'),
'class' => 'col-lg-12',
])
<?php
      if (isset($permissions[0]['id']) && $permissions[0]['id'] != 0) {
          $submit_url = route('admin:permissions.update', [$permissions[0]['id'] ?? '']);
      } else {
          $submit_url = route('admin:permissions.add');
      }
    ?>
<div class="container-fluid mt--7">
  <div class="row">
    <div class="col-xl-12 col-md-12 col-sm-12 order-xl-1">
      <div class="card bg-secondary shadow">
        <div class="card-header bg-white border-0">
          <div class="row align-items-center">
            <h3 class="col-12 mb-0">{{ __('Permissions Form') }}</h3>
          </div>
        </div>
        <div class="card-body">
          <form id="permission_form" method="post" action="{{$submit_url}}" enctype="multipart/form-data">
            @csrf
            <fieldset>
              <h6 class="heading-small text-muted mb-4">Permissions</h6>
              <div class="row">
                <div class="col-lg-4 col-md-4 offset-md-4">
                  <div class="form-group">
                    <label class="form-control-label"><span class="required-icon">* </span>Permissions Modules</label>
                    <textarea class="form-control alternative" name="json_permissions" id="json_permissions" rows="10">{{$permissions[0]['permissions_name']}}</textarea>
                  </div>
                </div>
              </div>
            </fieldset>
            <div class="row">
            <div class="col-lg-2 col-md-2">
                <a class="btn btn-icon btn-success" href="{{route('admin:home')}}" id="back">
                  <span class="btn-inner--icon"><i class="ni ni-bold-left"></i></span>
                  <span class="btn-inner--text">Back</span>
                </a>
              </div>
              <div class="col-lg-2 col-md-2 offset-lg-8">
                <button class="btn btn-icon btn-success" type="submit" id="save">
                  <span class="btn-inner--icon"><i class="ni ni-check-bold"></i></span>
                  <span class="btn-inner--text">Save</span>
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  @include('layouts.footers.auth')
</div>
@endsection