<?php

namespace App\Controller\Api;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api', name: 'api_')]
class ProductController extends AbstractController
{
    #[Route('/products', name: 'products', methods: ['GET'])]
    public function getProducts(ProductRepository $productRepository, SerializerInterface $serializer): JsonResponse
    {
        $product = $productRepository->findAll();
        $productSerialized = $serializer->serialize($product, 'json', ['groups' => 'GetBanner']);

        return new JsonResponse($productSerialized, Response::HTTP_OK, [], true);
    }

    #[Route('/product/{id}', name: 'detailProduct', methods: ['GET'])]
    public function getDetailProduct(Product $product, SerializerInterface $serializer): JsonResponse
    {
        $productSerialized = $serializer->serialize($product, 'json', ['groups' => 'GetProduct']);

        return new JsonResponse($productSerialized, Response::HTTP_OK, [], true);
    }

    #[Route('/product/{id}', name: 'deleteProduct', methods: ['DELETE'])]
    public function deleteProduct(Product $product, EntityManagerInterface $em): JsonResponse
    {
        $em->remove($product);
        $em->flush();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

    #[Route('/product/edit/{id}', name: 'editProduct', methods: ['PUT'])]
    public function editProduct(
        Request $request, 
        Product $product, 
        EntityManagerInterface $em,
        SerializerInterface $serializer
    ): JsonResponse
    {
        $serializer->deserialize(
            $request->getContent(), 
            Product::class, 
            'json', 
            [AbstractNormalizer::OBJECT_TO_POPULATE => $product]
        );
        $em->flush();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

    #[Route('/product/create', name: 'createProduct', methods: ['POST'])]
    public function createProduct(
        Request $request, 
        SerializerInterface $serializer,
        EntityManagerInterface $em,
        ValidatorInterface $validator
    ): JsonResponse
    {
        $product = $request->getContent();
        $object = $serializer->deserialize($product, Product::class, 'json');

        $errors = $validator->validate($object);
        if ($errors->count() > 0) {
            return new JsonResponse(
                $serializer->serialize($errors, 'json'), 
                JsonResponse::HTTP_BAD_REQUEST, 
                [], 
                true
            );
        }

        $em->persist($object);
        $em->flush();

        return new JsonResponse('success', Response::HTTP_CREATED);
    }
}
