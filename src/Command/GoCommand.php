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

        $post = $this->em->getRepository(Post::class)->find(1);
        $tag = $this->em->getRepository(Tag::class)->find(1);

//        $post->addTag($tag);
        $post->removeTag($tag);

        $this->em->persist($post);
        $this->em->flush();

        return Command::SUCCESS;
    }
}
