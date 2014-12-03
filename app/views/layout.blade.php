<!DOCTYPE html>
<html lang="en-US" ng-app="ustateApp">
    <head>
        <title>USA</title>

        <meta charset="utf-8">
        <meta name="description" content="">
        <meta name="author" content="Piotr Kubisa">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />

        <!-- CSS -->
        @section('assets_top')
        @include('partials.assets_top')
        @show
    </head>
    <body>


        <div class="view-container">
            <div class="spinner">
              <div class="dot1"></div>
              <div class="dot2"></div>
            </div>

            <div ng-view class="view-frame view{[ sectionId ]}">
            @yield('app')
            </div>
        </div>

        @section('assets_bottom')
        @include('partials.assets_bottom')
        @show
    </body>
</html>