@extends('partials.page')

@section('content')
    @parent
    <header>
        <div class="container">
            <div class="top text-center">
                <h1><span>States of <em class="flag-red2">U</em><em class="flag-white">S</em><em class="flag-blue">A</em></span></h1>
                <h2>Made by Piotr Kubisa</h2>
                <a class="btn btn-mine btn-lg" role="button" ng-href="#/map"><i class="ion ion-map"></i> Map</a>
            </div>
        </div>
    </header>
@stop

@section('drawers')
    @parent
@stop