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
	
	/*Для категории*/
	public function getInspectionPrice($record) {
		return $this->getAllPrice($record);
	}
	
	public function getReturnSquarePrimaryPrice($record) {
		return $this->getSquarePrimaryPrice($record);
	}
	
	public function getReturnSquareSecondaryPrice($record) {
		return $this->getSquareSecondaryPrice($record);
	}
	
	private function getAllPrice(Record $record){
		$usd        = (int)trim($record->get('usd_total'));
		$rub        = (int)trim($record->get('rub_total'));
		$usd_square = (int)trim($record->get('usd_ms'));
		$rub_square = (int)trim($record->get('rub_ms'));
		$rub_month = (int)trim($record->get('rub_month'));
		$usd_month = (int)trim($record->get('usd_month'));
		$usd_day = (int)trim($record->get('usd_day'));
		$rub_day = (int)trim($record->get('rub_day'));
		
		if(!empty($usd)){
			return $usd;
		}
		if(!empty($rub)){
		    return $rub;
		}
		if(!empty($usd_square)){
			return $usd_square;
		}
		if(!empty($rub_square)){
			return $rub_square;
		}
		if(!empty($rub_month)){
			return $rub_month;
		}
		if(!empty($usd_month)){
			return $usd_month;
		}
		if(!empty($usd_day)){
			return $usd_day;
		}
	    if(!empty($rub_day)){
			return $rub_day;
		}
	}
	
	/*Доработка для вывода цены за метр квадратный*/
	private function getSquarePrimaryPrice(Record $record){
		$usd_total = (int)trim($record->get('usd_total'));
		$rub_total = (int)trim($record->get('rub_total'));
		$usd_square = (int)trim($record->get('usd_ms'));
		$rub_square = (int)trim($record->get('rub_ms'));
		$square = (int)trim($record->get('total_area'));
    
		/*Вариант 1 вывода цены */
		if($usd_total <= 0 && $rub_total <=0){
	        if ($usd_square>0) {
			    $html = '';
                
            if ($this->mr->getUsdRate()) {
				if ($square > 0){
				$round = round($usd_square / $square); //В рублях за 1м2
                $html .= $this->formatPrice($round, $this->mr->getUsdRate(), '', ' руб. '); //В рублях
				}else{
				$html .= $this->formatPrice($usd_square, $this->mr->getUsdRate(), '', ' руб. '); //В рублях
				}
            }
                return $html;
        }else{
            if ($rub_square>0) {  
			    $html = '';
				if ($square > 0){
				$round = round($rub_square / $square);
				$html .= $this->formatPrice($round, false, '', ' руб. ');
				}else{
				$html .= $this->formatPrice($rub_square, false, '', ' руб. ');
				}
			    return $html;
			}
		}
		}
         
		/*Вариант 2 вывода цены*/
		/*if($usd_total <= 0 && $rub_total <=0){
		    if ($usd_square>0) {
			    $html = '';
			
			    $html .= $this->formatPrice($usd_square, $this->mr->getUsdRate(), '', ' руб. ') . '&nbsp;за 1 м²';
						
			    return $html;
		}else{
		    if ($rub_square>0) {
			    $html = '';
				
                $html .= $this->formatPrice($rub_square, false, '', ' руб. ') . '&nbsp;за 1 м²';		
							
			    return $html;
		    }
		}
		}*/
	}
	
	private function getSquareSecondaryPrice(Record $record){
		$usd_total = (int)trim($record->get('usd_total'));
		$rub_total = (int)trim($record->get('rub_total'));
		$usd_square = (int)trim($record->get('usd_ms'));
		$rub_square = (int)trim($record->get('rub_ms'));
		$square = (int)trim($record->get('total_area'));
    
		/*Вариант 1 вывода цены */
		if($usd_total <= 0 && $rub_total <=0){
	        if ($usd_square>0) {
			    $html = '';
                			
		    if ($square > 0){
			    $round = round($usd_square / $square); //В долларах
				$html .= $this->formatPrice($round, false, '$&nbsp;'); //В долларах
			}else{
				$html .= $this->formatPrice($usd_square, false, '$&nbsp;');
			}
                return $html;
        }else{
            if ($rub_square>0) {  
			    $html = '';
								
			if ($square > 0){
				$price_rub_square = round($rub_square / $square);
				
				$html .= $this->formatPrice($price_rub_square, (1/$this->mr->getUsdRate()), '$&nbsp;');
			}else{
				$html .= $this->formatPrice($rub_square, (1/$this->mr->getUsdRate()), '$&nbsp;');
			}
			    return $html;
			}
		}
		}
         
		/*Вариант 2 вывода цены*/
		/*if($usd_total <= 0 && $rub_total <=0){
		    if ($usd_square>0) {
			    $html = '';
						
			    $html .= $this->formatPrice($usd_square, false, '$&nbsp;') . '&nbsp;за 1 м²';
			
			    return $html;
		}else{
		    if ($rub_square>0) {
			    $html = '';
								
			    $html .= $this->formatPrice($rub_square, (1/$this->mr->getUsdRate()), '$&nbsp;') . '&nbsp;за 1 м²';
			
			    return $html;
		    }
		}
		}*/
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
