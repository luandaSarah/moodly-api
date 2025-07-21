<?php

namespace App\Controller;

use App\Entity\Moodboard;
use App\Entity\UserAvatar;
use App\Service\S3Service;
use App\Entity\MoodboardImage;
use App\Repository\MoodboardImageRepository;
use App\Repository\UserInfoRepository;
use App\Repository\UserAvatarRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('api', name: 'api_upload_')]
class ImageController extends AbstractController
{

   public function __construct(
      private UserInfoRepository $userInfoRepository,
      private UserAvatarRepository $userAvatarRepository,
      private MoodboardImageRepository $moodboardImageRepository,
      private EntityManagerInterface $em,
   ) {}


   public function extractKeyFromUrl(string $imgUrl): string
   {

      return str_replace($_ENV['S3_BASE_URL'], '', $imgUrl);
   }

   #[Route('/profile/avatar', name: 'avatar', methods: ['POST'])]
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

      $image = $request->files->get('images');

      if (!$image) {
         return $this->json(
            ['error' => 'Aucune image fournie.'],
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

   #[Route('/moodboards/{id}/image', name: 'moodboard', methods: ['POST'])]
   public function uploadMoodboardImage(
      Moodboard $moodboard,
      Request $request,
      S3Service $s3Service

   ): JsonResponse {

      if (!$moodboard) {
         return $this->json(['error' => 'Moodboard introuvable'], Response::HTTP_NOT_FOUND);
      }

      $images = $request->files->all('images');

      if (count($images) <= 0) {
         return $this->json(['error' => 'Aucune image fournie.'], Response::HTTP_BAD_REQUEST);
      }

      $existingMoodboardImg = count($moodboard->getMoodboardImages());
      if ($existingMoodboardImg + count($images) > 4) {
         return $this->json(['error' => 'Un moodboard ne peut pas contenir plus de 4 images.'], Response::HTTP_BAD_REQUEST);
      }


      try {
         $allImages = [];

         foreach ($images as $image) {
            if (!$image instanceof UploadedFile) {
               continue;
            }

            $imageUrl =  $s3Service->upload($image, 'moodboards');
            $moodboardImage = new MoodboardImage();
            $moodboardImage->setImageUrl($imageUrl);
            $moodboardImage->setMoodboard($moodboard);

            $allImages[] = $moodboardImage;
            $this->em->persist($moodboardImage);
         }



         $this->em->flush();



         return $this->json(
            $allImages,
            status: Response::HTTP_CREATED,
            context: [
               'groups' => ['moodboard:image'],
            ]
         );
      } catch (\Exception $e) {
         return $this->json(
            ['error' => $e->getMessage()],
            Response::HTTP_INTERNAL_SERVER_ERROR,
         );
      }
   }
}
