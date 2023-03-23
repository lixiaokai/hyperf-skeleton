<?php

declare(strict_types=1);

namespace Core\Contract;

use Hyperf\Database\Model\Relations\BelongsToMany;

interface UserInterface
{
    public function roles(): BelongsToMany;
}
