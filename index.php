<?php

require 'vendor/autoload.php';

use ANS\IexTradingAPI;
use ANS\ItemCountPassedToStockNewsOutOfRange;


$email = "someone@example.com";

try {
	$stockQuote = IexTradingAPI::stockNews('market', 60);	
	foreach ($stockQuote as $key => $stock) {
		var_dump($stock);
		echo "<br><br>";
	}
} catch (ItemCountPassedToStockNewsOutOfRange $e) {
	echo $e->errorMessage();
	echo $e->saveLog();
}

