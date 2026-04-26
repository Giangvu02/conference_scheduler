<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route('/products', name: 'product_list')]
    public function index(ProductRepository $repo): Response
    {
        return $this->render('product/index.html.twig', [
            'products' => $repo->findAll()
        ]);
    }

    #[Route('/product/create', name: 'product_create')]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $product = new Product();

        if ($request->isMethod('POST')) {
            $product->setName($request->request->get('name'));
            $product->setPrice($request->request->get('price'));
            $product->setDescription($request->request->get('description'));

            $em->persist($product);
            $em->flush();

            return $this->redirectToRoute('product_list');
        }

        return $this->render('product/create.html.twig');
    }

    #[Route('/product/edit/{id}', name: 'product_edit')]
    public function edit($id, Request $request, ProductRepository $repo, EntityManagerInterface $em)
    {
        $product = $repo->find($id);

        if ($request->isMethod('POST')) {
            $product->setName($request->request->get('name'));
            $product->setPrice($request->request->get('price'));
            $product->setDescription($request->request->get('description'));

            $em->flush();

            return $this->redirectToRoute('product_list');
        }

        return $this->render('product/edit.html.twig', [
            'product' => $product
        ]);
    }

    #[Route('/product/delete/{id}', name: 'product_delete')]
    public function delete($id, ProductRepository $repo, EntityManagerInterface $em)
    {
        $product = $repo->find($id);

        $em->remove($product);
        $em->flush();

        return $this->redirectToRoute('product_list');
    }
}