<?php
namespace Doctrine\Tests\Models\StockExchange;

/**
 * @Entity
 * @Table(name="exchange_stocks")
 */
class Stock
{
    /**
     * @Id @GeneratedValue @Column(type="integer")
     * @var int
     */
    private int|null $id = null;

    /**
     * @Column(type="string", unique=true)
     */
    private string $symbol;

    /**
     * @ManyToOne(targetEntity="Market", inversedBy="stocks")
     * @var Market
     */
    private Market|null $market = null;

    public function __construct($symbol, Market $market)
    {
        $this->symbol = $symbol;
        $this->market = $market;
        $market->addStock($this);
    }

    public function getSymbol(): string
    {
        return $this->symbol;
    }
}