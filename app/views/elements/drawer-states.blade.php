<div class="drawer drawer-states" ng-if="is_playing == false">
    <div class="drawer-states-search">
        <form class="form-inline" role="form" onsubmit="javascript:void(0)">                      
            <div class="form-group">
                <label class="sr-only" for="">Search</label>
                <input type="search" class="form-control" id="searchState" placeholder="..." ng-model="searchState">
            </div>                      
            <button class="btn" ng-click="toggleStateList()">
                <i class="icon icon-close"></i>                    
            </button>
        </form>
    </div>
    <div class="drawer-states-list">
        <div class="list-group">
            <a ng-repeat="state in States | filter:{name: searchState} | orderBy: 'name' " id="StateAnchor{[state.id]}" ng-animate="'animate'" class="list-group-item" href="javascript:void(0)" ng-click="selectState($event, state.id)">{[state.name]}</a>
        </div>
    </div>
</div>