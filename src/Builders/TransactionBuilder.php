<?php

namespace GlobalPayments\Api\Builders;

use GlobalPayments\Api\Entities\Enums\TransactionModifier;
use GlobalPayments\Api\Entities\Enums\TransactionType;
use GlobalPayments\Api\Entities\PayLinkData;
use GlobalPayments\Api\PaymentMethods\Interfaces\IPaymentMethod;

abstract class TransactionBuilder extends BaseBuilder
{
    /**
     * Request transaction type
     *
     * @internal
     * @var TransactionType
     */
    public $transactionType;

    /**
     * Request payment method
     *
     * @internal
     * @var IPaymentMethod
     */
    public $paymentMethod;

    /**
     * used w/TransIT gateway
     *
     * @var bool
     */
    public $multiCapture;

    /**
     * used w/TransIT gateway
     *
     * @var int
     */
    public $multiCaptureSequence;

    /**
     * used w/TransIT gateway
     *
     * @var int
     */
    public $multiCapturePaymentCount;

    /**
     * Request transaction modifier
     *
     * @internal
     * @var TransactionModifier
     */
    public $transactionModifier = TransactionModifier::NONE;

    /**
     * Request should allow duplicates
     *
     * @internal
     * @var bool
     */
    public $allowDuplicates;

    /**
     * Request supplementary data
     *
     * @var array
     */
    public $supplementaryData;

    /**
     * Entity specific to PayLink service
     *
     * @var PayLinkData
     */
    public $payLinkData;

    /**
     *A unique identifier generated by Global Payments to identify the payment link.
     *
     * string
     */
    public $paymentLinkId;

    /**
     * @var string $transactionData
     */
    public $transactionData;

    /**
     * @var string $entryClass
     */
    public $entryClass;

    /**
     * @var string $paymentPurposeCode
     */
    public $paymentPurposeCode;

    /**
     * Instantiates a new builder
     *
     * @param TransactionType $type Request transaction type
     * @param IPaymentMethod $paymentMethod Request payment method
     *
     * @return
     */
    public function __construct($type, $paymentMethod = null)
    {
        parent::__construct();
        $this->transactionType = $type;
        $this->paymentMethod = $paymentMethod;
    }

    /**
     * Set the request transaction type
     *
     * @internal
     * @param TransactionType $transactionType Request transaction type
     *
     * @return TransactionBuilder
     */
    public function withTransactionType($transactionType)
    {
        $this->transactionType = $transactionType;
        return $this;
    }

    /**
     * Set the request transaction modifier
     *
     * @internal
     * @param TransactionModifier $modifier Request transaction modifier
     *
     * @return TransactionBuilder
     */
    public function withModifier($modifier)
    {
        $this->transactionModifier = $modifier;
        return $this;
    }

    /**
     * Set the request to allow duplicates
     *
     * @param bool $allowDuplicates Request to allow duplicates
     *
     * @return TransactionBuilder
     */
    public function withAllowDuplicates($allowDuplicates)
    {
        $this->allowDuplicates = $allowDuplicates;
        return $this;
    }

    /**
     * Depending on the parameters received,
     * Add supplementary data or
     * Add multiple values to the supplementaryData array
     *
     * @param string|array<string, string>  $key
     * @param string $value
     *
     * @return $this
     */
    public function withSupplementaryData($key, $value = null)
    {
        if ($value === null && is_array($key)) {
            foreach ($key as $k => $v) {
                $this->withSupplementaryData($k, $v);
            }
        }

        if ($key && isset($value)) {
            $this->supplementaryData[$key] = $value;
        }

        return $this;
    }

    public function withPayLinkData(PayLinkData $payLinkData)
    {
        $this->payLinkData = $payLinkData;

        return $this;
    }

    public function withPaymentLinkId($paymentLinkId)
    {
        $this->paymentLinkId = $paymentLinkId;
        return $this;
    }

    /**
     * Set the request transactionData
     *
     * @param array $data Request transactionData
     *
     * @return $this
     */
    public function withTransactionData($data)
    {
        $this->transactionData = $data;
        return $this;
    }

    /**
     * Three digit code used by a payment originator to identify a Canada check payment.
     *
     * @param string $paymentPurposeCode
     *
     * @return $this
     */
    public function withPaymentPurposeCode(string $paymentPurposeCode)
    {
        $this->paymentPurposeCode = $paymentPurposeCode;

        return $this;
    }

    /**
     * Standard entry class to designate how the transaction was authorized by the originator for check refunds.
     *
     * @param string $entryClass
     *
     * @return $this
     */
    public function withEntryClass(string $entryClass)
    {
        $this->entryClass = $entryClass;

        return $this;
    }
}
