<?php
namespace App\Message;

use App\Entity\Reclamation;

class SendReclamationEmailMessage
{
    private $reclamation;

    public function __construct(Reclamation $reclamation)
    {
        $this->reclamation = $reclamation;
    }

    public function getReclamation(): Reclamation
    {
        return $this->reclamation;
    }
}
