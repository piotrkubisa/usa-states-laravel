@extends('admin.master')

@section('body')
    @parent
    
    <div id="App">
        <div class="container">

        <div class="page-header">
            <div class="row">
                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                  <h2>Score <span class="text-muted">#{{ @$score['id'] }}</span></h2>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">

                    <div class="btn-group" style="margin-top: 15px; float: right;">
                        <a href="/admin/scores" class="btn btn-lg btn-default">Show all scores</a>
                    </div> 

                </div>                
            </div>
        </div>
        
        @if(isset($score))
        <div class="table-responsive" style="overflow-x: auto;">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Attribute</th>
                        <th>Value</th>
                    </tr>
                </thead>
                <tbody
                    @foreach($score->toArray() as $attr => $val)
                    <tr>
                        <td>{{ $attr }}</td>
                        <td>{{ $val }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif

    </div>
@stop
