<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/book")
 */
class BookController extends AbstractController
{
    private $bookRepository;

    public function __construct(BookRepository $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    /**
     * @Route("/", name="app_book_index", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('book/index.html.twig', [
            'books' => $this->bookRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_book_new", methods={"GET","POST"})
     */
    public function new(Request $request, BookRepository $bookRepository): Response
    {
        $book = new Book();
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $book->setPictureFile($form->get('pictureFile')->getData());
            $book->uploadPicture();

            $existingBook = $bookRepository->findOneBy(['isbn' => $book->getIsbn()]);
            if ($existingBook) {
                $this->addFlash('error', 'ISBN already exists!');
                return $this->redirectToRoute('app_book_new');
            } else {
                $bookRepository->add($book, true);
                return $this->redirectToRoute('app_book_index', [], Response::HTTP_SEE_OTHER);
            }
        }

        return $this->renderForm('book/new.html.twig', [
            'book' => $book,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{isbn}", name="app_book_show", methods={"GET"})
     */
    public function show(string $isbn, BookRepository $bookRepository): Response
    {
        $book = $bookRepository->findOneBy(['isbn' => $isbn]);

        if (!$book) {
            # throw $this->createNotFoundException('Le livre que vous recherchez n\'existe pas.');
            $content = $this->render('errors/error404.html.twig');
            return new Response($content, Response::HTTP_NOT_FOUND);
        }

        return $this->render('book/show.html.twig', [
            'book' => $book,
        ]);
    }

    /**
     * @Route("/{isbn}/edit", name="app_book_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Book $book, BookRepository $bookRepository, string $isbn): Response
    {

        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        $book = $bookRepository->findOneBy(['isbn' => $isbn]);
        if (!$book) {
            # throw $this->createNotFoundException('Le livre que vous recherchez n\'existe pas.');
            $content = $this->render('errors/error404.html.twig');
            return new Response($content, Response::HTTP_NOT_FOUND);
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $this->bookRepository->add($book, true);
            return $this->redirectToRoute('app_book_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('book/edit.html.twig', [
            'book' => $book,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_book_delete", methods={"POST"})
     */
    public function delete(Request $request, Book $book): Response
    {
        if ($this->isCsrfTokenValid('delete'.$book->getId(), $request->request->get('_token'))) {
            $this->bookRepository->remove($book, true);
        }

        return $this->redirectToRoute('app_book_index', [], Response::HTTP_SEE_OTHER);
    }
}
