<?PHP

/**
 *  A Phone value object.
 *
 * This is a simple wrapper for giggsey/libphonenumber-for-php
 * (https://github.com/giggsey/libphonenumber-for-php)
 *
 * @package  Serendipity\Framework
 * @subpackage ValueObjects
 *
 *  @author      Adamo Crespi <hello@aerendir.me>
 *  @copyright   Copyright (c) 2015, Adamo Crespi
 *  @license     MIT License
 */

namespace SerendipityHQ\Framework\ValueObjects\Tests\Phone;

use SerendipityHQ\Framework\ValueObjects\Phone\Phone;

class PhoneTest extends \PHPUnit_Framework_TestCase
{
    public function testPhone()
    {
        $test = '3331234567';

        $resource = new Phone($test);
    }
}