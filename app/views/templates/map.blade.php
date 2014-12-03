@extends('partials.page')

@section('content')
    @parent
    <div ng-usmap></div>

    <div id="HUD" ng-if="is_playing == true">
        <div class="points icon4x raleway">
            <span class="clicks">{[ statsCounter ]}</span>
            {[ points ]} / {[ targetPoints ]}
        </div>
        <div class="pointOut"> {[ pointOut ]} </div>
    </div>

    <button class="hide" id="empty" ng-click=""></button>
@stop

@section('navbar')
    <button type="button" class="btn btn-default navbar-btn" ng-click="Game.toggle()">
        <span ng-if="is_playing == false"><i class="ion ion-play"></i> Play a game</span>
        <span ng-if="is_playing == true"><i class="ion ion-stop"></i> Stop</span>
    </button>
    <button type="button" class="btn btn-default navbar-btn" title="Get a clue" ng-if="is_playing == true" ng-click="Game.getClue()">
        <i class="ion ion-help-buoy"></i>
        <span class="sr-only">Get a clue</span>
    </button>
@stop

@section('navbar-profile')
<li ng-show="!is_playing" ng-class="{true: 'active', false: ''}[settingsDialog === true]">
        <a href="javascript:void(0)" ng-click="toggleSettingsDialog()">
           <i class="ion ion-ios7-gear icon15"></i> Settings
        </a>
    </li>
    <li ng-if="is_playing == false" ng-class="{true: 'active', false: ''}[drawerStateList === true]">
        <a href="javascript:void(0)" ng-click="toggleStateList()">
            <i class="ion ion-ios7-toggle-outline icon15"></i> States list
        </a>
    </li>
@stop

@section('drawers')
    @parent
    @include('elements.drawer-states')
    @include('elements.drawer-state-info')
@stop

@section('wrapper') ng-class="{true: '', false: 'drawer-states-closed'}[drawerStateList == true]" @stop

@section('modals')
    @parent
    @include('elements.modal-settings')
@stop

@section('modals-ngshow') || settingsDialog @stop
