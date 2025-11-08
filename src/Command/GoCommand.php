<?php

namespace App\Command;

use App\Entity\Post;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'go',
    description: 'Add a short description for your command',
)]
class GoCommand extends Command
{
    public function __construct(
        private PostRepository         $postRepository,
        private EntityManagerInterface $em,
    )
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        $data = [
            'title' => 'Title',
            'description' => 'Description',
            'content' => 'Content',
            'published_at' => '2020-12-12',
            'status' => 2,
            'category_id' => 1,
        ];

        $post = new Post();

        $post->setTitle($data['title']);
        $post->setDescription($data['description']);
        $post->setContent($data['content']);
        $post->setPublishedAt($data['published_at']);
        $post->setStatus($data['status']);
        $post->setCategory($data['category_id']);

        $this->em->persist($post);
        $this->em->flush();

        return Command::SUCCESS;
    }
}
