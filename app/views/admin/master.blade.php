<!DOCTYPE html>
<html lang="">
    <head>
        <title>USA - @section('title')Admin Panel@show</title>

        <meta charset="utf-8">
        <meta name="description" content="">
        <meta name="author" content="Piotr Kubisa">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />

        <!-- CSS -->
        @section('assets_top')
		<link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="/components/ionicons/css/ionicons.min.css">
		<link rel="stylesheet" type="text/css" href="/components/sweetalert/lib/sweet-alert.css">
		<link rel="stylesheet" type="text/css" href="/less/adminapp.css">
        @show
    </head>
    <body>

        @section('body')
            @include('admin.navbar')
            @include('admin.alerts')
        @show

        @section('assets_bottom')
        <script src="/components/jquery/dist/jquery.js"></script>
		<script src="/components/bootstrap/dist/js/bootstrap.js"></script>
		<script src="/components/sweetalert/lib/sweet-alert.js"></script>
        @show
    </body>
</html>