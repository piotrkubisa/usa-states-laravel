@extends('admin.master')

@section('body')
    @parent
    
    <div id="App">
        <div class="container">

        <div class="page-header">
            <div class="row">
                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                  <h2>User <span class="text-muted">{{ @$usr['first_name'] }}</span></h2>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">

                    <div class="btn-group" style="margin-top: 15px; float: right;">
                        <a href="/admin/users" class="btn btn-lg btn-default">Show all users</a>
                    </div> 

                </div>                
            </div>
        </div>
        
        @if(isset($usr))
        <div class="row">
            <div class="col-md-3 col-lg-2">
                <ul class="nav nav-pills nav-stacked">
                    <li role="presentation" class="active"><a href="#view" aria-controls="settings" role="tab" data-toggle="tab">View</a></li>
                    <li role="presentation"><a href="#groups" aria-controls="settings" role="tab" data-toggle="tab">User groups</a></li>
                    <li role="presentation"><a href="#permissions" aria-controls="settings" role="tab" data-toggle="tab">Permissions</a></li>
                </ul>
            </div>
            <div class="col-md-9 col-lg-10">
                
                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="view">@include('admin.user-viewPanel')</div>
                    <div role="tabpanel" class="tab-pane" id="groups">@include('admin.user-groupsPanel')</div>
                    <div role="tabpanel" class="tab-pane" id="permissions">@include('admin.user-permissionsPanel')</div>
                    <div role="tabpanel" class="tab-pane" id="settings">...</div>
                </div>

                
            </div>
        </div>
        @endif

    </div>
@stop
