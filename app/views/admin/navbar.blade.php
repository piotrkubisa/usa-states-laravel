<nav class="navbar navbar-default navbar-static" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="{{ URL::to('/admin/dashboard') }}">AdminPanel</a>
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>

        <div class="collapse navbar-collapse navbar-ex1-collapse">
            <ul class="nav navbar-nav">
                <li @if($active === 'dashboard')class="active"@endif><a href="{{ URL::to('/admin/dashboard') }}">Dashboard</a></li>
                <li @if($active === 'scores')class="active"@endif><a href="{{ URL::to('/admin/scores') }}">Scores</a></li>
                <li @if($active === 'users')class="active"@endif><a href="{{ URL::to('/admin/users') }}">Users</a></li>
            </ul>
            
            <ul class="nav navbar-nav navbar-right">
                <li><a href="{{ URL::to('/') }}">View site</a></li>
                <li><a href="{{ URL::to('/admin/user/' . $user->id) }}">Signed as {{ $user->first_name }}</a></li>
                <li><a href="{{ URL::to('/auth/logout') }}"><i class="ion ion-log-out"></i></a></li>
            </ul>
        </div>
    </div>
</nav>