<?php


namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\Commande;
use App\Repository\CommandeRepository;
use Doctrine\ORM\EntityManager;
use Exception;

class PatchCommand implements ProcessorInterface
{

    public function getCommand($id, CommandeRepository $commandeRepository): array
    {
        $commande = $commandeRepository->findBy($id);
        return $commande;
    }

    public function process( mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {

        $command = $this->getCommand($data->getId());

        // On vérifie que le status est bien "en attente"
        if ($command->getStatus() === "payée") {
            throw new Exception('not allowed to edit command');
        }
        return $this->process($data, $operation, $uriVariables, $context);
    }
}
