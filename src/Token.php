<?php

declare(strict_types=1);

namespace Yahiru\Endolang;

enum Token: string
{
    case Out = '〜';
    case In = '！';
    case LoopStart = '結';
    case LoopEnd = '婚';
}
