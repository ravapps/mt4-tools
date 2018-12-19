<?php
namespace rosasurfer\rsx\model;


/**
 * Represents an internal symbol.
 *
 * @method string getType()            Return the instrument type (Forex|Metals|Synthetic).
 * @method string getName()            Return the symbol name, i.e. the actual symbol.
 * @method string getDescription()     Return the symbol description.
 * @method int    getDigits()          Return the number of frational digits of symbol prices.
 * @method string getTickHistoryFrom() Return the start time of the available tick history (FXT).
 * @method string getTickHistoryTo()   Return the end time of the available tick history (FXT).
 * @method string getM1HistoryFrom()   Return the start time of the available M1 history (FXT).
 * @method string getM1HistoryTo()     Return the end time of the available M1 history (FXT).
 * @method string getD1HistoryFrom()   Return the start time of the available D1 history (FXT).
 * @method string getD1HistoryTo()     Return the end time of the available D1 history (FXT).
 */
class Symbol extends RosatraderModel {


    /** @var string - instrument type (Forex|Metals|Synthetic) */
    protected $type;

    /** @var string - symbol name */
    protected $name;

    /** @var string - symbol description */
    protected $description;

    /** @var int - number of fractional digits of symbol prices */
    protected $digits;

    /** @var string - starttime of the available tick history (FXT) */
    protected $tickHistoryFrom;

    /** @var string - endtime of the available tick history (FXT) */
    protected $tickHistoryTo;

    /** @var string - starttime of the available M1 history (FXT) */
    protected $m1HistoryFrom;

    /** @var string - endtime of the available M1 history (FXT) */
    protected $m1HistoryTo;

    /** @var string - starttime of the available D1 history (FXT) */
    protected $d1HistoryFrom;

    /** @var string - endtime of the available D1 history (FXT) */
    protected $d1HistoryTo;
}
