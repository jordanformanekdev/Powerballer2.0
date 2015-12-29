<div class="container-fluid drawInfoPanel ">
    <table class="table table-responsive drawInfoTable">
        <tr class="drawInfoTableRow">
            <th colspan="3" class="drawInfoTableHeader">Draw Info</th>
        </tr>
        @foreach($drawInfo as $key => $info)
            <tr class="drawInfoTableRow">
                <td class="drawInfoTableCell">{{$key}}</td>
                <td class="drawInfoTableCell">:</td>
                <td class="drawInfoTableCell">{{$info}}</td>
            </tr>
        @endforeach
        <tr class="drawInfoButtons">
            <td>
                <a href="/draws/next/{{$drawInfo['Draw ID']}}"> Next </a>
            </td>
            <td>
                <a href="/draws/notes/#"> Notes </a>
            </td>
            <td>
                <a href="/draws/prev/{{$drawInfo['Draw ID']}}"> Prev </a>
            </td>
        </tr>
    </table>

</div>