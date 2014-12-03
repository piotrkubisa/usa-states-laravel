<h3>View</h3>
<div class="table-responsive" style="overflow-x: auto;">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>Attribute</th>
                <th>Value</th>
            </tr>
        </thead>
        <tbody
            @foreach($usr->toArray() as $attr => $val)
            <tr>
                <td>{{ $attr }}</td>
                <td>{{ $val }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
