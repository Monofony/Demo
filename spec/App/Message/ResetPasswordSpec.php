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

namespace spec\App\Message;

use App\Message\ResetPassword;
use PhpSpec\ObjectBehavior;

class ResetPasswordSpec extends ObjectBehavior
{
    function let(): void
    {
        $this->beConstructedWith('newPassw0rd');
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(ResetPassword::class);
    }

    function it_can_get_password(): void
    {
        $this->password->shouldReturn('newPassw0rd');
    }
}
