<?php

namespace App\Controller\Api;

use App\Entity\Banner;
use App\Repository\BannerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api', name: 'api_')]
class BannerController extends AbstractController
{
    #[Route('/banners', name: 'banners', methods:['GET'])]
    public function getBanner(BannerRepository $bannerRepository, SerializerInterface $serializer): JsonResponse
    {
        $banner = $bannerRepository->findAll();

        $bannerSerialized = $serializer->serialize($banner, 'json', ['groups' => 'GetBanner']);

        return new JsonResponse($bannerSerialized, Response::HTTP_OK, [], true);
    }

    #[Route('/banner/{id}', name:'api_detail_banner', methods:'GET')]
    public function getDetailBanner(Banner $banner, SerializerInterface $serializer): JsonResponse
    {
        $detailBanner = $serializer->serialize($banner, 'json', ['groups' => 'GetBanner']);

        return new JsonResponse($detailBanner, 200, [], true);
    }

}
