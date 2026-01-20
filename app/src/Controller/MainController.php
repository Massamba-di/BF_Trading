<?php

namespace App\Controller;

use App\Repository\CategoriesRepository;
use App\Repository\VehiculesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class MainController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function index(Request $request, VehiculesRepository $vehiculesRepository, CategoriesRepository $categoriesRepository): Response


    {
        $vehicules=$vehiculesRepository->findAll();
        $categories=$categoriesRepository->findAll();

        return $this->render('main/index.html.twig', [
            'vehicules' => $vehicules,
            'categories' => $categories,
        ]);
    }
}
