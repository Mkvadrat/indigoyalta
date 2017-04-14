<?php

/**
 * Description of MoneyRates
 *
 * @author AlexGousev
 */
class MoneyRates {

	private static $instance;
	

	private $rates;
	
	
	/**
	 * Constructor
	 */
	private function __construct() {
		$today = mktime(0, 0, 0, date('n'), date('j'), date('Y'));
		$cachePath = $_SERVER['DOCUMENT_ROOT'] . '/application/cache/moneyrate.cache';
		
		if (is_readable($cachePath) && filectime($cachePath) > $today)
			$this->rates = @unserialize(file_get_contents($cachePath));
		else {
			$this->rates = $this->fetchRates();
			if ($this->rates !== false)
				file_put_contents($cachePath, serialize ($this->rates));
		}

        if (is_array($this->rates)) {
            foreach($this->rates as $key=>$val) {
                $this->rates[$key] = trim(str_replace(',','.',$val));
            }
        }
	}
	
	
	/**
	 * @return MoneyRates
	 */
	public static function getInstance() {
		if (!isset(self::$instance))
			self::$instance = new MoneyRates();
		
		return self::$instance;
	}
	
	
	/**
	 * Возвращает курс доллара к рублю
	 * 
	 * @return float|false
	 */
	public function getUsdRate() {
		if ($this->rates === false)
			return false;
		
		return $this->rates['usd'];
	}
	
	
	/**
	 * Возвращает курс гривны к рублю
	 * 
	 * @return float|false
	 */
	public function getUahRate() {
        if ($this->rates === false)
            return false;

        return $this->rates['uah'];
	}

    public function getEurRate() {
        if ($this->rates === false)
            return false;

        return $this->rates['eur'];
    }
	
	
	/**
	 * Fetch rates from CBRF
	 * 
	 * @return array
	 */
	private function fetchRates() {
		
		# Получаем текущий курс с сайта центробанка
		//$info = @file_get_contents('http://www.cbr.ru/scripts/XML_daily.asp');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://www.cbr.ru/scripts/XML_daily.asp");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $info = curl_exec($ch);
        curl_close($ch);



        if ($info === false)
			return false;
	
		libxml_use_internal_errors();
		$xml = simplexml_load_string($info);
		if ($xml === false)
			return false;
	
		$usdElements = $xml->xpath('/*/Valute[CharCode="USD"]');
		$uahElements = $xml->xpath('/*/Valute[CharCode="UAH"]');
        $eurElements = $xml->xpath('/*/Valute[CharCode="EUR"]');
		if (!isset($uahElements[0]) || !isset($usdElements[0]) || !isset($eurElements))
			return false;
	
		$usd = (float)str_replace(',', '.', $usdElements[0]->Value / $usdElements[0]->Nominal);
		$uah = (float)str_replace(',', '.', $uahElements[0]->Value / $uahElements[0]->Nominal);
        $eur = (float)str_replace(',', '.', $eurElements[0]->Value / $eurElements[0]->Nominal);

		if ($usd <= 0 || $uah <= 0 || $eur <=0)
			return false;

		return array('usd' => $usd, 'uah' => $uah, 'eur' => $eur);
	}
}
