<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Wallet;
use App\Entity\WalletTransferParticipant;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    /**
     * AppFixtures constructor.
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 10; ++$i) {
            $wallet = new Wallet(new WalletTransferParticipant());
            $wallet->setAmount(rand(0, 1500));

            $user = new User();
            $user
                ->setUsername(sprintf('User_%02d', $i + 1))
                ->setPassword($this->passwordEncoder->encodePassword($user, 'pass'))
                ->setRoles([User::ROLE_USER])
                ->setWallet($wallet);

            $manager->persist($user);
        }

        $manager->flush();
    }
}
