@servers(['web' => '192.168.1.1'])

@task('getDraws', ['on' => 'web'])
    curl "http://www.powerball.com/powerball/winnums-text.txt" >> /public/lotto.txt
@endtask
