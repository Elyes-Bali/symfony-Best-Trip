<?php

namespace App\Controller;
use App\Entity\Reclamation;
use App\Entity\Reponsereclamation;
use App\Form\ReponsereclamationType;
use App\Repository\ReponsereclamationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Messenger\MessageBusInterface;
use App\Message\SendReclamationEmailMessage;
use Psr\Log\LoggerInterface;

#[Route('/reponsereclamation')]
class ReponsereclamationController extends AbstractController
{
    #[Route('/', name: 'app_reponsereclamation_index', methods: ['GET'])]
    public function index(ReponsereclamationRepository $reponsereclamationRepository): Response
    {
        return $this->render('reponsereclamation/index.html.twig', [
            'reponsereclamations' => $reponsereclamationRepository->findAll(),
        ]);
    }

private $mailer;
private $messageBus;

// Add MessageBusInterface to the constructor
public function __construct(MailerInterface $mailer, MessageBusInterface $messageBus)
{
    $this->mailer = $mailer;
    $this->messageBus = $messageBus;
}

    #[Route('/new/{idrec}', name: 'app_reponsereclamation_new', methods: ['GET', 'POST'])]
public function new(Request $request, EntityManagerInterface $entityManager, $idrec): Response
{
    $reponsereclamation = new Reponsereclamation();

    // Assuming you have a method to find a reclamation by ID in your repository
    $reclamation = $entityManager->getRepository(Reclamation::class)->find($idrec);

    // Set the associated reclamation
    $reponsereclamation->setIdrec($reclamation);
    /** @noinspection PhpParamsInspection */
    $reponsereclamation->emailu = $reclamation->getEmailu();

    $form = $this->createForm(ReponsereclamationType::class, $reponsereclamation);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager->persist($reponsereclamation);
        $entityManager->flush();
        $this->sendReclamationEmail($reclamation->getEmailu(), $reclamation->getIntitule());

        return $this->redirectToRoute('app_reponsereclamation_index', [], Response::HTTP_SEE_OTHER);
    }

    return $this->renderForm('reponsereclamation/new.html.twig', [
        'emailu' => $reclamation->getEmailu(),
        'reponsereclamation' => $reponsereclamation,
        'form' => $form,
    ]);
}

// private function sendReclamationEmail(string $email, string $reclamationIntitule): void
// {
//     try {
//         $email = (new \Symfony\Component\Mime\Email())  
//             ->from('abdennour.amdouni@esprit.tn')
//             ->to($email)
//             ->subject('Nouvelle réponse sur votre réclamation : ' . $reclamationIntitule)
//             ->html('Votre réclamation a reçu une nouvelle réponse.');

//         $this->mailer->send($email);
//     } catch (\Exception $e) {
//         // Log the error
//         $this->logger->error('Error sending email: ' . $e->getMessage());
//     }
// }

private function sendReclamationEmail(Reclamation $reclamation): void
{
    $email = (new \Symfony\Component\Mime\Email())  
        ->from('abdennour.amdouni@esprit.tn')
        ->to($reclamation->getEmailu())  // Use $reclamation->getEmailu() instead of $email
        ->subject('Nouvelle réponse sur votre réclamation : ' . $reclamation->getIntitule())
        ->html('Your reclamation has been received successfully.');

    $this->mailer->send($email);
}



    #[Route('/{idreprec}', name: 'app_reponsereclamation_show', methods: ['GET'])]
    public function show(Reponsereclamation $reponsereclamation): Response
    {
        return $this->render('reponsereclamation/show.html.twig', [
            'reponsereclamation' => $reponsereclamation,
        ]);
    }

    #[Route('/{idreprec}/edit', name: 'app_reponsereclamation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Reponsereclamation $reponsereclamation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ReponsereclamationType::class, $reponsereclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_reponsereclamation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reponsereclamation/edit.html.twig', [
            'reponsereclamation' => $reponsereclamation,
            'form' => $form,
        ]);
    }

    #[Route('/{idreprec}', name: 'app_reponsereclamation_delete', methods: ['POST'])]
    public function delete(Request $request, Reponsereclamation $reponsereclamation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reponsereclamation->getIdreprec(), $request->request->get('_token'))) {
            $entityManager->remove($reponsereclamation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_reponsereclamation_index', [], Response::HTTP_SEE_OTHER);
    }

    
}
