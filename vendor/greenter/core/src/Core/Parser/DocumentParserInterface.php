<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 05/10/2017
 * Time: 08:01.
 */

declare(strict_types=1);

namespace Greenter\Parser;

use Greenter\Model\DocumentInterface;

/**
 * Interface DocumentParserInterface.
 */
interface DocumentParserInterface
{
    /**
     * @param mixed $value
     *
     * @return DocumentInterface
     */
    public function parse($value): ?DocumentInterface;
}
