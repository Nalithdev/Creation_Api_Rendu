<?php


namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\Commande;
use App\Repository\CommandeRepository;
use Exception;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class PatchCommand implements ProcessorInterface
{
    public function __construct(private CommandeRepository $commandRepository,
                                #[Autowire(service: 'api_platform.doctrine.orm.state.persist_processor')]
                                private ProcessorInterface $persistProcessor
    )
    {
    }

    public function getCommande($id)
    {
        $command = $this->commandRepository->findOneById($id);

        return $command;
    }


    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {

        $command = $this->getCommande($data->getId());

        // On vérifie que la requête est bien une modification de la commande et que la commande n'est pas payée
        // si on c'est une modification de status et que le status est payée on lance une exception

        /*
        dd($command->getStatus());
         dd($command->getStatus() === "payée" || $command->getCurrentstatus() === "payée" && $data->getStatus() === "payée");*/

        if ($command->getStatus() === "payée" || $command->getCurrentstatus() === "payée" && $data->getStatus() === "payée") {
            throw new Exception('not allowed to edit command');
        }


        if ($command->getCurrentstatus() != null && $data->getCurrentstatus() != null)
        {
            $data->setStatus($data->getCurrentstatus());
            return $this->persistProcessor->process($data, $operation, $uriVariables, $context);
        };


        return $this->persistProcessor->process($data, $operation, $uriVariables, $context);
    }

}
