<?php

namespace App\Command;

use App\Entity\Category;
use App\Entity\Post;
use App\ResponseBuilder\PostResponseBuilder;
use App\Service\PostService;
use App\Validator\PostValidator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'go',
    description: 'Add a short description for your command',
)]
class GoCommand extends Command
{
    public function __construct(
        private EntityManagerInterface $em,
        private PostService            $postService,
        private PostValidator          $postValidator,
        private PostResponseBuilder    $postResponseBuilder,
    )
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        $data = [
            'title' => 'Title another',
            'description' => 'Description edited',
            'content' => 'Content edited',
            'published_at' => '2020-12-30',
            'status' => 3,
            'category_id' => 1,
        ];

        $category = $this->em->getReference(Category::class, $data['category_id']);
        $post = new Post();

        $post->setTitle($data['title']);
        $post->setDescription($data['description']);
        $post->setContent($data['content']);
        $post->setPublishedAt(new \DateTimeImmutable($data['published_at']));
        $post->setStatus($data['status']);
        $post->setCategory($category);

        $this->postValidator->validate($post);

        $post = $this->postService->store($post);

        $res = $this->postResponseBuilder->storePostResponse($post);

        dd($res);

        return Command::SUCCESS;
    }
}
