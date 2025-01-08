<?php
    /* Coded By Mohammed Azad at MORC */

    // You can delete line 4 and 5
    error_reporting(E_ALL);
    ini_set('display_errors', '1');

    $_CONFIG = ['store_id' => '123456789', 'store_password' => 'a1b2c3d4e5f6g'];

    class PaymentRequest {
        private $storeId;
        private $storePassword;
        private $orderId;
        private $billAmount;
        private $currency;
        private $cart;

        public function __construct($store_id = null, $store_password = null){
            if ($store_id != null && $store_password != null) {
                $this->setStoreId($store_id);
                $this->setStorePassword($store_password);
            } else {
                global $_CONFIG;
                if (isset($_CONFIG['store_id'], $_CONFIG['store_password'])) {
                    $this->setStoreId($_CONFIG['store_id']);
                    $this->setStorePassword($_CONFIG['store_password']);
                }
            }
        }

        public function setStoreId($storeId) {
            $this->storeId = $storeId;
        }

        public function getStoreId() {
            return $this->storeId;
        }

        public function setStorePassword($storePassword) {
            $this->storePassword = $storePassword;
        }

        public function getStorePassword() {
            return $this->storePassword;
        }

        public function setOrderId($orderId) {
            $this->orderId = $orderId;
        }

        public function getOrderId() {
            return $this->orderId;
        }

        public function setBillAmount($billAmount) {
            $this->billAmount = $billAmount;
        }

        public function getBillAmount() {
            return $this->billAmount;
        }

        public function setCurrency($currency) {
            $this->currency = $currency;
        }

        public function getCurrency() {
            return $this->currency;
        }

        public function setCart($cart) {
            $this->cart = $cart;
        }

        public function getCart() {
            return $this->cart;
        }

        public function sendRequest($url = 'https://staging-apigw-merchant.fast-pay.iq/api/v1/public/pgw/payment/initiation') {
            $data = [
                "store_id" => $this->getStoreId(),
                "store_password" => $this->getStorePassword(),
                "order_id" => $this->getOrderId(),
                "bill_amount" => $this->getBillAmount(),
                "currency" => $this->getCurrency(),
                "cart" => json_encode($this->getCart())
            ];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Accept: application/json'
            ]);

            $response = curl_exec($ch);

            if (curl_errno($ch)) {
                curl_close($ch);
                return [
                    "code" => 500,
                    "messages" => [curl_error($ch)],
                    "data" => null
                ];
            }

            curl_close($ch);
            return json_decode($response, true);
        }
    }

    class PaymentValidation {
        private $storeId;
        private $storePassword;
        private $orderId;

        public function __construct($store_id = null, $store_password = null){
            if ($store_id != null && $store_password != null) {
                $this->setStoreId($store_id);
                $this->setStorePassword($store_password);
            } else {
                global $_CONFIG;
                if (isset($_CONFIG['store_id'], $_CONFIG['store_password'])) {
                    $this->setStoreId($_CONFIG['store_id']);
                    $this->setStorePassword($_CONFIG['store_password']);
                }
            }
        }
    
        public function setStoreId($storeId) {
            $this->storeId = $storeId;
        }
    
        public function getStoreId() {
            return $this->storeId;
        }
    
        public function setStorePassword($storePassword) {
            $this->storePassword = $storePassword;
        }
    
        public function getStorePassword() {
            return $this->storePassword;
        }
    
        public function setOrderId($orderId) {
            $this->orderId = $orderId;
        }
    
        public function getOrderId() {
            return $this->orderId;
        }
    
        public function validatePayment($url = 'https://staging-apigw-merchant.fast-pay.iq/api/v1/public/pgw/payment/validate') {
            $data = [
                "store_id" => $this->getStoreId(),
                "store_password" => $this->getStorePassword(),
                "order_id" => $this->getOrderId()
            ];
    
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Accept: application/json'
            ]);
    
            $response = curl_exec($ch);
    
            if (curl_errno($ch)) {
                curl_close($ch);
                return [
                    "code" => 500,
                    "messages" => [curl_error($ch)],
                    "data" => null
                ];
            }
    
            curl_close($ch);
            return json_decode($response, true);
        }
    }    
    /*
    // USAGE FOR PAYMENT
    $payment = new PaymentRequest();
    $payment->setOrderId("1");
    $payment->setBillAmount(5000);
    $payment->setCurrency("IQD");
    $payment->setCart([
        ["name" => "Scarf", "qty" => 1, "unit_price" => 5000, "sub_total" => 5000]
    ]);
    $response = $payment->sendRequest();

    if ($response['code'] === 200) {
        echo "Redirect URI: " . $response['data']['redirect_uri'];
    } else {
        echo "Error: " . implode(", ", $response['messages']);
    }

    // USAGE FOR VALIDATION
    $validation = new PaymentValidation();
    $validation->setOrderId("1");
    $response = $validation->validatePayment();

    if ($response['code'] === 200) {
        echo "Validation Success: " . print_r($response['data'], true);
    } else {
        echo "Validation Error: " . implode(", ", $response['messages']);
    }
    */
?>
