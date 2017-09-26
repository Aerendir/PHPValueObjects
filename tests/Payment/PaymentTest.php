<?php

/*
 * This file is part of PHP Value Objects.
 *
 * Copyright Adamo Aerendir Crespi 2015-2017.
 *
 * @author    Adamo Aerendir Crespi <hello@aerendir.me>
 * @copyright Copyright (C) 2015 - 2017 Aerendir. All rights reserved.
 * @license   MIT
 */

namespace SerendipityHQ\Component\ValueObjects\tests\Payment;

use PHPUnit\Framework\TestCase;
use SerendipityHQ\Component\ValueObjects\Common\ComplexValueObjectInterface;
use SerendipityHQ\Component\ValueObjects\Payment\Payment;
use SerendipityHQ\Component\ValueObjects\Payment\PaymentInterface;

/**
 * Tests the Payment Class.
 */
class PaymentTest extends TestCase
{
    public function testPayment()
    {
        // Of AddressModel
        $testData = [
            'method'   => 'PayPal',
            'status' => 'A random status',
        ];

        $resource = new Payment($testData);

        // Test the value object direct interface
        $this::assertInstanceOf(PaymentInterface::class, $resource);

        // Test the type of value object interface
        $this::assertInstanceOf(ComplexValueObjectInterface::class, $resource);

        $this::assertEquals($testData['method'], $resource->getMethod());
        $this::assertEquals($testData['status'], $resource->getStatus());
        $this::assertTrue(is_string($resource->__toString()));
        $this::assertTrue(is_string($resource->toString()));
    }
}
