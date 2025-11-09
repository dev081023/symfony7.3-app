<?php

namespace App\Service;

use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;

class PostService
{

    public function __construct(
        private EntityManagerInterface $em,
    )
    {
    }

    public function store(Post $post): Post
    {
        $this->em->persist($post);
        $this->em->flush();

        return $post;
    }
}
