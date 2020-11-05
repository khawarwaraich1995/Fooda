@extends('layouts.app', ['title' => __('Settings')])

@section('content')
@include('users.partials.header', [
'title' => __('Admin Settings'),
'class' => 'col-lg-12',
])
<?php
      if (isset($settings[0]['id']) && $settings[0]['id'] != 0) {
          $submit_url = route('admin:settings.update-uploads', [$settings[0]['id'] ?? '']);
      } else {
          $submit_url = route('admin:settings.add-uploads');
      }
    ?>
<div class="container-fluid mt--7">
  <div class="row">
    <div class="col-xl-12 col-md-12 col-sm-12 order-xl-1">
      <div class="card bg-secondary shadow">
        <div class="container mb-3">
        <div class="nav-wrapper">
    <ul class="nav nav-pills nav-fill flex-column flex-md-row" id="tabs-icons-text" role="tablist">
        <li class="nav-item">
            <a class="nav-link mb-sm-3 mb-md-0 active" id="tabs-icons-text-1-tab" data-toggle="tab" href="#admin-media" role="tab" aria-controls="tabs-icons-text-1" aria-selected="true"><i class="ni ni-cloud-upload-96 mr-2"></i>Admin Images/Uploads</a>
        </li>
        <li class="nav-item">
            <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-2-tab" data-toggle="tab" href="#tabs-icons-text-2" role="tab" aria-controls="tabs-icons-text-2" aria-selected="false"><i class="ni ni-bell-55 mr-2"></i>Admin Content & Color Scheme</a>
        </li>
    </ul>
</div>
<div class="card shadow">
    <div class="card-body">
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="admin-media" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab">
                <form action="{{$submit_url}}" method="post" enctype="multipart/form-data">
                @csrf
               <div class="row">
                    <div class="col-lg-4 col-md-4 text-center">
                        <label style="font-weight: bold;">Admin Logo</label>
                        <div style="display: flex;justify-content: center;">
                            <input type="file" name="admin_logo" class="dropify" data-default-file=""/>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-4 text-center">
                        <label style="font-weight: bold;">Admin Fav Icon</label>
                        <div style="display: flex;justify-content: center;">
                            <input type="file" name="admin_favicon" class="dropify" data-default-file=""/>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-4 text-center">
                        <label style="font-weight: bold;">Admin Cover Image</label>
                        <div style="display: flex;justify-content: center;">
                            <input type="file" name="admin_cover" class="dropify" data-default-file=""/>
                        </div>
                    </div>
               </div>
               <br>
               <div class="row">
            <div class="col-lg-2 col-md-2">
                <a class="btn btn-icon btn-primary" href="{{URL::previous()}}" id="back">
                  <span class="btn-inner--icon"><i class="ni ni-bold-left"></i></span>
                  <span class="btn-inner--text">Back</span>
                </a>
              </div>
              <div class="col-lg-2 col-md-2 offset-lg-8">
                <button class="btn btn-icon btn-primary" type="submit" id="save">
                  <span class="btn-inner--icon"><i class="ni ni-check-bold"></i></span>
                  <span class="btn-inner--text">Upload</span>
                </button>
              </div>

            </div>
                </form>
            </div>
            
            
            <!-- <div class="tab-pane fade" id="tabs-icons-text-2" role="tabpanel" aria-labelledby="tabs-icons-text-2-tab">
               
            </div>
            <div class="tab-pane fade" id="tabs-icons-text-3" role="tabpanel" aria-labelledby="tabs-icons-text-3-tab">
                
            </div> -->
        </div>
    </div>
</div>
        </div>
      </div>
    </div>
  </div>

  @include('layouts.footers.auth')
</div>
@endsection