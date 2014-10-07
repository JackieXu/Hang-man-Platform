<?php


namespace Hangman\CoreBundle\Command;


use Hangman\CoreBundle\Entity\Word;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class InsertTestDataCommand
 *
 * Inserts test data into database
 *
 * @package Hangman\CoreBundle
 */
class InsertTestDataCommand extends ContainerAwareCommand
{
    /**
     * Configure command
     */
    protected function configure()
    {
        $this
            ->setName('data:insert')
            ->setDescription('Insert list of words into database')
            ->addArgument('filepath', InputOption::VALUE_REQUIRED, 'File containing list of words');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Get filepath
        $filepath = $input->getArgument('filepath');

        // Check for missing argument
        if (!$filepath) {
            $output->writeln('Missing filepath argument');
            return;
        }

        // Get entity manager
        $entityManager = $this->getContainer()->get('doctrine')->getManager();

        // Get repository
        $wordRepository = $entityManager->getRepository('HangmanCoreBundle:Word');

        // Open file
        $file = new \SplFileObject($filepath, 'r');

        // Keep a tally of added words
        $wordCount = 0;

        // Set batch size
        $batchSize = 50;

        // Loop over file while end hasn't been reached yet
        while (!$file->eof()) {

            // Get line
            $line = $file->fgets();

            // Remove whitespace on all ends (spaces, tabs, newlines), and thus get the word
            $word = trim($line);

            // Check for empty words
            if (0 === strlen($word)) {
                continue;
            }

            // Check if word exists
            if ($wordRepository->findOneByText($word)) {
                continue;
            }

            // Create new word instance
            $wordInstance = new Word();
            $wordInstance->setText($word);

            // Persist word instance
            $entityManager->persist($wordInstance);

            // Save and detach objects from Doctrine
            if (($wordCount % $batchSize) === 0) {
                $entityManager->flush();
                $entityManager->clear();
            }

            // Add to word count
            $wordCount++;
        }

        // Save objects that didn't make up an entire batch
        $entityManager->flush();
        $entityManager->clear();

        $output->writeln(sprintf('Added %d words.', $wordCount));
    }
} 