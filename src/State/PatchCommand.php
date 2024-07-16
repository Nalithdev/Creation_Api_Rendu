<?php


namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\Commande;
use Exception;

class PatchCommand implements ProcessorInterface
{

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        $command = Commande::class->find($data->Command->getId());

        // On vérifie que le status est bien "en attente"
        if ($command->getStatus() === "payée") {
            throw new Exception('not allowed to edit command');
        }
        return $this->process($data, $operation, $uriVariables, $context);
    }
}
