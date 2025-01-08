<?php

// File generated from our OpenAPI spec
namespace MPHB\Stripe;

/**
 * A PaymentIntent guides you through the process of collecting a payment from your customer.
 * We recommend that you create exactly one PaymentIntent for each order or
 * customer session in your system. You can reference the PaymentIntent later to
 * see the history of payment attempts for a particular session.
 *
 * A PaymentIntent transitions through
 * <a href="https://stripe.com/docs/payments/intents#intent-statuses">multiple statuses</a>
 * throughout its lifetime as it interfaces with Stripe.js to perform
 * authentication flows and ultimately creates at most one successful charge.
 *
 * Related guide: <a href="https://stripe.com/docs/payments/payment-intents">Payment Intents API</a>
 *
 * @property string $id Unique identifier for the object.
 * @property string $object String representing the object's type. Objects of the same type share the same value.
 * @property int $amount Amount intended to be collected by this PaymentIntent. A positive integer representing how much to charge in the <a href="https://stripe.com/docs/currencies#zero-decimal">smallest currency unit</a> (e.g., 100 cents to charge $1.00 or 100 to charge ¥100, a zero-decimal currency). The minimum amount is $0.50 US or <a href="https://stripe.com/docs/currencies#minimum-and-maximum-charge-amounts">equivalent in charge currency</a>. The amount value supports up to eight digits (e.g., a value of 99999999 for a USD charge of $999,999.99).
 * @property int $amount_capturable Amount that can be captured from this PaymentIntent.
 * @property null|\Stripe\StripeObject $amount_details
 * @property int $amount_received Amount that this PaymentIntent collects.
 * @property null|string|\Stripe\StripeObject $application ID of the Connect application that created the PaymentIntent.
 * @property null|int $application_fee_amount The amount of the application fee (if any) that will be requested to be applied to the payment and transferred to the application owner's Stripe account. The amount of the application fee collected will be capped at the total payment amount. For more information, see the PaymentIntents <a href="https://stripe.com/docs/payments/connected-accounts">use case for connected accounts</a>.
 * @property null|\Stripe\StripeObject $automatic_payment_methods Settings to configure compatible payment methods from the <a href="https://dashboard.stripe.com/settings/payment_methods">Stripe Dashboard</a>
 * @property null|int $canceled_at Populated when <code>status</code> is <code>canceled</code>, this is the time at which the PaymentIntent was canceled. Measured in seconds since the Unix epoch.
 * @property null|string $cancellation_reason Reason for cancellation of this PaymentIntent, either user-provided (<code>duplicate</code>, <code>fraudulent</code>, <code>requested_by_customer</code>, or <code>abandoned</code>) or generated by Stripe internally (<code>failed_invoice</code>, <code>void_invoice</code>, or <code>automatic</code>).
 * @property string $capture_method Controls when the funds will be captured from the customer's account.
 * @property null|string $client_secret <p>The client secret of this PaymentIntent. Used for client-side retrieval using a publishable key.</p><p>The client secret can be used to complete a payment from your frontend. It should not be stored, logged, or exposed to anyone other than the customer. Make sure that you have TLS enabled on any page that includes the client secret.</p><p>Refer to our docs to <a href="https://stripe.com/docs/payments/accept-a-payment?ui=elements">accept a payment</a> and learn about how <code>client_secret</code> should be handled.</p>
 * @property string $confirmation_method Describes whether we can confirm this PaymentIntent automatically, or if it requires customer action to confirm the payment.
 * @property int $created Time at which the object was created. Measured in seconds since the Unix epoch.
 * @property string $currency Three-letter <a href="https://www.iso.org/iso-4217-currency-codes.html">ISO currency code</a>, in lowercase. Must be a <a href="https://stripe.com/docs/currencies">supported currency</a>.
 * @property null|string|\Stripe\Customer $customer <p>ID of the Customer this PaymentIntent belongs to, if one exists.</p><p>Payment methods attached to other Customers cannot be used with this PaymentIntent.</p><p>If present in combination with <a href="https://stripe.com/docs/api#payment_intent_object-setup_future_usage">setup_future_usage</a>, this PaymentIntent's payment method will be attached to the Customer after the PaymentIntent has been confirmed and any required actions from the user are complete.</p>
 * @property null|string $description An arbitrary string attached to the object. Often useful for displaying to users.
 * @property null|string|\Stripe\Invoice $invoice ID of the invoice that created this PaymentIntent, if it exists.
 * @property null|\Stripe\StripeObject $last_payment_error The payment error encountered in the previous PaymentIntent confirmation. It will be cleared if the PaymentIntent is later updated for any reason.
 * @property null|string|\Stripe\Charge $latest_charge The latest charge created by this PaymentIntent.
 * @property bool $livemode Has the value <code>true</code> if the object exists in live mode or the value <code>false</code> if the object exists in test mode.
 * @property \Stripe\StripeObject $metadata Set of <a href="https://stripe.com/docs/api/metadata">key-value pairs</a> that you can attach to an object. This can be useful for storing additional information about the object in a structured format. Learn more about <a href="https://stripe.com/docs/payments/payment-intents/creating-payment-intents#storing-information-in-metadata">storing information in metadata</a>.
 * @property null|\Stripe\StripeObject $next_action If present, this property tells you what actions you need to take in order for your customer to fulfill a payment using the provided source.
 * @property null|string|\Stripe\Account $on_behalf_of The account (if any) for which the funds of the PaymentIntent are intended. See the PaymentIntents <a href="https://stripe.com/docs/payments/connected-accounts">use case for connected accounts</a> for details.
 * @property null|string|\Stripe\PaymentMethod $payment_method ID of the payment method used in this PaymentIntent.
 * @property null|\Stripe\StripeObject $payment_method_configuration_details Information about the payment method configuration used for this PaymentIntent.
 * @property null|\Stripe\StripeObject $payment_method_options Payment-method-specific configuration for this PaymentIntent.
 * @property string[] $payment_method_types The list of payment method types (e.g. card) that this PaymentIntent is allowed to use.
 * @property null|\Stripe\StripeObject $processing If present, this property tells you about the processing state of the payment.
 * @property null|string $receipt_email Email address that the receipt for the resulting payment will be sent to. If <code>receipt_email</code> is specified for a payment in live mode, a receipt will be sent regardless of your <a href="https://dashboard.stripe.com/account/emails">email settings</a>.
 * @property null|string|\Stripe\Review $review ID of the review associated with this PaymentIntent, if any.
 * @property null|string $setup_future_usage <p>Indicates that you intend to make future payments with this PaymentIntent's payment method.</p><p>Providing this parameter will <a href="https://stripe.com/docs/payments/save-during-payment">attach the payment method</a> to the PaymentIntent's Customer, if present, after the PaymentIntent is confirmed and any required actions from the user are complete. If no Customer was provided, the payment method can still be <a href="https://stripe.com/docs/api/payment_methods/attach">attached</a> to a Customer after the transaction completes.</p><p>When processing card payments, Stripe also uses <code>setup_future_usage</code> to dynamically optimize your payment flow and comply with regional legislation and network rules, such as <a href="https://stripe.com/docs/strong-customer-authentication">SCA</a>.</p>
 * @property null|\Stripe\StripeObject $shipping Shipping information for this PaymentIntent.
 * @property null|string|\Stripe\Account|\Stripe\BankAccount|\Stripe\Card|\Stripe\Source $source This is a legacy field that will be removed in the future. It is the ID of the Source object that is associated with this PaymentIntent, if one was supplied.
 * @property null|string $statement_descriptor For card charges, use <a href="https://stripe.com/docs/payments/account/statement-descriptors#dynamic">statement_descriptor_suffix</a>. Otherwise, you can use this value as the complete description of a charge on your customers' statements. It must contain at least one letter and be 1–22 characters long.
 * @property null|string $statement_descriptor_suffix Provides information about a card payment that customers see on their statements. Concatenated with the prefix (shortened descriptor) or statement descriptor that’s set on the account to form the complete statement descriptor. Maximum 22 characters for the concatenated descriptor.
 * @property string $status Status of this PaymentIntent, one of <code>requires_payment_method</code>, <code>requires_confirmation</code>, <code>requires_action</code>, <code>processing</code>, <code>requires_capture</code>, <code>canceled</code>, or <code>succeeded</code>. Read more about each PaymentIntent <a href="https://stripe.com/docs/payments/intents#intent-statuses">status</a>.
 * @property null|\Stripe\StripeObject $transfer_data The data that automatically creates a Transfer after the payment finalizes. Learn more about the <a href="https://stripe.com/docs/payments/connected-accounts">use case for connected accounts</a>.
 * @property null|string $transfer_group A string that identifies the resulting payment as part of a group. Learn more about the <a href="https://stripe.com/docs/connect/separate-charges-and-transfers">use case for connected accounts</a>.
 */
class PaymentIntent extends ApiResource
{
    const OBJECT_NAME = 'payment_intent';
    use ApiOperations\All;
    use ApiOperations\Create;
    use ApiOperations\Retrieve;
    use ApiOperations\Search;
    use ApiOperations\Update;
    const CANCELLATION_REASON_ABANDONED = 'abandoned';
    const CANCELLATION_REASON_AUTOMATIC = 'automatic';
    const CANCELLATION_REASON_DUPLICATE = 'duplicate';
    const CANCELLATION_REASON_FAILED_INVOICE = 'failed_invoice';
    const CANCELLATION_REASON_FRAUDULENT = 'fraudulent';
    const CANCELLATION_REASON_REQUESTED_BY_CUSTOMER = 'requested_by_customer';
    const CANCELLATION_REASON_VOID_INVOICE = 'void_invoice';
    const CAPTURE_METHOD_AUTOMATIC = 'automatic';
    const CAPTURE_METHOD_AUTOMATIC_ASYNC = 'automatic_async';
    const CAPTURE_METHOD_MANUAL = 'manual';
    const CONFIRMATION_METHOD_AUTOMATIC = 'automatic';
    const CONFIRMATION_METHOD_MANUAL = 'manual';
    const SETUP_FUTURE_USAGE_OFF_SESSION = 'off_session';
    const SETUP_FUTURE_USAGE_ON_SESSION = 'on_session';
    const STATUS_CANCELED = 'canceled';
    const STATUS_PROCESSING = 'processing';
    const STATUS_REQUIRES_ACTION = 'requires_action';
    const STATUS_REQUIRES_CAPTURE = 'requires_capture';
    const STATUS_REQUIRES_CONFIRMATION = 'requires_confirmation';
    const STATUS_REQUIRES_PAYMENT_METHOD = 'requires_payment_method';
    const STATUS_SUCCEEDED = 'succeeded';
    /**
     * @param null|array $params
     * @param null|array|string $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\PaymentIntent the applied payment intent
     */
    public function applyCustomerBalance($params = null, $opts = null)
    {
        $url = $this->instanceUrl() . '/apply_customer_balance';
        list($response, $opts) = $this->_request('post', $url, $params, $opts);
        $this->refreshFrom($response, $opts);
        return $this;
    }
    /**
     * @param null|array $params
     * @param null|array|string $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\PaymentIntent the canceled payment intent
     */
    public function cancel($params = null, $opts = null)
    {
        $url = $this->instanceUrl() . '/cancel';
        list($response, $opts) = $this->_request('post', $url, $params, $opts);
        $this->refreshFrom($response, $opts);
        return $this;
    }
    /**
     * @param null|array $params
     * @param null|array|string $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\PaymentIntent the captured payment intent
     */
    public function capture($params = null, $opts = null)
    {
        $url = $this->instanceUrl() . '/capture';
        list($response, $opts) = $this->_request('post', $url, $params, $opts);
        $this->refreshFrom($response, $opts);
        return $this;
    }
    /**
     * @param null|array $params
     * @param null|array|string $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\PaymentIntent the confirmed payment intent
     */
    public function confirm($params = null, $opts = null)
    {
        $url = $this->instanceUrl() . '/confirm';
        list($response, $opts) = $this->_request('post', $url, $params, $opts);
        $this->refreshFrom($response, $opts);
        return $this;
    }
    /**
     * @param null|array $params
     * @param null|array|string $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\PaymentIntent the incremented payment intent
     */
    public function incrementAuthorization($params = null, $opts = null)
    {
        $url = $this->instanceUrl() . '/increment_authorization';
        list($response, $opts) = $this->_request('post', $url, $params, $opts);
        $this->refreshFrom($response, $opts);
        return $this;
    }
    /**
     * @param null|array $params
     * @param null|array|string $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\PaymentIntent the verified payment intent
     */
    public function verifyMicrodeposits($params = null, $opts = null)
    {
        $url = $this->instanceUrl() . '/verify_microdeposits';
        list($response, $opts) = $this->_request('post', $url, $params, $opts);
        $this->refreshFrom($response, $opts);
        return $this;
    }
    /**
     * @param null|array $params
     * @param null|array|string $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\SearchResult<\Stripe\PaymentIntent> the payment intent search results
     */
    public static function search($params = null, $opts = null)
    {
        $url = '/v1/payment_intents/search';
        return self::_searchResource($url, $params, $opts);
    }
}
