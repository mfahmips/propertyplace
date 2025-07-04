<?php

declare(strict_types=1);

/**
 * This file is part of CodeIgniter 4 framework.
 *
 * (c) CodeIgniter Foundation <admin@codeigniter.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace CodeIgniter\Test\Mock;

use CodeIgniter\Events\Events;

class MockEvents extends Events
{
    /**
     * @return array<string, array{0: bool, 1: list<int>, 2: list<callable(mixed): mixed>}>
     */
    public function getListeners()
    {
        return self::$listeners;
    }

    /**
     * @return list<string>
     */
    public function getEventsFile()
    {
        return self::$files;
    }

    /**
     * @return bool
     */
    public function getSimulate()
    {
        return self::$simulate;
    }

    /**
     * @return void
     */
    public function unInitialize()
    {
        static::$initialized = false;
    }
}
