<?php
/**
 * Created by PhpStorm.
 * User: devacc
 * Date: 09.04.2020
 * Time: 02:00
 */
use GuzzleHttp\Exception\RequestException;
use Minter\SDK\MinterCoins\MinterSendCoinTx;
use Minter\MinterAPI;
use Minter\SDK\MinterTx;

class FunFasy_helper
{

    /**
     * The unique identifier of this plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $plugin_name    The string used to uniquely identify this plugin.
     */
    private $plugin_name;
    private $node_address = 'https://mnt.funfasy.dev/';
    private $client;

    protected $minter_wallet_address;
    protected $minter_wallet_private_key;

    public function __construct()
    {
        $this->plugin_name = 'minter-yyy-cashback';
        $options = get_option($this->plugin_name);
        $this->minter_wallet_address = $options['minter_wallet_address'];
        $this->minter_wallet_private_key =$options['minter_wallet_private_key'];
        $this->client = new \GuzzleHttp\Client([
            'base_uri' => $this->node_address,
            'verify' => false,
            'connect_timeout' => 5.0,
            'timeout' => 30.0,
            'headers' => [
                'Content-Type' => 'application/json',
                'X-Project-Id' => $options['minter_funfasy_project_id'],
                'X-Project-Secret' => $options['minter_funfasy_project_secret'],
            ]
        ]);
    }


    public function getTickerPriceBip($ticker)
    {

        $httpClient = new \GuzzleHttp\Client([
            'base_uri' => 'https://mnt.funfasy.dev/',
            'verify' => false,
            'connect_timeout' => 5.0,
            'timeout' => 30.0,

            'headers' => [
                'Content-Type' => 'application/json',
                'X-Project-Id' => '6c9c46aa-70af-4793-9a45-8c7c82fe1665',
                'X-Project-Secret' => '80c73623afc3787a6f51084979bd66d9',
            ]
        ]);
        $api = new MinterAPI($httpClient);
        $minter_coupon_ticker = $ticker;
            $response = $api->estimateCoinSell($minter_coupon_ticker, 100, 'BIP');
            $priceBIP_ticker= $response->result->will_get/100;
        return $priceBIP_ticker;

    }

    public function pay_off_push(YYY_push $push, $tries=0){
        if (empty($push->getHash())){
            $options = get_option($this->plugin_name);
            $api = new MinterAPI($this->getClient());
            $tx = new MinterTx([
                'nonce' => $api->getNonce($this->getMinterWalletAddress()),
                'chainId' => MinterTx::MAINNET_CHAIN_ID,
                'gasPrice' => 1,
                'gasCoin' => $push->getTicker(),
                'type' => MinterSendCoinTx::TYPE,
                'data' => [
                    'coin' => $push->getTicker(),
                    'to' => $push->getAddress(),
                    'value' => $push->getCost()
                ],
                'payload' => '',
                'serviceData' => '',
                'signatureType' => MinterTx::SIGNATURE_SINGLE_TYPE
            ]);
            $transaction = $tx->sign($this->getMinterWalletPrivateKey());
            try {
                $response = $api->send($transaction);
                $hash = $response->result->hash;
                $push->setHash($hash);
                error_log('Add money to https://yyy.cash/push/' . $push->getLinkId());
                $push->save();
                return $push;
            } catch (RequestException $exception) {
                // short exception message
                $message = $exception->getMessage();
                // error response in json
                $content = $exception->getResponse()
                    ->getBody()
                    ->getContents();
                // error response as array
                $error = json_decode($content, true);
                error_log(print_r($error, 1) . ' Not generate push: ' );
                $transaction = 0;
                if($tries == 3){
                    return false;
                }else{
                    $tries=$tries+1;
                    return $this->pay_off_push($push,$tries);
                }
            }
        }else{
            return false;
        }
    }

    public function getBalanceBip($address=0,$tries=0){
        if($address === 0) {
            $address = $this->getMinterWalletAddress();
        }
        $api = new MinterAPI($this->getClient());
        try {
            $response = $api->getBalance($address);
            $balance = $response->result->balance->BIP;
            return $balance/1000000000000000000;
        } catch (RequestException $exception) {
            // short exception message
            $message = $exception->getMessage();
            // error response in json
            $content = $exception->getResponse()
                ->getBody()
                ->getContents();
            // error response as array
            $error = json_decode($content, true);
            error_log( ' cant getBalanceBip: '.print_r($error, 1)  );
            if($tries == 3){
                error_log('Max call reached getBalanceBip');
                return false;
            }else{
                $tries=$tries+1;
                return $this->getBalanceBip($address,$tries);
            }

        }
    }
    public function getBalanceTicker($address=0,$ticker='BIP',$tries=0){
        if($address === 0) {
            $address = $this->getMinterWalletAddress();
        }
        $api = new MinterAPI($this->getClient());
        try {
            $response = $api->getBalance($address);
            $balance = $response->result->balance->$ticker;
            return $balance/1000000000000000000;
        } catch (RequestException $exception) {
            // short exception message
            $message = $exception->getMessage();
            // error response in json
            $content = $exception->getResponse()
                ->getBody()
                ->getContents();
            // error response as array
            $error = json_decode($content, true);
            error_log( ' cant getBalanceBip: '.print_r($error, 1)  );
            if($tries == 3){
                error_log('Max call reached getBalanceBip');
                return false;
            }else{
                $tries=$tries+1;
                return $this->getBalanceBip($address,$tries);
            }

        }
    }

    public function getCommission(YYY_push $push){
        $api = new MinterAPI($this->getClient());
        $tx = new MinterTx([
            'nonce' => $api->getNonce($this->getMinterWalletAddress()),
            'chainId' => MinterTx::MAINNET_CHAIN_ID,
            'gasPrice' => 1,
            'gasCoin' => $push->getTicker(),
            'type' => MinterSendCoinTx::TYPE,
            'data' => [
                'coin' => $push->getTicker(),
                'to' => $push->getAddress(),
                'value' => $push->getCost()
            ],
            'payload' => '',
            'serviceData' => '',
            'signatureType' => MinterTx::SIGNATURE_SINGLE_TYPE
        ]);
        $transaction = $tx->sign($this->getMinterWalletPrivateKey());
        try {
            $api = new MinterAPI($this->getClient());

            $response = $api->estimateTxCommission($transaction);
            $commission = $response->result->commission;
            return $commission/1000000000000000000;

        } catch(RequestException $exception) {
            // handle error
            $content = $exception->getResponse()
                ->getBody()
                ->getContents();
            // error response as array
            $error = json_decode($content, true);
            error_log( ' cant getBalanceBip: '.print_r($error, 1)  );
        }
}
    /**
     * @return \GuzzleHttp\Client
     */
    public function getClient(): \GuzzleHttp\Client
    {
        return $this->client;
    }

    /**
     * @return mixed
     */
    public function getMinterWalletAddress()
    {
        return $this->minter_wallet_address;
    }

    /**
     * @return mixed
     */
    public function getMinterWalletPrivateKey()
    {

        return $this->minter_wallet_private_key;
    }


}