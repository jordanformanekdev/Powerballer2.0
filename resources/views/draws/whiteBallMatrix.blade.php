<div class="container-fluid matrixPanel ">
    <table class="drawTable">
        <th class="drawTableHeader" colspan="5">
            White Balls
        </th>

        <?php $count = $whiteBallMatrix['wVal'] ?>

        @for ($a = 0; $a < $count; $a++)
            <tr>
                @for ($i = 0; $i < 5; $i++)
                    @if (in_array($whiteBallMatrix['wVal'], $whiteBallMatrix['whiteBalls']))
                        <td class="drawTableCellBlue">
                            {{ $whiteBallMatrix['wVal'] }}
                        </td>
                    @else
                        <td class="drawTableCellGrey">
                            {{ $whiteBallMatrix['wVal'] }}
                        </td>
                    @endif
                    <?php $whiteBallMatrix['wVal'] = $whiteBallMatrix['wVal'] + $count ?>
                @endfor
                <?php $whiteBallMatrix['wVal'] = $whiteBallMatrix['wVal'] - $whiteBallMatrix['wSize'] ?>
            </tr>
        @endfor
    </table>
</div>