<?php

namespace App\Controller;

use App\Entity\Advert;
use App\Entity\Category;
use App\Repository\CardModelRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;


#[Route("/api/adverts")]
class AdvertController extends AbstractController
{
    private $entityManager;
    private $serializer;

    public function __construct(EntityManagerInterface $entityManager, SerializerInterface $serializer)
    {
        $this->entityManager = $entityManager;
        $this->serializer = $serializer;
    }


    #[Route("/", name: 'api_advert_index', methods: ['GET'])]
    public function index(): JsonResponse
    {
        $advertRepository = $this->entityManager->getRepository(Advert::class);
        $adverts = $advertRepository->findAll();

        $jsonAdverts = $this->serializer->serialize($adverts, 'json', ['groups' => 'advert']);

        return new JsonResponse($jsonAdverts, Response::HTTP_OK);
    }


    #[Route("/new", name: 'api_advert_new', methods: ['POST'])]
    public function new(Request $request): JsonResponse
    {
        try {
            $data = $this->serializer->deserialize($request->getContent(), Advert::class, 'json');
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \InvalidArgumentException('Invalid JSON data');
            }
            $categoryInput = json_decode($request->getContent(), true);
            $categoryRepo = $this->entityManager->getRepository(Category::class);
            $category = $categoryRepo->findOneBy(['name' => $categoryInput['category']]);

            if (!$category) {
                throw new \InvalidArgumentException('Category not found');
            }

            $data->setCategory($category);

            $this->entityManager->persist($data);
            $this->entityManager->flush();

            $advert = $this->serializer->serialize($data, 'json', ['groups' => 'list_advert']);

            return new JsonResponse($advert, JsonResponse::HTTP_CREATED);
        } catch (\InvalidArgumentException $e) {
            return new JsonResponse($e->getMessage(), JsonResponse::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            // Handle other unexpected exceptions, log the error, and return an error response.
            return new JsonResponse('An error occurred: ' . $e->getMessage(), JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    #[Route("/{id}", name: 'api_advert_show', methods: ['GET'])]
    public function show($id, Request $request): JsonResponse
    {
        try {
            $advert = $this->entityManager->getRepository(Advert::class)->find($id);

            if ($advert === null) {
                throw $this->createNotFoundException('Advert not found');
            }
            $jsonAdvert = $this->serializer->serialize($advert, 'json', ['groups' => 'list_advert']);

            return new JsonResponse($jsonAdvert, JsonResponse::HTTP_OK, [], true);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], JsonResponse::HTTP_NOT_FOUND);
        }
    }

    #[Route("/{id}", name: 'api_advert_edit', methods: ['PUT'])]
    public function edit(Request $request, Advert $advert): Response
    {
        try {
            $data = json_decode($request->getContent(), true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \InvalidArgumentException('Invalid JSON data');
            }

            $categoryRepo = $this->entityManager->getRepository(Category::class);
            $category = $categoryRepo->findOneBy(['name' => $data['category']]);

            if (!$category) {
                throw new \InvalidArgumentException('Category not found');
            }

            $advert->setTitle($data['title']);
            $advert->setContent($data['content']);
            $advert->setCategory($category);

            $this->entityManager->persist($advert);
            $this->entityManager->flush();

            return new JsonResponse($advert, JsonResponse::HTTP_OK);
        } catch (\InvalidArgumentException $e) {
            return new JsonResponse($e->getMessage(), JsonResponse::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            // Handle other unexpected exceptions, log the error, and return an error response.
            return new JsonResponse('An error occurred: ' . $e->getMessage(), JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    #[Route("/{id}", name: 'api_advert_delete', methods: ['DELETE'])]
    public function delete(Advert $advert): Response
    {
        try {
            $this->entityManager->remove($advert);
            $this->entityManager->flush();

            return new Response(null, Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            // Handle unexpected exceptions, log the error, and return an error response.
            return new Response('An error occurred: ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    #[Route("/recherche/{slug}", name: 'slug', methods: ['POST'])]
    public function associateBrandModel(string $slug, CardModelRepository $cardModelRepository): JsonResponse
    {
        $result = [];

        // Define a pattern to extract words from the slug, allowing for spaces and digits
        $wordPattern = '/\b\w+(?:\s\d+\s\w+)*\b/';

        // Use preg_match_all to extract words from the slug
        preg_match_all($wordPattern, iconv('UTF-8', 'ASCII//TRANSLIT', $slug), $matches);

        // Extracted words from the pattern
        $words = $matches[0];
        foreach ($words as $word) {

            $knownModels = $cardModelRepository->findCarModelSearchQuery(str_replace(' ', '', $word));

            // Check if any known models were found
            if (!empty($knownModels)) {
                // Append brand and model names to the result
                foreach ($knownModels as $model) {
                    $result[] = [
                        'Marque' => $model['brandName'],
                        'Modele' => $model['modelName'],
                    ];
                }
            }
        }

        // Return response based on the result
        if (!empty($result)) {
            return new JsonResponse($result, JsonResponse::HTTP_OK);
        }

        return new JsonResponse('No known models found in the slug', JsonResponse::HTTP_NOT_FOUND);
    }


}
