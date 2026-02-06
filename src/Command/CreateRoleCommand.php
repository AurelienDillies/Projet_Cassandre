<?php

namespace App\Command;

use App\Entity\Role;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:create-role',
    description: 'Crée un rôle (entité Role) en base',
)]
class CreateRoleCommand extends Command
{
    public function __construct(private readonly EntityManagerInterface $em)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('name', InputArgument::REQUIRED, 'Nom du rôle (ex: admin)')
            ->addArgument('description', InputArgument::REQUIRED, 'Description du rôle');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $name = trim((string) $input->getArgument('name'));
        $description = (string) $input->getArgument('description');

        $repo = $this->em->getRepository(Role::class);
        $existing = $repo->findOneBy(['name' => $name]);

        if ($existing) {
            $output->writeln(sprintf('<error>Le rôle "%s" existe déjà en base.</error>', $name));
            return Command::FAILURE;
        }

        $role = new Role();
        $role->setName($name);
        $role->setDescription($description);

        $this->em->persist($role);
        $this->em->flush();

        $output->writeln(sprintf('<info>Rôle "%s" créé avec succès.</info>', $name));

        return Command::SUCCESS;
    }
}
