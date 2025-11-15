<?php

namespace App\Command;

use App\Factory\PostFactory;
use App\ResponseBuilder\PostResponseBuilder;
use App\Service\PostService;
use App\Validator\PostValidator;
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
        private PostService         $postService,
        private PostValidator       $postValidator,
        private PostResponseBuilder $postResponseBuilder,
        private PostFactory         $postFactory,
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

        $storePostInputDTO = $this->postFactory->makeStorePostInputDTO($data);
        $this->postValidator->validate($storePostInputDTO);

        $post = $this->postService->store($storePostInputDTO);

        $res = $this->postResponseBuilder->storePostResponse($post);

        dd($res);

        return Command::SUCCESS;
    }
}
