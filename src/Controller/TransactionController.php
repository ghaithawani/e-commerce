<?php

namespace App\Controller;

use App\Entity\Transaction;
use App\Form\TransactionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
#[Route('/transaction')]
class TransactionController extends AbstractController
{
    #[Route('/', name: 'app_transaction_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $transactions = $entityManager
            ->getRepository(Transaction::class)
            ->findAll();

        return $this->render('transaction/index.html.twig', [
            'transactions' => $transactions,
        ]);
    }
 #[Route('/affichfront', name: 'app_transaction_affichfront', methods: ['GET'])]
    public function affichfront(EntityManagerInterface $entityManager): Response
    {
        $transactions = $entityManager
            ->getRepository(Transaction::class)
            ->findAll();

        return $this->render('transaction/affichfront.html.twig', [
            'transactions' => $transactions,
        ]);
    }
   #[Route('/new', name: 'app_transaction_new', methods: ['GET', 'POST'])]
public function new(Request $request, EntityManagerInterface $entityManager): Response
{
    $transaction = new Transaction();
    $form = $this->createForm(TransactionType::class, $transaction);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager->persist($transaction);
        $entityManager->flush();

        // Generate and save QR code
        //$qrCodeFilename = $this->generateAndSaveQrCode($transaction);

        // Store QR code filename in the transaction entity
       // $transaction->setQrcode($qrCodeFilename); // Corrected variable name
       // $entityManager->flush();

        return $this->redirectToRoute('app_transaction_index', [], Response::HTTP_SEE_OTHER);
    }

    return $this->renderForm('transaction/new.html.twig', [
        'transaction' => $transaction,
        'form' => $form,
    ]);
}


    // Function to generate and save QR code
 private function generateAndSaveQrCode(Transaction $transaction): string
{
    $data = "Transaction ID: " . $transaction->getTransactionid(). "- Receiver : " . $transaction->getReceiver() . "- Sender : " . $transaction->getSender() . "- Amount : " . $transaction->getAmount();

    $qrCode = new QrCode($data);
    $qrCode->setSize(300);

    $qrDirectory = $this->getParameter('kernel.project_dir') . '/public/qrcodes';
    if (!file_exists($qrDirectory)) {
        mkdir($qrDirectory, 0777, true);
    }

    $filename = 'transaction-' . $transaction->getTransactionid() . '.png';
    $writer = new PngWriter();
    // Generate the QR code and save it to a file
    $writer->write($qrCode)->saveToFile($qrDirectory . '/' . $filename);

    return $filename;
}
#[Route('/{transactionid}', name: 'app_transaction_show', methods: ['GET'])]
public function show(Transaction $transaction): Response
{
    return $this->render('transaction/show.html.twig', [
        'transaction' => $transaction,
    ]);
}

    

#[Route('/showfront/{transactionid}', name: 'app_transaction_showfront', methods: ['GET'])]
    public function showfront(Transaction $transaction): Response
    {
        return $this->render('transaction/showfront.html.twig', [
            'transaction' => $transaction,
        ]);
    }

    #[Route('/{transactionid}/edit', name: 'app_transaction_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Transaction $transaction, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TransactionType::class, $transaction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_transaction_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('transaction/edit.html.twig', [
            'transaction' => $transaction,
            'form' => $form,
        ]);
    }

    #[Route('/{transactionid}', name: 'app_transaction_delete', methods: ['POST'])]
    public function delete(Request $request, Transaction $transaction, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$transaction->getTransactionid(), $request->request->get('_token'))) {
            $entityManager->remove($transaction);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_transaction_index', [], Response::HTTP_SEE_OTHER);
    }
}
