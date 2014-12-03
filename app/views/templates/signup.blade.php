<?php $validation = Session::get('validation'); ?>
<?php $signupError = Session::get('signupError'); ?>
<?php $loginError = Session::get('loginError'); ?>
@extends('partials.page')

@section('content')
@parent
	<div class="fs-form-wrap " id="fs-form-wrap">
		<div class="fs-title">
			<h1><i class="ion ion-person-add"></i> Sign Up</h1>
			<a href="javascript:void(0)" onclick="window.history.back();return false;" title="Back"><i class="ion ion-ios7-arrow-back"></i></a>
            <a href="javascript:void(0)" ng-click="toggleLoginDialog()" title="Login"><i class="ion ion-log-in"></i></a>
		</div>
    @if(isset($signupError) && !empty($signupError))
        <div class="alert alerrt-danger">Encountered problem during signing up: {{ $signupError }}</div>
    @endif
    @if(isset($$loginError) && !empty($$loginError))
        <div class="alert alert-danger">Encountered problem during signing in: {{ $$loginError }}</div>
    @endif
		<form id="myform" name="myform" class="fs-form fs-form-full @if(isset($validation) && !empty($validation) && false) fs-form-overview @endif" autocomplete="off" method="POST" action="/auth/signup">
			<ol class="fs-fields">
				<li>
                    <div class="form-error" ng-show="errorUsernameMsg">{[ errorUsernameMsg ]}</div>
					<label class="fs-field-label fs-anim-upper" for="username">What's your name? <i class="ion-loading-c" ng-show="busyUsername"></i></label>
					<input class="fs-anim-lower" id="username" name="username" type="text" placeholder="John Doe" required unique-username ng-model="username" @if(Input::old("username"))ng-init="username = '{{ Input::old('username'); }}'"@endif/>
				</li>
				<li>
                    <div class="form-error" ng-show="myform.email.$error.email">Invalid email addresss.</div>
                    <div class="form-error" ng-show="errorEmailMsg">{[ errorEmailMsg ]}</div>
					<label class="fs-field-label fs-anim-upper" for="email" data-info="We won't send you spam, we promise...">What's your email address? <i class="ion-loading-c" ng-show="busyEmail"></i></label>
					<input class="fs-anim-lower" id="email" name="email" type="email" placeholder="john@doe.us" required unique-email ng-model="email" @if(Input::old("email"))ng-init="email = '{{ Input::old('email'); }}'"@endif />
				</li>
				<li>
                    <div class="form-error" ng-show="errorPasswordMsg">{[ errorPasswordMsg ]}</div>
                    <div class="form-error" ng-show="myform.password.$dirty && myform.password.$error.required">Please enter a password</div>
                    <div class="form-error" ng-show="myform.password_confirmation.$dirty && myform.password_confirmation.$error.required">Please repeat your password</div>
                    <div class="form-error" ng-show="myform.password_confirmation.$dirty && myform.password_confirmation.$error.match && !myform.password_confirmation.$error.required"> Passwords don't match or password is too short (min. 8 chars)</div>
					<label class="fs-field-label fs-anim-upper" for="password" data-info="Type your secret password (min. 8 chars long).">What's your password?</label>
					<input class="fs-anim-lower" id="password" name="password" type="password" placeholder="Password" required ng-model="password" match="confirmed" @if(Input::old("password"))ng-init="password = '{{ Input::old('password'); }}'"@endif/>
					<input class="fs-anim-lower" id="password_confirmation" name="password_confirmation" type="password" placeholder="Confirm password" required ng-model="confirmed" match="password" @if(Input::old("password_confirmation"))ng-init="confirmed = {{ Input::old('password_confirmation'); }}"@endif/>
				</li>
			</ol><!-- /fs-fields -->
			<button class="fs-submit" type="submit">Submit</button>
		</form><!-- /fs-form -->
	</div><!-- /fs-form-wrap -->
@stop


@section('app')
    @if(isset($validation) && !empty($validation)) ng-init="errorUsernameMsg = '<?php if(isset($validate['response']['username'])) { echo implode(" ", $validation['response']['username']); } ?>'; errorEmailMsg = '<?php if(isset($validation['response']['email'])) { echo implode(" ", $validation['response']['email']); } ?>'; errorPasswordMsg = '<?php if(isset($validation['response']['password'])) { echo implode(" ", $validation['response']['password']); } ?>';" @endif
@stop

