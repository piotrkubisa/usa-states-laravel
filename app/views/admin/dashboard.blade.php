@extends('admin.master')

@section('body')
    @parent
    
    <div id="App">
        <div class="container">

        <div class="page-header">
            <div class="row">
                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                  <h2>Dashboard</h2>                    
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">

                    <div class="btn-group" style="margin-top: 15px; float: right;">
                    </div> 
                    
                </div>                
            </div>
        </div>
            
            <style scoped>
                .panel-title {
                    font-size: 400%;
                }
            </style>
            
            <div class="col-xs-6 col-md-3 col-md-offset-3">
                <div class="panel status panel-success">
                    <div class="panel-heading">
                        <h1 class="panel-title text-center">{{ $userCount }}</h1>
                    </div>
                    <div class="panel-body text-center">                        
                        <a href="/admin/users"><strong>Users</strong></a>
                    </div>
                </div>
            </div>
            
            <div class="col-xs-6 col-md-3">
                <div class="panel status panel-info">
                    <div class="panel-heading">
                        <h1 class="panel-title text-center">{{ $scoreCount }}</h1>
                    </div>
                    <div class="panel-body text-center">                        
                        <a href="/admin/scores"><strong>Scores</strong></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

