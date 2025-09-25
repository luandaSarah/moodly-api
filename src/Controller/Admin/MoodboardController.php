<?php

namespace App\Controller\Admin;

use App\Dto\Filter\PaginationFilterDto;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('api/admin', 'api_admin_moodboards_')]
class MoodboardController extends AbstractController
{

}
