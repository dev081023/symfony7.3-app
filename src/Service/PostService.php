<?php

namespace App\Service;

use App\DTO\Input\Post\StorePostInputDTO;
use App\DTO\Input\Post\UpdatePostInputDTO;
use App\Entity\Post;
use App\Factory\PostFactory;
use App\Repository\PostRepository;

class PostService
{

    public function __construct(
        private PostRepository $postRepository,
        private PostFactory    $postFactory,
    )
    {
    }

    public function index(): array
    {
        return $this->postRepository->findAll();
    }

    public function store(StorePostInputDTO $storePostInputDTO): Post
    {
        $post = $this->postFactory->makePost($storePostInputDTO);

        return $this->postRepository->store($post);
    }

    public function update(Post $post, UpdatePostInputDTO $updatePostInputDTO): Post
    {
        $post = $this->postFactory->editPost($post, $updatePostInputDTO);

        return $this->postRepository->update($post);
    }
}
