<?PHP

/**
 *  An Uri value object.
 *  This is just a wrapper for Zend Uri.
 *
 * @link https://github.com/zendframework/zend-uri
 *
 * @todo This has to be a Guzzle Uri or https://github.com/mvdbos/vdb-uri
 *
 *  @author      Adamo Crespi <hello@aerendir.me>
 *  @copyright   Copyright (c) 2015, Adamo Crespi
 *  @license     MIT License
 */
namespace SerendipityHQ\Component\ValueObjects\Uri;

use SerendipityHQ\Component\ValueObjects\Common\ValueObjectInterface;
use SerendipityHQ\Component\ValueObjects\Uri\UriInterface;
use Zend\Uri\Uri as BaseUri;

class Uri extends BaseUri implements UriInterface, ValueObjectInterface
{
    public function __construct($uri = null)
    {
        // Remove the trailing slash
        $uri = rtrim($uri, '/');

        parent::__construct($uri);
    }

    public function __set($field, $value)
    {
    }
}
