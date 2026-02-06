<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'app:create-user',
    description: 'Crée un utilisateur avec un mot de passe hashé et des rôles.',
)]
class CreateUserCommand extends Command
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly UserPasswordHasherInterface $passwordHasher,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('email', InputArgument::REQUIRED, 'Email de l\'utilisateur')
            ->addArgument('password', InputArgument::REQUIRED, 'Mot de passe en clair (sera hashé)')
            ->addArgument('roles', InputArgument::OPTIONAL, 'Rôles séparés par des virgules (ex: ROLE_ADMIN,ROLE_USER)', 'ROLE_USER')
            ->addArgument('first_name', InputArgument::OPTIONAL, 'Prénom de l\'utilisateur', '')
            ->addArgument('last_name', InputArgument::OPTIONAL, 'Nom de l\'utilisateur', '')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $email = (string) $input->getArgument('email');
        $plainPassword = (string) $input->getArgument('password');
        $roleString = (string) $input->getArgument('roles');
        $firstName = (string) $input->getArgument('first_name');
        $lastName = (string) $input->getArgument('last_name');

        // On découpe la chaîne "ROLE_ADMIN,ROLE_USER" en tableau ["ROLE_ADMIN", "ROLE_USER"]
        $roles = array_map('trim', explode(',', $roleString));
        $roles = array_values(array_filter($roles));

        $user = new User();
        $user->setEmail($email);
        $user->setRoles($roles);
        $user->setFirstName($firstName);
        $user->setLastName($lastName);
        $user->setCreateAt(new \DateTimeImmutable());

        // Le mot de passe est hashé avant l'enregistrement.
        $hashedPassword = $this->passwordHasher->hashPassword($user, $plainPassword);
        $user->setPassword($hashedPassword);

        // persist = Doctrine prépare l'insertion
        // flush = Doctrine exécute réellement l'insertion en base
        $this->em->persist($user);
        $this->em->flush();

        $output->writeln('Utilisateur créé : '.$email);
        $output->writeln('Rôles : '.implode(', ', $roles));

        return Command::SUCCESS;
    }
}
