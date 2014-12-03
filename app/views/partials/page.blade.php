<section id="Wrapper" @yield('wrapper')>
    <div class="back-top-menu">
		<nav class="navbar-right">
			@if(isset($user) && !empty($user))
		@if($user->inGroup(Sentry::findGroupByName('Admins')))
			<a href="/admin" class="link-bare"><i class="ion ion-gear-a"></i> Settings</a>
		@endif
			<a href="/auth/logout" class="link"><i class="ion ion-log-out"></i> Logout</a>
			@else
			<a ng-href="#/signup" class="link"><i class="ion ion-person-add"></i> Sign up</a>
			<a href="javascript:void(0)" ng-click="toggleLoginDialog()" class="link-more"><i class="ion ion-log-in"></i> Log in</a>
			@endif
			<a href="javascript:void(0)" class="link-bare" ng-click="usermenu()"><i class="ion ion-close-round"></i> Close</a>
		</nav>
    	@yield('back-top-menu')
    </div>
    
    <div class="back-left-menu">
        <nav class="bm-links1">
			<a ng-href="#/"><i class="ion ion-ios7-home"></i> Intro</a>
			<a ng-href="#/map"><i class="ion ion-map"></i> Map</a>
			<a ng-href="#/highscores"><i class="ion ion-podium"></i> Highscores</a>
		</nav>
    </div>
    
    <div id="App" @yield('app')>
		@section('content')
			<nav class="navbar navbar-default navbar-static-top" role="navigation">
			  <div class="container-fluid">
			    <button type="button" class="navbar-toggle navbar-left btn" ng-click="reveal()">
			        <span class="sr-only">Toggle navigation</span>
			        <span class="icon-bar first"></span>
			        <span class="icon-bar second"></span>
			        <span class="icon-bar third"></span>
			     </button>

			     @yield('navbar')

			    <div class="navbar-header">
			    	<a class="navbar-brand" href="#">
			        	USA
			    	</a>
			    </div>

			    <ul class="nav navbar-nav navbar-right navbar-profile">
			     	@yield('navbar-profile')
			        <li class="navbar-profilemenu">
			        	<a href="javascript:void(0)" ng-click="usermenu()">
				        	<img src="img/av.png"> @if(isset($user) && !empty($user)) {{ $user['first_name'] }} @else Guest  @endif <span class="caret"></span>
			        	</a>
			        </li>
			    </ul>
			  </div>
			</nav>
		@show
    </div>

    @yield('drawers')
    
</section>

@section('modals')
    @include('elements.modal-login')
@show
<div class="dialog-backdrop in" ng-show="loginDialog @yield('modals-ngshow')"></div>
