<?php
namespace rosasurfer\rt\synthetic\index;

use rosasurfer\exception\IllegalTypeException;

use rosasurfer\rt\synthetic\AbstractSynthesizer;
use rosasurfer\rt\synthetic\SynthesizerInterface as Synthesizer;


/**
 * ZARFX7 synthesizer
 *
 * A {@link Synthesizer} for calculating the South African Rand FX7 index. Due to the Rand's low value the index is scaled-up
 * by a factor of 10. This adjustment only effects the nominal scala, not the shape of the ZAR index chart.
 *
 * <pre>
 * Formulas:
 * ---------
 * ZARFX7 = 10 * USDLFX / USDZAR
 * ZARFX7 = 10 * pow(USDCAD * USDCHF *USDJPY / (AUDUSD * EURUSD * GBPUSD), 1/7) / USDZAR
 * ZARFX7 = 10 * pow(ZARJPY / (AUDZAR * CADZAR * CHFZAR * EURZAR * GBPZAR * USDZAR), 1/7)
 * </pre>
 */
class ZARFX7 extends AbstractSynthesizer {


    /** @var string[][] */
    protected $components = [
        'fast'    => ['USDLFX', 'USDZAR'],
        'majors'  => ['AUDUSD', 'EURUSD', 'GBPUSD', 'USDCAD', 'USDCHF', 'USDJPY', 'USDZAR'],
        'crosses' => ['AUDZAR', 'CADZAR', 'CHFZAR', 'EURZAR', 'GBPZAR', 'USDZAR', 'ZARJPY'],
    ];


    /**
     * {@inheritdoc}
     */
    public function calculateQuotes($day) {
        if (!is_int($day)) throw new IllegalTypeException('Illegal type of parameter $day: '.getType($day));

        if (!$symbols = $this->loadComponents(first($this->components)))
            return [];
        if (!$day && !($day = $this->findCommonHistoryM1Start($symbols)))   // if no day was specified find the oldest available history
            return [];
        if (!$this->symbol->isTradingDay($day))                             // skip non-trading days
            return [];
        if (!$quotes = $this->loadComponentHistory($symbols, $day))
            return [];

        // calculate quotes
        echoPre('[Info]    '.$this->symbolName.'  calculating M1 history for '.gmDate('D, d-M-Y', $day));
        $USDZAR = $quotes['USDZAR'];
        $USDLFX = $quotes['USDLFX'];

        $digits = $this->symbol->getDigits();
        $point  = $this->symbol->getPoint();
        $bars   = [];

        // ZARFX7 = 10 * USDLFX / USDZAR
        foreach ($USDZAR as $i => $bar) {
            $usdzar = $USDZAR[$i]['open'];
            $usdlfx = $USDLFX[$i]['open'];
            $open   = 10 * $usdlfx / $usdzar;
            $open   = round($open, $digits);
            $iOpen  = (int) round($open/$point);

            $usdzar = $USDZAR[$i]['close'];
            $usdlfx = $USDLFX[$i]['close'];
            $close  = 10 * $usdlfx / $usdzar;
            $close  = round($close, $digits);
            $iClose = (int) round($close/$point);

            $bars[$i]['time' ] = $bar['time'];
            $bars[$i]['open' ] = $open;
            $bars[$i]['high' ] = $iOpen > $iClose ? $open : $close;         // no min()/max() for performance
            $bars[$i]['low'  ] = $iOpen < $iClose ? $open : $close;
            $bars[$i]['close'] = $close;
            $bars[$i]['ticks'] = $iOpen==$iClose ? 1 : (abs($iOpen-$iClose) << 1);
        }
        return $bars;
    }
}
