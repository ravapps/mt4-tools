<?php
namespace rosasurfer\rt\console;

use rosasurfer\console\Command;
use rosasurfer\rt\model\RosaSymbol;


/**
 * MetaTraderHistoryCommand
 *
 * A {@link Command} to work with MetaTrader history files.
 */
class MetaTraderHistoryCommand extends Command {


    /** @var string */
    const DOCOPT = <<<'DOCOPT'

Create, update or show status information about MetaTrader history files.

Usage:
  rt.metatrader.history create SYMBOL [options]

Commands:
  create      Create a new MetaTrader history set (all standard timeframes).

Arguments:
  SYMBOL      Rosatrader symbol to use for history processing.

Options:
   -h --help  This help screen.

DOCOPT;


    /**
     * {@inheritdoc}
     *
     * @return $this
     */
    protected function configure() {
        $this->setDocoptDefinition(self::DOCOPT);
        return $this;
    }


    /**
     * {@inheritdoc}
     *
     * @return int - execution status code: 0 (zero) for "success"
     */
    protected function execute() {
        $symbol = $this->resolveSymbol();
        if (!$symbol)
            return $this->errorStatus;

        return $this->errorStatus = 0;
    }


    /**
     * Resolve the symbol to process.
     *
     * @return RosaSymbol|null
     */
    protected function resolveSymbol() {
        $name = $this->input->getArgument('SYMBOL');

        if (!$symbol = RosaSymbol::dao()->findByName($name)) {
            $this->error('Unknown Rosatrader symbol "'.$name.'"');
            $this->errorStatus = 1;
        }
        return $symbol;
    }
}