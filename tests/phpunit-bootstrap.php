<?php

declare(strict_types=1);

use Odandb\MonitoringMetricsBundle\Tests\Fixtures\Entity\Person;
use Odandb\MonitoringMetricsBundle\Tests\Fixtures\Entity\Team;
use Odandb\MonitoringMetricsBundle\Tests\Fixtures\Kernel;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\ConsoleOutput;

require __DIR__ . '/../vendor/autoload.php';

// Clean up from previous runs
@exec('rm -rf ' . escapeshellarg(__DIR__ . '/Fixtures/var'));
@exec('mkdir ' . escapeshellarg(__DIR__ . '/Fixtures/var'));

// Create schema
$kernel = new Kernel('test', false);
$output = new ConsoleOutput();
$application = new Application($kernel);
$application->get('doctrine:schema:drop')->run(new StringInput('--force --quiet'), $output);
$application->get('doctrine:schema:create')->run(new StringInput('--quiet'), $output);

$em = $kernel->getContainer()->get('doctrine')->getManager();
$teams = [];
for($i = 0; $i <= 3; ++$i) {
    $teams[] = $team = new Team('Team ' . $i);
    $em->persist($team);
}
for ($i = 0; $i <= 15; ++$i) {
    $em->persist(new Person('Firstname' . $i, 'Lastname ' . $i, $teams[$i % count($teams)]));
}
$em->flush();
