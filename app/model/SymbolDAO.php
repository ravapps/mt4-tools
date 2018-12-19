<?php
namespace rosasurfer\rsx\model;

use rosasurfer\db\orm\DAO;

use const rosasurfer\db\orm\meta\INT;
use const rosasurfer\db\orm\meta\STRING;


/**
 * DAO for accessing {@link Symbol} instances.
 */
class SymbolDAO extends DAO {


    /**
     * {@inheritdoc}
     */
    public function getMapping() {
        static $mapping; return $mapping ?: ($mapping=$this->parseMapping([
            'connection' => 'rosatrader',
            'table'      => 't_projectsymbol',
            'class'      => Symbol::class,
            'properties' => [
                ['name'=>'id',                                             'type'=>INT,    'primary'=>true],    // db:int
                ['name'=>'created',                                        'type'=>STRING,                ],    // db:text[datetime] GMT
                ['name'=>'modified',                                       'type'=>STRING, 'version'=>true],    // db:text[datetime] GMT

                ['name'=>'type',                                           'type'=>STRING,                ],    // db:text Forex|Metals|Synthetic
                ['name'=>'name',                                           'type'=>STRING,                ],    // db:text
                ['name'=>'description',                                    'type'=>STRING,                ],    // db:text
                ['name'=>'digits',                                         'type'=>INT,                   ],    // db:int
                ['name'=>'tickHistoryFrom', 'column'=>'history_tick_from', 'type'=>STRING,                ],    // db:text[datetime] FXT
                ['name'=>'tickHistoryTo',   'column'=>'history_tick_to',   'type'=>STRING,                ],    // db:text[datetime] FXT
                ['name'=>'m1HistoryFrom',   'column'=>'history_M1_from',   'type'=>STRING,                ],    // db:text[datetime] FXT
                ['name'=>'m1HistoryTo',     'column'=>'history_M1_to',     'type'=>STRING,                ],    // db:text[datetime] FXT
                ['name'=>'d1HistoryFrom',   'column'=>'history_D1_from',   'type'=>STRING,                ],    // db:text[datetime] FXT
                ['name'=>'d1HistoryTo',     'column'=>'history_D1_to',     'type'=>STRING,                ],    // db:text[datetime] FXT
            ],
        ]));
    }
}
