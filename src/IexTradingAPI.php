<?php

namespace ANS;

use GuzzleHttp\Client;
use ANS\StockNews;
use ANS\ItemCountPassedToStockNewsOutOfRange;

class IexTradingAPI
{
	const URL = 'https://api.iextrading.com/1.0/';

	public static function stockNews( $ticker = 'market', $items = null ) {
		if ( isset( $items ) && ( $items < 1 || $items > 50 ) ):
        throw new ItemCountPassedToStockNewsOutOfRange( "If you pass in a date it needs to be a number between 1 and 50. You passed in " . $items );
    endif;

    if ( isset( $items ) ):
        $uri = 'stock/' . $ticker . '/news/last/' . $items;
    else:
        $uri = 'stock/' . $ticker . '/news';
    endif;
    $response = IexTradingAPI::makeRequest( 'GET', $uri );

    return new StockNews( $response );

	}

	/**
   * Set up and return a GuzzleHttp Client with some default settings.
   * @return \GuzzleHttp\Client
   */
  protected static function getClient() {
    return new Client( [
                           'verify'   => false,
                           'base_uri' => IexTradingAPI::URL,
                       ] );
  }

	protected static function makeRequest( $method, $uri ) {
    $client = IexTradingAPI::getClient();
    try {
      return $client->request( $method, $uri );
    } catch ( ClientException $clientException ) {
        if ( 'Unknown symbol' == $clientException->getResponse()->getBody() ):
            throw new UnknownSymbol( "IEXTrading.com replied with: " . $clientException->getResponse()->getBody() );
        endif;
        throw $clientException;
    } catch ( \Exception $exception ) {
        throw $exception;
    }
  }
}