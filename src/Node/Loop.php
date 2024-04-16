<?php

declare(strict_types=1);

namespace Yahiru\Endolang\Node;

use Yahiru\Endolang\Node;

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
