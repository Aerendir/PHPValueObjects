<?php

/*
 * This file is part of the Serendipity HQ Value Objects Component.
 *
 * Copyright (c) Adamo Aerendir Crespi <aerendir@serendipityhq.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SerendipityHQ\Component\ValueObjects\Money\Bridge\Doctrine;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Money\Currency;
use Money\Exception\ParserException;
use Safe\Exceptions\StringsException;
use function Safe\sprintf;
use SerendipityHQ\Component\ValueObjects\Money\Money;
use SerendipityHQ\Component\ValueObjects\Money\MoneyInterface;

/**
 * A custom datatype to persist a Money Value Object with Doctrine.
 */
final class MoneyType extends Type
{
    /** @var string */
    public const NAME = 'money';

    /**
     * @param array<string,mixed> $column
     */
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getVarcharTypeDeclarationSQL($column);
    }

    /**
     * {@inheritDoc}
     */
    public function getDefaultLength(AbstractPlatform $platform): int
    {
        return $platform->getVarcharDefaultLength();
    }

    /**
     * {@inheritDoc}
     *
     * @throws \InvalidArgumentException
     * @throws ParserException
     * @psalm-suppress MixedArgument
     *
     * @return Money|string|null
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if (null === $value || '' === $value) {
            return $value;
        }

        $objects = \explode('-', $value);

        $currency = new Currency($objects[1]);

        return new Money([MoneyInterface::BASE_AMOUNT => (int) $objects[0], MoneyInterface::CURRENCY => $currency]);
    }

    /**
     * {@inheritDoc}
     *
     * @param Money|string|null $value
     *
     * @throws \InvalidArgumentException
     * @throws StringsException
     *
     * @psalm-suppress DocblockTypeContradiction
     * @psalm-suppress MixedArgument
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if (null === $value || '' === $value) {
            return $value;
        }

        if ( ! $value instanceof Money) {
            $type = \is_object($value) ? \get_class($value) : \gettype($value);
            throw new \InvalidArgumentException(sprintf('You have to pass an object of kind \SerendipityHQ\Component\ValueObjects\Money\Money to use the Doctrine type MoneyType. "%s" passed instead.', $type));
        }

        return $value->getBaseAmount() . '-' . $value->getCurrency()->getCode();
    }

    /**
     * {@inheritDoc}
     */
    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return ! parent::requiresSQLCommentHint($platform);
    }

    /**
     * {@inheritDoc}
     */
    public function getName(): string
    {
        return self::NAME;
    }
}
