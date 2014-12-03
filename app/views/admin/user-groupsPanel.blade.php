<h3>User groups</h3>
<div class="table-responsive" style="overflow-x: auto;">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th class="col-md-1">Attribute</th>
                <th>Value</th>
            </tr>
        </thead>
        <tbody>
            @foreach($usr->groups->toArray() as $attr => $val)
            <tr>
                <td class="col-md-1">{{ $attr }}</td>
                <td>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Attribute</th>
                                <th>Value</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($val as $dt => $dd)
                            @if(is_string($dd))
                            <tr>
                                <td>{{ $dt }}</td>
                                <td>{{ $dd }}</td>
                            </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Assign current user to group</h3>
    </div>
    <div class="panel-body">
        <form class="form-horizontal" role="form" method="POST">
            <div class="form-group">
                <label for="groupIdAssign" class="col-sm-2 control-label">Group</label>
                <div class="col-sm-10">
                    <select class="form-control" name="groupIdAssign" id="groupIdAssign">
                    @foreach($groups as $group)
                        <option value="{{ $group->id }}">{{ $group->name }}</option>
                    @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-success" name="action" value="assignToGroup">Assign to group</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Remove current user from group</h3>
    </div>
    <div class="panel-body">
        <form class="form-horizontal" role="form" method="POST">
            <div class="form-group">
                <label for="groupId" class="col-sm-2 control-label">Group</label>
                <div class="col-sm-10">
                    <select class="form-control" name="groupIdRemove" id="groupIdRemove">
                    @foreach($usr->groups as $group)
                        <option value="{{ $group->id }}">{{ $group->name }}</option>
                    @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-danger" name="action" value="removeFromGroup">Remove from group</button>
                </div>
            </div>
        </form>
    </div>
</div>