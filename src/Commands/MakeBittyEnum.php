<?php

namespace MatthewPageUK\BittyEnums\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Facades\Validator;
use MatthewPageUK\BittyEnums\Rules;

/**
 * Create a BittyEnum class along with the cases
 *
 * Overide the GeneratorCommand to add the cases to the stub
 */
class MakeBittyEnum extends GeneratorCommand
{
    protected $name = 'bitty-enum:make';

    protected $description = 'Create a new BittyEnum class';

    protected $type = 'BittyEnum';

    protected $cases = '';

    #[\Override]
    protected function getStub()
    {
        return __DIR__.'/../../resources/stubs/bitty-enum.stub';
    }

    #[\Override]
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Enums';
    }

    #[\Override]
    public function handle()
    {
        if ($this->isReservedName($this->getNameInput())) {
            $this->components->error('The name "'.$this->getNameInput().'" is reserved by PHP.');

            return false;
        }

        $name = $this->qualifyClass($this->getNameInput());

        $path = $this->getPath($name);

        if ((! $this->hasOption('force') ||
             ! $this->option('force')) &&
             $this->alreadyExists($this->getNameInput())) {
            $this->components->error($this->type.' already exists.');

            return false;
        }

        // Enum cases from the user input
        $this->cases = $this->prepareCases($this->getCasesFromUser());
        // End of changes

        $this->makeDirectory($path);

        $this->files->put($path, $this->sortImports($this->buildClass($name)));

        $info = $this->type;

        if (windows_os()) {
            $path = str_replace('/', '\\', $path);
        }

        $this->components->info(sprintf('%s [%s] created successfully.', $info, $path));
    }

    #[\Override]
    protected function buildClass($name)
    {
        $stub = $this->files->get($this->getStub());

        return $this->replaceNamespace($stub, $name)
            ->replaceCases($stub, $this->cases)
            ->replaceClass($stub, $name);
    }

    /**
     * Prepare the cases array for the stub, adding the
     * value and formatting.
     *
     * @param  array  $cases
     */
    protected function prepareCases($cases): string
    {
        $cases = array_map(function ($case, $key) {
            return '    case '.$case.' = '.pow(2, $key).';';
        }, $cases, array_keys($cases));

        return implode(PHP_EOL, $cases);
    }

    /**
     * Get and validate the cases from the user input
     */
    protected function getCasesFromUser(): array
    {
        $cases = [];

        while (count($cases) < config('bitty-enums.max_bits')) {

            $input = $this->components->ask('Enter a name for case '.count($cases) + 1 .', or blank to continue.');

            if ($input == '') {
                break;
            }

            if (! $this->validateCaseName($input)) {
                $this->components->error('The name "'.$input.'" is not a valid Enum case name.');

                continue;
            }

            if (in_array($input, $cases)) {
                $this->components->error('The name "'.$input.'" is already in use.');

                continue;
            }

            $cases[] = $input;
        }

        return $cases;
    }

    /**
     * Validate the case name
     */
    protected function validateCaseName(string $name): bool
    {
        $validator = Validator::make(
            ['name' => $name],
            ['name' => new Rules\CaseName],
        );

        return $validator->passes();
    }

    /**
     * Replace the cases for the given stub.
     */
    protected function replaceCases(string &$stub, string $cases): self
    {
        $stub = str_replace(
            '{{ cases }}',
            $cases,
            $stub
        );

        return $this;
    }
}
