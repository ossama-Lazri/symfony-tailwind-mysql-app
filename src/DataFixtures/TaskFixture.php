<?php

namespace App\DataFixtures;

use App\Entity\Task;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TaskFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i <= 10; $i++) {
            $task = new Task();
            $task->setTitle('Task title : ' . $i);
            $task->setBody('Task body : ' . $i);
            $manager->persist($task);
        }

        $manager->flush();
    }
}
