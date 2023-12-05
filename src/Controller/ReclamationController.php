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
use Symfony\Component\Messenger\MessageBusInterface;
use App\Message\SendReclamationEmailMessage;


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
    private $messageBus;

    // Add MessageBusInterface to the constructor
    public function __construct(MailerInterface $mailer, MessageBusInterface $messageBus)
    {
        $this->mailer = $mailer;
        $this->messageBus = $messageBus;
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
    $email = (new \Symfony\Component\Mime\Email())  
        ->from('abdennour.amdouni@esprit.tn')
        ->to($reclamation->getEmailu())
        ->subject('Nouveau réponse sur votre réclamation reçue')
        ->html('Votre réclamation est en cour de traitement');

    $this->mailer->send($email);
}

    // private function sendReclamationEmail(Reclamation $reclamation): void
    // {
    //     // Create a message to be dispatched
    //     $message = new SendReclamationEmailMessage(
    //         'abdennour.amdouni@esprit.tn',
    //         $reclamation->getEmailu(),
    //         'Reclamation Received',
    //         'Your reclamation has been received successfully.'
    //     );
    
    //     // Dispatch the message to be handled asynchronously
    //     $this->messageBus->dispatch($message);
    // }

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

//     #[Route('/searcher', name: 'searcher', methods: ['GET'])]
// public function searching(Request $request, ReclamationRepository $reclamationRepository): Response
// {
//     $query = $request->query->get('query');
//     $reclamations = $reclamationRepository->search($query);

//     return $this->render('reclamation/index.html.twig', [
//         'reclamations' => $reclamations,
//     ]);
// }




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
#[Route('/export-reclamation-excel', name: 'export_reclamation_excel')]

public function exportToExcel(ReclamationRepository $reclamationRepository): Response
{
    // Récupérez la liste des utilisateurs depuis la base de données
    $reclamations = $reclamationRepository->findAll();

    // Créez une instance de la classe Spreadsheet
    $spreadsheet = new Spreadsheet();

    // Ajoutez les données à la feuille
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setCellValue('A1', 'ID Reclamation');
    $sheet->setCellValue('B1', 'Intitule');
    $sheet->setCellValue('C1', 'text');

    // Remplissez les données des utilisateurs
    $row = 2;
    foreach ($reclamations as $reclamation) {
        $sheet->setCellValue('A' . $row, $reclamation->getIdrec());
        $sheet->setCellValue('B' . $row, $reclamation->getIntitule());
        $sheet->setCellValue('C' . $row, $reclamation->getTextrec());
        $row++;
    }

    // Générez le fichier Excel
    $writer = new Xlsx($spreadsheet);

    // Capturez la sortie dans une variable
    ob_start();
    $writer->save('php://output');
    $excelContent = ob_get_clean();

    // Créez une réponse pour le fichier Excel
    $response = new Response();
    $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    $response->headers->set('Content-Disposition', 'attachment;filename="export_reclamation.xlsx"');
    $response->headers->set('Cache-Control', 'max-age=0');

    // Affectez la sortie à la réponse
    $response->setContent($excelContent);

    // Envoyez la réponse
    return $response;
}
}
