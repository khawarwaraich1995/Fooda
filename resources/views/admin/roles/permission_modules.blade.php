@extends('layouts.app', ['title' => __('Permission Modules')])

@section('content')
@include('users.partials.header', [
'title' => __('Permission Modules'),
'class' => 'col-lg-12',
])
<?php
//print_r($permissions);exit;
      if (isset($role_id) && $role_id != 0) {
          $submit_url = route('admin:permissions-modules.update', [$role_id ?? '']);
      }
    ?>
<div class="container-fluid mt--7">
  <div class="row">
    <div class="col-xl-12 col-md-12 col-sm-12 order-xl-1">
      <div class="card bg-secondary shadow">
        <div class="card-header bg-white border-0">
          <div class="row align-items-center">
            <h3 class="col-12 mb-0">{{ __('Permission Modules Form') }}</h3>
          </div>
        </div>
        <div class="card-body">
          <form id="roles_form" method="post" action="{{$submit_url}}" enctype="multipart/form-data">
            @csrf
            <fieldset>
              <h6 class="heading-small text-muted mb-4">Assign Permissions to Roles</h6>
              <div class="row">
              @foreach($permissions_list as $key => $value)
                <div class="col-lg-3 col-md-3 offset-md-1">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" name="modules[]" value="{{$value}}" id="{{$value}}"
                         <?php if(isset($permissions) && !empty($permissions)) { if(in_array($value, $permissions)){ echo "checked"; } } ?> >
                        <label class="custom-control-label" for="{{$value}}">{{$value}}</label>
                    </div>
                </div>
               @endforeach 
              </div>
            </fieldset>

            <br>
            <div class="row">
            <div class="col-lg-2 col-md-2">
                <a class="btn btn-icon btn-success" href="{{route('admin:roles')}}" id="back">
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