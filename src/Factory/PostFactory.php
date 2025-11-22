<?php

namespace App\Factory;

use App\DTO\Input\Post\StorePostInputDTO;
use App\DTO\Input\Post\UpdatePostInputDTO;
use App\DTO\Output\Post\PostOutputDTO;
use App\Entity\Category;
use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;

class PostFactory
{

    public function __construct(
        private EntityManagerInterface $em,
    )
    {
    }

    public function makePost(StorePostInputDTO $storePostInputDTO): Post
    {
        $category = $this->em->getReference(Category::class, $storePostInputDTO->categoryId);
        $post = new Post();

        $post->setTitle($storePostInputDTO->title);
        $post->setDescription($storePostInputDTO->description);
        $post->setContent($storePostInputDTO->content);
        $post->setPublishedAt($storePostInputDTO->publishedAt);
        $post->setStatus($storePostInputDTO->status);
        $post->setCategory($category);

        return $post;
    }

    public function editPost(Post $post, UpdatePostInputDTO $updatePostInputDTO): Post
    {
        $category = $this->em->getReference(Category::class, $updatePostInputDTO->categoryId);

        $post->setTitle($updatePostInputDTO->title);
        $post->setDescription($updatePostInputDTO->description);
        $post->setContent($updatePostInputDTO->content);
        $post->setPublishedAt($updatePostInputDTO->publishedAt);
        $post->setStatus($updatePostInputDTO->status);
        $post->setCategory($category);

        return $post;
    }

    public function makeStorePostInputDTO(array $data): StorePostInputDTO
    {
        $post = new StorePostInputDTO();

        $post->title = $data['title'] ?? null;
        $post->description = $data['description'] ?? null;
        $post->content = $data['content'];
        $post->publishedAt = new \DateTimeImmutable($data['published_at'] ?? null);
        $post->status = $data['status'] ?? null;
        $post->categoryId = $data['category_id'] ?? null;

        return $post;
    }

    public function makeUpdatePostInputDTO(array $data): UpdatePostInputDTO
    {
        $post = new UpdatePostInputDTO();

        $post->title = $data['title'] ?? null;
        $post->description = $data['description'] ?? null;
        $post->content = $data['content'];
        $post->publishedAt = new \DateTimeImmutable($data['published_at'] ?? null);
        $post->status = $data['status'] ?? null;
        $post->categoryId = $data['category_id'] ?? null;

        return $post;
    }

    public function makePostOutputDTO(Post $post): PostOutputDTO
    {
        $postOutput = new PostOutputDTO();

        $postOutput->id = $post->getId();
        $postOutput->title = $post->getTitle();
        $postOutput->description = $post->getDescription();
        $postOutput->content = $post->getContent();
        $postOutput->publishedAt = $post->getPublishedAt();
        $postOutput->status = $post->getStatus();
        $postOutput->category = $post->getCategory();

        return $postOutput;
    }

    public function makePostOutputDTOs(array $posts): array
    {
        return array_map(fn($post) => $this->makePostOutputDTO($post), $posts);
    }
}
