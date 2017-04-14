<?php

/**
 * Формирует форматированные цены объекта
 *
 * @author AlexGousev <alex@gousev.ru>
 */
class Price {
   
	/**
	 * @var MoneyRates
	 */
	private $mr;
	
	
	/**
	 * @var string
	 */
	private $price;
	private $primary_price;
	private $secondary_price;
	private $period;
	private $salePerSquare;
	private $dealType;
	
	
	const DEAL_SALE = 'S';
	const DEAL_RENT = 'R';
	
	/**
	 * Construct
	 * 
	 * @param Record $record
	 */
	public function __construct(Record $record, $salePerSquare = false) {
		
		$this->mr = MoneyRates::getInstance();
		$this->salePerSquare = $salePerSquare;
		
		if ($record->get('deal_type') == 'S') {
			$this->parseSale($record);
			$this->dealType = self::DEAL_SALE;
		}
		else {
			$this->parseRent($record);	
			$this->dealType = self::DEAL_RENT;
		}
	}
	
	
	
	public function getPrimaryPrice() {
		return isset($this->primary_price) ? $this->primary_price : false;
	}
	
	
	public function getSecondaryPrice() {
		return isset($this->secondary_price) ? $this->secondary_price : false;
	}
	
	
	public function hasPrice() {
		return isset($this->primary_price);
	}
	
	public function hasSecondPrice() {
		return isset($this->secondary_price);
	}
	
	
	public function getUnit() {
		if (isset($this->period))
			return $this->period;
		elseif ($this->salePerSquare)
			return 'м²';
		else
			return false;
	}
	
	
	public function hasUnit() {
		return isset($this->period) || $this->salePerSquare;
	}
	
	
	public function getPrice() {
		return isset($this->price) ? $this->price : 0;
	}
	
	
	public function getDialType() {
		return $this->dealType;
	}
	
	
	
	private function parseSale(Record $record) {
		if ($this->salePerSquare) {
			$usd = (int)trim($record->get('usd_ms'));
			if ($usd <= 0) {
				$square = (int)trim($record->get('total_area'));
				$usd_total = (int)trim($record->get('usd_total'));
				if ($usd_total > 0 && $square > 0)
					$usd = round($usd_total / $square);
			}
		}
		else
			$usd = (int)trim($record->get('usd_total'));

        $rub=0;
        if ($usd<=0) {
            if ($this->salePerSquare) {
                $rub = (int)trim($record->get('rub_ms'));
                if ($rub <= 0) {
                    $square = (int)trim($record->get('total_area'));
                    $rub_total = (int)trim($record->get('rub_total'));
                    if ($rub_total > 0 && $square > 0)
                        $rub = round($rub_total / $square);
                }
            }
            else
                $rub = (int)trim($record->get('rub_total'));
        }

		if ($usd <= 0 && $rub<=0)
			return;

        if ($usd>0) {
            $this->primary_price = $this->formatPrice($usd, false, '$&nbsp;');
            if ($this->mr->getUsdRate()) {
                $this->secondary_price = $this->formatPrice($usd, $this->mr->getUsdRate(), '', ' руб. ');
            }
            $this->price = (int)$usd;
        } else if ($rub>0 && $this->mr->getUsdRate()) {
            $this->primary_price = $this->formatPrice($rub, (1/$this->mr->getUsdRate()), '$&nbsp;');
            $this->secondary_price = $this->formatPrice($rub, false, '', ' руб. ');
            $this->price = (int)($rub/$this->mr->getUsdRate());
        }
	}
	
	
	private function parseRent(Record $record) {
        $price = $record->get('rub_month');
        if ($price != '') {
            $this->primary_price = $this->formatPrice($price, false, '', ' руб. ');
            if ($this->mr->getUsdRate()) {
                $this->secondary_price = $this->formatPrice($price, (1/$this->mr->getUsdRate()), '$&nbsp;');
            }
            $this->period = 'месяц';
            $this->price = (int)$price;
            return;
        }

        if ($this->mr->getUsdRate()) {
            $price = $record->get('usd_month');
            if ($price != '') {
                $this->primary_price = $this->formatPrice($price, $this->mr->getUsdRate(), '', ' руб. ');
                $this->secondary_price = $this->formatPrice($price, false, '$');
                $this->period = 'месяц';
                $this->price = (int)$price;
                return;
            }

            $price = $record->get('uah_month');
            if ($price != '') {
                $this->primary_price = $this->formatPrice($price, $this->mr->getUahRate(), '', ' руб. ');
                $rate = $this->mr->getUahRate() / $this->mr->getUsdRate();
                $this->secondary_price = $this->formatPrice($price, $rate, '$');
                $this->period = 'месяц';
                $this->price = round($price * $rate);
                return;
            }
        }

        $price = $record->get('rub_day');
        if ($price != '') {
            $this->primary_price = $this->formatPrice($price, false, '', ' руб. ');
            if ($this->mr->getUsdRate()) {
                $this->secondary_price = $this->formatPrice($price, (1/$this->mr->getUsdRate()), '$&nbsp;');
            }
            $this->price = (int)$price;
            $this->period = 'сутки';
            return;
        }

        if ($this->mr->getUsdRate()) {
            $price = $record->get('usd_day');
            if ($price != '') {
                $this->primary_price = $this->formatPrice($price, $this->mr->getUsdRate(), '', ' руб. ');
                $this->secondary_price = $this->formatPrice($price, false, '$');
                $this->price = (int)$price;
                $this->period = 'сутки';
                return;
            }

            $price = $record->get('uah_day');
            if ($price != '') {
                $this->primary_price = $this->formatPrice($price, $this->mr->getUahRate(), '', ' руб. ');
                $rate = $this->mr->getUahRate() / $this->mr->getUsdRate();
                $this->secondary_price = $this->formatPrice($price, $rate, '$');
                $this->period = 'сутки';
                $this->price = round($price * $rate);
                return;
            }
        }
	}
	
	
	private function formatPrice($price, $rate = false, $prefix = '', $postfix = '') {
		$price = preg_replace_callback('%\d+%', function($str) use ($rate) {
			$myprice = (int)$str[0];
			if ($rate)
				$myprice *= $rate;
			return number_format($myprice, 0, ',', ' ');
		}, $price);
		
		return "$prefix$price$postfix";
	}
}
