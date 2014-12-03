@extends('admin.master')

@section('body')
    @parent
    
    <div id="App">
        <div class="container">

        <div class="page-header">
            <div class="row">
                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                  <h2>Scores</h2>                    
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">

                    <div class="btn-group" style="margin-top: 15px; float: right;">
                    </div> 
                    
                </div>                
            </div>
        </div>
        
        <div class="table-responsive" style="overflow-x: auto;">
            <table class="table table-striped table-hover">
              <thead>
                    <tr>
                        <?php $link = '/admin/scores' . "?page=" . $scores->getCurrentPage(); ?>
                        <th class="col-sm-1 text-right"><a href="{{ $link."&orderBy=scores.id"."&order_type=".((int)!Input::get('order_type')) }}"># <i class="ion ion-arrow-down-b"></i></a></th>
                        <th><a href="{{ $link."&orderBy=scores.user_id"."&order_type=".((int)!Input::get('order_type')) }}">User <i class="ion ion-arrow-down-b"></i></a></th>
                        <th><a href="{{ $link."&orderBy=scores.guesses"."&order_type=".((int)!Input::get('order_type')) }}">Guesses <i class="ion ion-arrow-down-b"></i></a></th>
                        <th><a href="{{ $link ."&orderBy=scores.points_to_check"."&order_type=".((int)!Input::get('order_type')) }}">States to point out</a> <i class="ion ion-arrow-down-b"></i></a></th>
                        <th><a href="{{ $link."&orderBy=scores.created_at"."&order_type=".((int)!Input::get('order_type')) }}">Created at <i class="ion ion-arrow-down-b"></i></a></th>
                        <th>Actions</th>
                    </tr>
                    <form method="GET" action="/admin/scores">
                        <tr>
                            <th class="col-sm-1"><input type="number" name="filterId" id="filterId" class="form-control" title="ID" value="{{ Input::get('filterId') }}"></th>
                            <th><input type="text" name="filterUsername" id="filterUsername" class="form-control" value="{{ Input::get('filterUsername') }}" title="User"></th>
                            <th></th>
                            <th>
                                <select name="filterTargetPoints" id="filterTargetPoints" class="form-control" title="States to point out">
                                    <option @if(Input::get('filterTargetPoints') == null)selected @endif>--</option>
                                    <option value="5" @if(Input::get('filterTargetPoints')=="5")selected @endif>5</option>
                                    <option value="10" @if(Input::get('filterTargetPoints')=="10")selected @endif>10</option>
                                    <option value="50" @if(Input::get('filterTargetPoints')=="50")selected @endif>50</option>
                                </select>
                            </th>
                            <th colspan="2">
                                <div class="btn-group pull-right">
                                    <button type="submit" name="actionFilter" class="btn btn-default" title="Szukaj"><i class="ion ion-funnel"></i> Filter</button>
                                    <button type="submit" name="actionResetFilter" class="btn btn-default" title="Clear"><i class="ion ion-close-round"></i> Clear</button>
                                </div>
                            </th>
                        </tr>
                    </form>
                </thead>
                <tbody>
                    <?php foreach ($scores as $score): ?>
                    <?php $score_link = '/admin/score/' .$score->id; ?>
                    <tr style="cursor: pointer;">
                        <td class="col-sm-1 text-right" onclick="(window.location = '')">{{ $score->id }}</td>
                        <td><a href="{{ URL::to('/admin/user/' . $score->user_id) }}">{{ $score->first_name }}</a></td>
                        <td class="text-right" onclick="(window.location = '{{ $score_link }}')">{{ $score->guesses }} </td>
                        <td class="text-right" onclick="(window.location = '{{ $score_link }}')">{{ $score->points_to_check }}</td>
                        <td onclick="(window.location = '{{ $score_link }}')">{{ $score->created_at }}</td>
                        <td class="text-align:right;">
                            <div class="btn-group pull-right">
                              <a href="{{ $score_link }}" class="btn btn-primary"><i class="ion ion-eye"></i> View</a>
                              <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                <span class="caret"></span>
                                <span class="sr-only">Schowaj</span>
                              </button>
                              <ul class="dropdown-menu" role="menu">
                                <li>
                                  <a href="{{ $score_link . '/delete' }}" data-method="confirm" data-content="Are you sure? (Score: #{{ $score->id }})">
                                    <i class="ion ion-trash-a"></i> Delete
                                 </a>
                                </li>
                              </ul>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
        
        <div class="text-center">
            {{ $scores->links() }}
        </div>
            
    </div>
@stop
