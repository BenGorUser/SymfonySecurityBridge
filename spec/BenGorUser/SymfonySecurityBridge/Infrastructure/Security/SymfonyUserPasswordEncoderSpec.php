<?php

/*
 * This file is part of the BenGorUser package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\BenGorUser\SymfonySecurityBridge\Infrastructure\Security;

use BenGorUser\SymfonySecurityBridge\Infrastructure\Security\SymfonyUserPasswordEncoder;
use BenGorUser\User\Domain\Model\UserPassword;
use BenGorUser\User\Domain\Model\UserPasswordEncoder;
use PhpSpec\ObjectBehavior;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;

/**
 * Spec file of SymfonyUserPassword class.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 */
class SymfonyUserPasswordEncoderSpec extends ObjectBehavior
{
    function let(PasswordEncoderInterface $passwordEncoder)
    {
        $this->beConstructedWith($passwordEncoder);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(SymfonyUserPasswordEncoder::class);
    }

    function it_implements_user_password_encoder()
    {
        $this->shouldImplement(UserPasswordEncoder::class);
    }

    function it_encodes(PasswordEncoderInterface $passwordEncoder)
    {
        $passwordEncoder->encodePassword(
            'plain-password', 'dummy-salt'
        )->shouldBeCalled()->willReturn('encoded-password');

        $this->encode('plain-password', 'dummy-salt')->shouldReturn('encoded-password');
    }

    function it_checks_password_is_valid(PasswordEncoderInterface $passwordEncoder)
    {
        $password = UserPassword::fromEncoded(
            'encoded-password',
            'dummy-salt'
        );
        $passwordEncoder->isPasswordValid(
            'encoded-password', 'plain-password', 'dummy-salt'
        )->shouldBeCalled()->willReturn(true);

        $this->isPasswordValid($password, 'plain-password')->shouldReturn(true);
    }
}
