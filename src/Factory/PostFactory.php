<?php

namespace App\Factory;

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

    public function makePost(array $data): Post
    {
        $category = $this->em->getReference(Category::class, $data['category_id']);
        $post = new Post();

        $post->setTitle($data['title']);
        $post->setDescription($data['description']);
        $post->setContent($data['content']);
        $post->setPublishedAt(new \DateTimeImmutable($data['published_at']));
        $post->setStatus($data['status']);
        $post->setCategory($category);

        return $post;
    }
}
