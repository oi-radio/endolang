<?php

declare(strict_types=1);

namespace OiRadio\Endolang\Node;

use OiRadio\Endolang\Node;

final class Loop implements Node
{
    /**
     * @param list<Node> $nodes
     */
    public function __construct(
        public readonly array $nodes,
    ) {
    }
}
