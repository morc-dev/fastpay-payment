# fastpay-payment
PHP classes for fastpay online payment and validation.



# Payment Integration Library

This PHP library provides a simple way to integrate with the FastPay payment gateway for initiating payments and validating transactions.

# Features
- *Payment Initialization*: Create and send payment requests to the gateway.
- *Payment Validation*: Verify the status of payments.
- *Customizable*: Set store credentials dynamically or use global configuration.
- *Error Handling*: Returns detailed error messages for failed requests.

# Installation
1. Clone or download this repository.
2. Include the PHP file in your project:
   ```php
   require_once 'library.php';
   ```

# Usage

# *Global Configuration*
Set your store credentials globally in the `$_CONFIG` array:
```php
$_CONFIG = [
    'store_id' => 'your_store_id',
    'store_password' => 'your_store_password'
];
```

# *1. Payment Request*
Use the `PaymentRequest` class to initiate a payment.
```php
$payment = new PaymentRequest();
$payment->setOrderId("1"); // Set unique order ID
$payment->setBillAmount(5000); // Set the amount in IQD
$payment->setCurrency("IQD"); // Set the currency
$payment->setCart([
    ["name" => "Scarf", "qty" => 1, "unit_price" => 5000, "sub_total" => 5000]
]); // Add items to the cart

$response = $payment->sendRequest();

if ($response['code'] === 200) {
    echo "Redirect URI: " . $response['data']['redirect_uri'];
} else {
    echo "Error: " . implode(", ", $response['messages']);
}
```

# *2. Payment Validation*
Use the `PaymentValidation` class to validate a payment.
```php
$validation = new PaymentValidation();
$validation->setOrderId("1"); // Set the order ID to validate

$response = $validation->validatePayment();

if ($response['code'] === 200) {
    echo "Validation Success: " . print_r($response['data'], true);
} else {
    echo "Validation Error: " . implode(", ", $response['messages']);
}
```

# Requirements
- PHP 7.4 or higher
- cURL extension enabled


# Configuration Options
You can override global credentials by providing them in the constructor:
```php
$payment = new PaymentRequest('custom_store_id', 'custom_store_password');
```

# Error Handling
The library returns error messages in the following structure:
```php
[
    "code" => <HTTP Status Code>,
    "messages" => [<Error Message 1>, <Error Message 2>, ...],
    "data" => null
]
```

# License
This project is not licensed feel free to use it and good luck. (Just mention MORC - Mohammed Azad)
