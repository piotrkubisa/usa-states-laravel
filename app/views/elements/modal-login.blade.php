<div class="dialog in" id="DialogLogin" ng-show="loginDialog">
    <div class="dialog-container dialog-sm">
        <div class="dialog-content">
            <div class="dialog-header">
                <button type="button" class="close" ng-click="toggleLoginDialog()"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                </button>
                <h4 class="dialog-title text-center">Login</h4>
            </div>
            <form class="form-horizontal" method="POST" action="/auth/login" autocomplete="off">
                <div class="dialog-body">
                    <div class="alert alert-danger" ng-show="loginError">{[ loginError ]}</div>
                    <div class="form-group form-group-lg has-feedback" style="margin-bottom: 0">
                        <div class="col-sm-12">
                            <input type="email" class="form-control" id="inputEmail" name="email" placeholder="Email">
                            <span class="ion ion-at form-control-feedback"></span>
                        </div>
                    </div>
                    <div class="form-group form-group-lg has-feedback">
                        <div class="col-sm-12">
                            <input type="password" class="form-control" id="inputPassword" name="password" placeholder="Password">
                            <span class="ion ion-key form-control-feedback"></span>
                        </div>
                    </div>
                    <div class="text-center text-sm">
                        <a ng-href="#/signup" ng-click="toggleLoginDialog()">Don't you have an account?</a>
                    </div>
                </div>
                <div class="dialog-footer">
                    <button class="btn btn-default pull-left" ng-click="toggleLoginDialog()" type="button">Close</button>
                    <button class="btn btn-primary" type="submit">Sign in</button>
                </div>
            </form>
        </div>
    </div>
</div>