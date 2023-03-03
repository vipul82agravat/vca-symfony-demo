<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\ArrayInput;

//#[AsCommand(name: 'user-params-command')]
#[AsCommand(
    name: 'user-params-command',
    description: 'Creates a new user.',
    hidden: false,
    aliases: ['user-params']
)]
class UserParametersCommand extends Command
{
    // In this function set the name, description and help hint for the command
    protected function configure(): void
    {
        // Use in-build functions to set name, description and help

        $this
           //->setName('user-params-command')
            //->setDescription('This command runs your user get Parameters task')
            ->setHelp('Run this command to execute your custom tasks in the execute function.')
            ->addArgument('first_param', InputArgument::REQUIRED, 'Pass the parameter.')
            ->addArgument('second_params', InputArgument::REQUIRED, 'Pass the parameter.');
    }

    // write the code you want to execute when command runs
    protected function execute(InputInterface $input, OutputInterface $output): int
    {   
        //call other command

            // $command = $this->getApplication()->find('user-command');
            // $arguments = [
            //         ];

            // $greetInput = new ArrayInput($arguments);
            // $returnCode = $command->run($greetInput, $output);


        // If you want to write some output
        
        $output->writeln('<bg=yellow;options=bold>foo</>Frist  parameter => '. $input->getArgument('first_param'));
        $output->writeln('Second parameter => '. $input->getArgument('second_params'));
        $output->writeln('Merge parameters => '. $input->getArgument('second_params').'-'.$input->getArgument('second_params'));
        return Command::SUCCESS;

        // Return below values according to the occurred situation
        if (SUCCESSFUL_EXECUTION_CONDITION) {

            // if everything is executed successfully with no issues then return SUCCESS as below
            return Command::SUCCESS;

        } elseif (EXECUTION_FAILURE_CONDITION) {

            // if execution fails return FAILURE as below
            return Command::FAILURE;

        } elseif (INVALID_EXECUTION_CONDITION) {

            // if invalid things happens i.e. invalid arguments etc. then return INVALID as below
            return Command::INVALID;

        }
    }
    public function callOtherCommand(InputInterface $input, OutputInterface $output){

        $command = $this->getApplication()->find('demo:greet');

        $arguments = [
            'name'    => 'Fabien',
            '--yell'  => true,
        ];

        $greetInput = new ArrayInput($arguments);
        $returnCode = $command->run($greetInput, $output);
    }
}