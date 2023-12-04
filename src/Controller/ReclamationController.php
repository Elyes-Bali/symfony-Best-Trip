<?php

namespace App\Controller;

use App\Entity\Reclamation;
use App\Form\ReclamationType;
use App\Repository\ReclamationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

#[Route('/reclamation')]
class ReclamationController extends AbstractController
{
    #[Route('/', name: 'app_reclamation_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $reclamations = $entityManager
            ->getRepository(Reclamation::class)
            ->findAll();
            // Additional logic to get statistics data
            $percentageData = $this->calculateReclamationsPerUserPercentage($reclamations);

            
        return $this->render('reclamation/index.html.twig', [
            'reclamations' => $reclamations,
            'percentageData' => $percentageData,
                ]);
    }

    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    #[Route('/new', name: 'app_reclamation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $reclamation = new Reclamation();
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Replace bad words in intitule and textrec
            $reclamation->setIntitule($this->replaceBadWords($reclamation->getIntitule()));
            $reclamation->setTextrec($this->replaceBadWords($reclamation->getTextrec()));
            
            $entityManager->persist($reclamation);
            $entityManager->flush();
            $this->sendReclamationEmail($reclamation);

            return $this->redirectToRoute('app_reclamation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reclamation/new.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form,
        ]);
    }

    private function sendReclamationEmail(Reclamation $reclamation): void
    {
        $email = (new Email())
            ->from('abdennour.amdouni@esprit.tn')
            ->to($reclamation->getEmailu())
            ->subject('Reclamation Received')
            ->html('Your reclamation has been received successfully.');

        $this->mailer->send($email);
    }

    private function replaceBadWords($text)
    {
        // Define a list of bad words (you can extend this list)
        $badWords = array('sex', "mauvais mot", "débile", "bete", "stupid", "un con","hot","sexy", "chaud", "viagra", "cure", "sexuel", "amour");

        // Replace bad words with stars
        foreach ($badWords as $word) {
            // Replace case-insensitive occurrences with stars
            $text = preg_replace("/\b$word\b/i", str_repeat('*', strlen($word)), $text);
        }

        return $text;
    }



    #[Route('/{idrec}', name: 'app_reclamation_show', methods: ['GET'])]
    public function show(Reclamation $reclamation): Response
    {
        return $this->render('reclamation/show.html.twig', [
            'reclamation' => $reclamation,
        ]);
    }

    #[Route('/{idrec}/edit', name: 'app_reclamation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Reclamation $reclamation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_reclamation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reclamation/edit.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form,
        ]);
    }

    #[Route('/{idrec}', name: 'app_reclamation_delete', methods: ['POST'])]
    public function delete(Request $request, Reclamation $reclamation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reclamation->getIdrec(), $request->request->get('_token'))) {
            $entityManager->remove($reclamation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_reclamation_index', [], Response::HTTP_SEE_OTHER);
    }


    #[Route('/reclamation', name:'form')]
    public function Dashboard(): Response
    {
        return $this->render('/reclamation/_form.html.twig');
    }

    #[Route('/searcher', name: 'searcher', methods: ['GET'])]
public function searching(Request $request, ReclamationRepository $reclamationRepository): Response
{
    $query = $request->query->get('query');
    $reclamations = $reclamationRepository->search($query);

    return $this->render('reclamation/index.html.twig', [
        'reclamations' => $reclamations,
    ]);
}

    /**
     * @Route("/search/back", name="emailuajax", methods={"GET"})
     */
    public function searchouserajax(Request $request, ReclamationRepository $reclamationRepository): Response
    {
        $reclamationRepository = $this->getDoctrine()->getRepository(Reclamation::class);
        $requestString = $request->get('searchValue');
        $Reclamation = $reclamationRepository->findemailu($requestString);

        return $this->render('reclamation/index.html.twig', [
            "reclamations" => $Reclamation
        ]);
    }
    
   // New method to calculate statistics
   private function calculateReclamationsPerUserPercentage(array $reclamations): array
{
    $userCounts = [];
    foreach ($reclamations as $reclamation) {
        $userId = $reclamation->getIdu();
        $userCounts[$userId] = ($userCounts[$userId] ?? 0) + 1;
    }

    $totalReclamations = count($reclamations);
    $percentageData = [];

    foreach ($userCounts as $userId => $count) {
        $percentage = ($count / $totalReclamations) * 100;
        $percentageData[] = ['userId' => $userId, 'percentage' => $percentage];
    }

    return $percentageData;
}
 
}
