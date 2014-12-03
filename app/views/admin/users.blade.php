@extends('admin.master')

@section('body')
    @parent
    
    <div id="App">
        <div class="container">

        <div class="page-header">
            <div class="row">
                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                  <h2>Users</h2>                    
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
                        <?php $link = '/admin/users' . "?page=" . $users->getCurrentPage(); ?>
                        <th class="col-sm-1 text-right"><a href="{{ $link."&orderBy=users.id"."&order_type=".((int)!Input::get('order_type')) }}"># <i class="ion ion-arrow-down-b"></i></a></th>
                        <th><a href="{{ $link."&orderBy=users.email"."&order_type=".((int)!Input::get('order_type')) }}">User <i class="ion ion-arrow-down-b"></i></a></th>
                        <th>Groups</th>
                        <th class="w100 text-center"><a href="{{ $link ."&orderBy=users.activated"."&order_type=".((int)!Input::get('order_type')) }}">Activated <i class="ion ion-arrow-down-b"></i></a></th>
                        <th><a href="{{ $link."&orderBy=users.last_login"."&order_type=".((int)!Input::get('order_type')) }}">Recent login <i class="ion ion-arrow-down-b"></i></a></th>
                        <th>Actions</th>
                    </tr>
                    <form method="GET" action="/admin/users">
                        <tr>
                            <th class="col-sm-1"><input type="number" name="filterUser" id="filterUser" class="form-control" title="ID" value="{{ Input::get('filterUser') }}"></th>
                            <th><input type="text" name="filterUsername" id="filterUser" class="form-control" value="{{ Input::get('filterUsername') }}" title="User"></th>
                            <th>
                                <select name="filterGroup" id="filterGroup" class="form-control">
                                    <option>--</option>
                                @foreach($groups as $group)
                                    <option value="{{ $group->id }}" @if(Input::get('filterGroup')==$group->id)selected @endif>{{ $group->name }}</option>
                                @endforeach
                                </select>
                            </th>
                            <th>
                                <select name="filterActive" id="filterActive" class="form-control" title="Activated">
                                    <option @if(Input::get('filterActive') == null)selected @endif>--</option>
                                    <option value="1" @if(Input::get('filterActive')=="1")selected @endif>Yes</option>
                                    <option value="0" @if(Input::get('filterActive')=="0")selected @endif>No</option>
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
                    <?php foreach ($users as $usr): ?>
                    <?php $usr_link = '/admin/user/' .$usr->id; ?>
                    <tr style="cursor: pointer;">
                        <td class="col-sm-1 text-right" onclick="(window.location = '')">{{ $usr->id }}</td>
                        <td onclick="(window.location = '{{ $usr_link }}')">{{ $usr->first_name }}</td>
                        <td onclick="(window.location = '{{ $usr_link }}')">{{ $usr->groups->implode('name', ', ') }}</td>
                        <td class="col-sm-1 text-center">
                            <a href="{{ $usr_link . '/activate' . "?value=" . (int)(!(int)$usr->activated) }} }}" class="btn btn-sm @if($usr->activated)btn-success @else btn-danger @endif">
                                @if ($usr->activated)<i class="ion-checkmark-round"></i>@else<i class="ion-close-round"></i>@endif
                            </a>
                        </td>
                        <td onclick="(window.location = '{{ $usr_link }}')">{{ $usr->last_login }}</td>
                        <td class="text-align:right;">
                            <!-- Split button -->
                            <div class="btn-group pull-right">
                              <a href="{{ $usr_link }}" class="btn btn-primary"><i class="ion ion-eye"></i> View</a>
                              <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                <span class="caret"></span>
                                <span class="sr-only">Schowaj</span>
                              </button>
                              <ul class="dropdown-menu" role="menu">
                                <li>
                                  <a href="{{ $usr_link . '/delete' }}" data-method="confirm" data-content="Are you sure? (User: &quot;{{ $usr->first_name }}&quot;)">
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
            {{ $users->links() }}
        </div>
            
    </div>
@stop
