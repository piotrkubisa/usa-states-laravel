@extends('partials.page')

@section('content')
@parent
  <div class="container-fluid">
  	<div class="col-lg-6 col-md-8 col-sm-10 col-xs-12 col-lg-offset-3 col-md-offset-2 col-sm-offset-1 col-xs-offset-0">
  		<header>
  			<div class="top-icon">
  				<i class="ion ion-podium"></i>
  			</div>
  			<h1>Highscores</h1>
  			<h2>The best results in three categories.</h2>
            <div class="score-tabs">
                <ul class="nav nav-pills">
                  <li role="presentation" ng-class="{true: 'active', false: ''}[tabId == 0]" ng-click="tabId = 0"><a href="javascript:void(0)">5</a></li>
                  <li role="presentation" ng-class="{true: 'active', false: ''}[tabId == 1]" ng-click="tabId = 1"><a href="javascript:void(0)">10</a></li>
                  <li role="presentation" ng-class="{true: 'active', false: ''}[tabId == 2]" ng-click="tabId = 2"><a href="javascript:void(0)">50</a></li>
                </ul>
            </div>
  		</header>
        <table class="table">
            <tbody ng-repeat="(cat, scorecat) in scores" ng-show="tabId == $index" ng-class="cat">
                <tr ng-repeat="score in scorecat">
                    <td class="col-sm-1">
                        <img ng-src="{[ score.avatar ]}" alt="Img">
                    </td>
                    <td>
                        <span class="value">{[ score.username ]}</span>
                        <span class="help-block">{[ score.created_at | date:'dateFormat' ]}</span>
                    </td>
                    <td>
                        <span class="value">{[ score.guesses ]}</span>
                        <span class="help-block">guesses</span>
                    </td>
                    <td>
                        <span class="value">{[ score.time_diff ]}</span>
                        <span class="help-block">time</span>
                    </td>
                </tr>

            </tbody>
        </table>
  	</div>
  </div>
@stop

@section('navbar')
    <ul class="nav navbar-nav">
        <li><a href="javascript:void(0)" ng-click="toggleDownloadDialog()"><i class="ion ion-ios7-cloud-download icon15"></i> Export scores</a></li>
    </ul>
@stop

@section('modals')
    @parent
    @include('elements.modal-downloadfile')
@stop

@section('modals-ngshow') || downloadDialog @stop