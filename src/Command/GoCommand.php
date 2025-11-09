<?php

namespace App\Command;

use App\Entity\Category;
use App\Entity\Post;
use App\Entity\Tag;
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
    )
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        $data = [
            'title' => 'Title edited',
            'description' => 'Description edited',
            'content' => 'Content edited',
            'published_at' => '2020-12-30',
            'status' => 3,
            'category_id' => 1,
        ];

        $category = $this->em->getReference(Category::class, $data['category_id']);

        $post = new Post();
        $post->setCategory($category);

        $this->em->persist($post);
        $this->em->flush();

        return Command::SUCCESS;
    }
}
