<?php

namespace App\Services\Midtrans;

use App\Models\Order;
use Midtrans\Notification;

class CallbackService extends Midtrans
{
    protected $notification;
    protected $order;
    protected $server_key;

    public function __construct()
    {
        parent::__construct();

        $this->server_key = env('MIDTRANS_SERVER_KEY');
        $this->_handleNotification();
    }

    public function isSignatureKeyVerified()
    {
        return ($this->_createLocalSignatureKey() == $this->notification->signature_key);
    }

    public function isSuccess()
    {
        $statusCode = $this->notification->status_code;
        $transactionStatus = $this->notification->transaction_status;
        $fraudStatus = !empty($this->notification->fraud_status) ? ($this->notification->fraud_status == 'accept') : true;
 
        return ($statusCode == 200 && $fraudStatus && ($transactionStatus == 'capture' || $transactionStatus == 'settlement'));
    }
 
    public function isExpire()
    {
        return ($this->notification->transaction_status == 'expire');
    }
 
    public function isCancelled()
    {
        return ($this->notification->transaction_status == 'cancel');
    }

    public function isPending()
    {
        return ($this->notification->transaction_status == 'pending');
    }

    public function getNotification()
    {
        return $this->notification;
    }

    public function getMidtransSignature()
    {
        return $this->notification->signature_key;
    }

    public function getOrder()
    {
        return $this->order;
    }

    public function _createLocalSignatureKey()
    {
        $orderId = $this->order->order_id;
        $statusCode = $this->notification->status_code;
        $grossAmount = $this->order->total_amount;
        $input = $orderId . $statusCode . $grossAmount . $this->server_key;
        $signature = openssl_digest($input, 'sha512');
 
        return $signature;
    }

    public function _handleNotification()
    {
        $notification = new Notification();

        $this->notification = $notification;
        $this->order = Order::where('order_id', $this->notification->order_id)->first();
    }
}