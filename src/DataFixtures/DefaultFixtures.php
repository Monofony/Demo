<?php

/*
 * This file is part of the Monofony demo project.
 *
 * (c) Monofony
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\DataFixtures;

use App\Story\DefaultAdministratorsStory;
use App\Story\DefaultAppUsersStory;
use App\Story\DefaultLocalesStory;
use App\Story\DefaultTaxonomyStory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class DefaultFixtures extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        DefaultLocalesStory::load();
        DefaultAdministratorsStory::load();
        DefaultAppUsersStory::load();
        DefaultTaxonomyStory::load();
    }

    public static function getGroups(): array
    {
        return ['default'];
    }
}
