<h3>Permissions</h3>

<form class="form-horizontal" role="form" method="POST">
    
    @foreach($permissions as $pm_group => $pm_groupVal)
        <h4>{{ studly_case($pm_group) }}</h4>
        <div class="well">
        @foreach($pm_groupVal as $pm_area => $pm_areaVal)
            <h5>{{ studly_case($pm_area) }}</h5>
            @foreach($pm_areaVal as $pm)
            <?php
                $pm_path = $pm_group.'.'.$pm_area.'.'.$pm;
                $hasAccess = isset($perms[$pm_path]) ? $perms[$pm_path] : 0;
            ?>
            <div class="form-group">
                <label for="permission{{ studly_case($pm_path) }}" class="col-sm-2 control-label">{{ $pm }}</label>
                <div class="col-sm-10">
                    <select class="form-control" name="{{ $pm_path }}" id="permission{{ studly_case($pm_path) }}">
                        <option value="-1" @if($hasAccess=="-1")selected @endif>Deny</option>
                        <option value="1" @if($hasAccess=="1")selected @endif>Allow</option>
                        <option value="0" @if($hasAccess=="0")selected @endif>Inherit</option>
                    </select>
                    <span class="help-block">Merged value (before change): <span class="label label-primary">@if(isset($permsMerged[$pm_path]) && $permsMerged[$pm_path]=="1")Allowed @else Denied @endif</span></span>
                </div>
            </div>
            @endforeach
        @endforeach
        </div>
    @endforeach

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-primary" name="action" value="grantPermissions">Submit</button>
        </div>
    </div>
</form>


