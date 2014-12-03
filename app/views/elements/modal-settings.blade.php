<div class="dialog in" id="DialogSettings" ng-show="settingsDialog">
    <div class="dialog-container">
        <div class="dialog-content">
            <div class="dialog-header">
                <button type="button" class="close" ng-click="toggleSettingsDialog()"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                </button>
                <h4 class="dialog-title text-center">Settings</h4>
            </div>
            <div class="dialog-body">
                <h5>Preview</h5>
                <div class="row">
                    <div class="col-sm-11 col-sm-offset-1">
                        <div class="checkbox" style="margin-top: 0">
                            <label for="stateOverview">
                                <input type="checkbox" value="1" name="stateOverview" id="stateOverview" ng-model="showStateOverview">
                                Open State overview viewport
                            </label>
                        </div>
                    </div>
                </div>
                
                <h5>Game</h5>
                <div class="row">
                    <div class="col-sm-11 col-sm-offset-1">
                        <label for="targetPoints" style="font-weight: 400">How many states (random) you would like to point out:</label>
                        <select class="form-control" name="targetPoints" id="targetPoints" ng-model="targetPoints">
                            <option>5</option>
                            <option>10</option>
                            <option>50</option>
                        </select>
                    </div>
                </div>
                
                <div class="clearfix visible-xs-block"></div>
            </div>
            <div class="dialog-footer">
                <button class="btn btn-success" ng-click="toggleSettingsDialog()" type="button">Save &amp; Close</button>
            </div>
        </div>
    </div>
</div>
