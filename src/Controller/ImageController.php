<?php

namespace App\Controller;

use App\Entity\UserAvatar;
use App\Service\S3Service;
use App\Repository\UserInfoRepository;
use App\Repository\UserAvatarRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('api/upload', name: 'api_upload_')]
class ImageController extends AbstractController
{

   public function __construct(
      private UserInfoRepository $userInfoRepository,
      private UserAvatarRepository $userAvatarRepository,
      private EntityManagerInterface $em,
   ) {}


   public function extractKeyFromUrl(string $imgUrl): string
   {

      return str_replace($_ENV['S3_BASE_URL'], '', $imgUrl);
   }

   #[Route('/profile-avatar', name: 'avatar', methods: ['POST'])]
   public function uploadAvatar(
      Request $request,
      S3Service $s3Service
   ): JsonResponse {

      $ConnectedUser = $this->getUser();
      $email = $ConnectedUser->getUserIdentifier();

      $user = $this->userInfoRepository->findOneBy(['email' => $email]);


      if (!$user) {
         return $this->json(
            [
               'error' => 'L\'utilisateur n\'existe pas ou n\'est pas connecté'
            ],
            Response::HTTP_UNAUTHORIZED
         );
      }

      $image = $request->files->get('image');

      if (!$image) {
         return $this->json(
            ['error' => 'No image uploaded'],
            Response::HTTP_BAD_REQUEST,
         );
      }

      try {
         $userAvatarAlreadyExist = $this->userAvatarRepository->findOneBy(['user' => $user]);
         // dd($userAvatarAlreadyExist);
         if ($userAvatarAlreadyExist) {
            $previewsAvatarKey = $this->extractKeyFromUrl($userAvatarAlreadyExist->getAvatarUrl());
            $s3Service->delete($previewsAvatarKey);
            $user->setUserAvatar(null);
            $this->em->remove($userAvatarAlreadyExist);
            $this->em->flush();
         }

         $avatarUrl = $s3Service->upload($image, 'avatar');
         $userAvatar = new UserAvatar();
         $userAvatar->setAvatarUrl($avatarUrl);
         $userAvatar->setUser($user);
         $this->em->persist($userAvatar);
         $this->em->flush();


         return $this->json(
            $userAvatar,
            status: Response::HTTP_CREATED,
            context: [
               'groups' => ['common:index'],
            ]
         );
      } catch (\Exception $e) {
         return $this->json(
            ['error' => $e->getMessage()],
            Response::HTTP_INTERNAL_SERVER_ERROR,
         );
      }
   }

   // #[Route('/moodboard-images', name: 'moodboard', methods: ['POST'])]
   // public function uploadAvatar(
   //    Request $request,
   //    S3Service $s3Service
   // ): JsonResponse {

   // }
}
