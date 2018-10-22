<?php

namespace ANS;

class ItemCountPassedToStockNewsOutOfRange extends \Exception {

	public function errorMessage() {
    $errorMsg = $this->getMessage();
    return $errorMsg;
  }

  public function saveLog() {
  	$errorMsg = 'log saved...';
    return $errorMsg;
  }
}