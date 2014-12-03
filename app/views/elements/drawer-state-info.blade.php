<div class="drawer drawer-state-info" ng-hide="is_playing === true || activeStateIndex == -1 || showStateOverview === false">
    <div class="drawer-header clearfix">
        <h3 class="drawer-title pull-left">{[activeState.name]}</h3>
        <button type="button" class="close" ng-click="closeStateInfo()"><i class="ion-ios7-close" aria-hidden="true"></i><span class="sr-only">Close</span>
    </div>
    
    <div class="drawer-body">
        <dl class="dl-horizontal">
          <dt>Capital</dt>
          <dd>{[activeState.capital]}</dd>
          
          <dt>Area (sq mi)</dt>
          <dd>{[activeState.area_mi | number ]}</dd>
          
          <dt>Area (km sq)</dt>
          <dd>{[activeState.area_km | number]}</dd>
          
          <dt>Highest Point</dt>
          <dd>{[activeState.highest_point]}</dd>
          
          <dt>Highest Point (ft)</dt>
          <dd>{[activeState.highest_point_ft | number]}</dd>
          
          <dt>Highest Point (m)</dt>
          <dd>{[activeState.highest_point_m | number ]}</dd>
          
          <dt>Population</dt>
          <dd>{[activeState.population | number ]}</dd>
        </dl>
    </div>
    
    
</div>
