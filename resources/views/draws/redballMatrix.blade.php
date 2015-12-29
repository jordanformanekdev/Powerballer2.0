<div class="container-fluid matrixPanel ">
    <table class="drawTable">
        <th class="drawTableHeader" colspan="5">
            Powerball
        </th>

        <?php $count = $redBallMatrix['wVal'] ?>

        @for ($a = 0; $a < $count; $a++)
            <tr>
                @for ($i = 0; $i < 5; $i++)
                    @if ($redBallMatrix['wVal'] == $redBallMatrix['powerball'])
                        <td class="drawTableCellRed">
                            {{ $redBallMatrix['wVal'] }}
                        </td>
                    @else
                        <td class="drawTableCellGrey">
                            {{ $redBallMatrix['wVal'] }}
                        </td>
                    @endif
                    <?php $redBallMatrix['wVal'] = $redBallMatrix['wVal'] + $count ?>
                @endfor
                <?php $redBallMatrix['wVal'] = $redBallMatrix['wVal'] - $redBallMatrix['wSize'] ?>
            </tr>
        @endfor
    </table>
</div>