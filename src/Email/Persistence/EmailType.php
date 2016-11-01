<?php

namespace SerendipityHQ\Component\ValueObjects\Email\Persistence;

use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\RFCValidation;
use SerendipityHQ\Component\ValueObjects\Email\Email;

/**
 * A custom datatype to persist an Email Value Object with Doctrine.
 *
 * @author Adamo Crespi <hello@aerendir.me>
 */
class EmailType extends Type
{
    const EMAIL = 'email';

    /**
     * {@inheritdoc}
     */
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return $platform->getVarcharTypeDeclarationSQL($fieldDeclaration);
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultLength(AbstractPlatform $platform)
    {
        return $platform->getVarcharDefaultLength();
    }

    /**
     * {@inheritdoc}
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if (null === $value || '' === $value) {
            return $value;
        }

        return new Email($value);
    }

    /**
     * {@inheritdoc}
     *
     * @param Email $value
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (null === $value || '' === $value) {
            return $value;
        }

        if (!$value instanceof Email) {
            $type = is_object($value) ? get_class($value) : gettype($value);
            throw new \InvalidArgumentException(sprintf('You have to pass an object of kind \SerendipityHQ\Component\ValueObjects\Email\Email to use the Doctrine type EmailType. "%s" passed instead.', $type));
        }

        // Validate the $value as a valid email
        $validator = new EmailValidator();

        if (!$validator->isValid($value, new RFCValidation())) {
            throw new \InvalidArgumentException(sprintf('An email field accepts only valid email addresses. The value "%s" is not a valid email.', $value));
        }

        // The value is automatically transformed into a string thans to the __toString() method
        return $value;
    }

    /**
     * {@inheritdoc}
     */
    public function requiresSQLCommentHint(AbstractPlatform $platform)
    {
        return !parent::requiresSQLCommentHint($platform);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return self::EMAIL;
    }
}