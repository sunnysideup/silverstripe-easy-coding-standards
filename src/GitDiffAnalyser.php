<?php

namespace Sunnysideup\EasyCodingStandards;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class GitDiffAnalyser
{
    protected bool $debug = false;
    protected string $directory = '.';
    protected string|null $date = null;
    protected int|null $days = 1;
    protected string $branch = 'develop';
    protected string $filter = '';
    protected float $instantiationCostInMinutes = 10;
    protected float $minutesForFirstLineChange = 3;
    protected float $decreaseFactor = 0.99;
    protected int $verbosity = 2;
    protected bool $showFullDiff = false;
    protected int $maxLinesToShowAll = 15;
    protected int $maxLinesToShowAdditionsOnly = 300;
    protected int $maxNumberOfKeywords = 30;
    protected string|null $currentDir = null;
    protected array $branchesToCheck = ['develop', 'main', 'master'];

    protected $totalChangesPerDayPerRepo = [];

    protected $fileTypes = [
        ['extension' => '\.php', 'type' => 'PHP'],
        ['extension' => '\.js', 'type' => 'JavaScript'],
        // ['extension' => '\.css', 'type' => 'CSS'], see SASS / LESS / SCSS
        ['extension' => '\.(yml|yaml)', 'type' => 'YML/YAML'],
        ['extension' => '\.ss', 'type' => 'SilverStripe (SS)'],
        ['extension' => '\.html', 'type' => 'HTML'],
        ['extension' => '\.json', 'type' => 'JSON'],
        ['extension' => '\.xml', 'type' => 'XML'],
        ['extension' => '\.md', 'type' => 'Markdown'],
        // ['extension' => '\.png', 'type' => 'Image'],
        // ['extension' => '\.jpg', 'type' => 'Image'],
        // ['extension' => '\.jpeg', 'type' => 'Image'],
        // ['extension' => '\.gif', 'type' => 'Image'],
        ['extension' => '\.svg', 'type' => 'SVG'],
        // ['extension' => '\.sql', 'type' => 'SQL'],
        ['extension' => '\.sh', 'type' => 'Shell Script'],
        ['extension' => 'composer\.json', 'type' => 'Composer'],
        // ['extension' => 'composer\.lock', 'type' => 'Composer'],
        // ['extension' => '\.env', 'type' => 'Environment Variables'],
        ['extension' => '\.twig', 'type' => 'Twig Template'],
        ['extension' => '\.blade\.php', 'type' => 'Blade Template'],
        ['extension' => '\.test\.php', 'type' => 'PHP Test'],
        ['extension' => '\.spec\.php', 'type' => 'PHP Spec Test'],
        ['extension' => '\.scss', 'type' => 'SASS/SCSS'],
        ['extension' => '\.sass', 'type' => 'SASS'],
        ['extension' => '\.less', 'type' => 'LESS'],
        ['extension' => '\.ini', 'type' => 'INI Config'],
        ['extension' => '\.conf', 'type' => 'Config File']
    ];

    public function setDebug(bool $debug): static
    {
        $this->debug = $debug;
        return $this;
    }

    public function setDirectory(string $directory): static
    {
        $this->directory = realpath($directory);
        return $this;
    }

    public function setDaysOrDate(int|string $daysOrDate): static
    {
        if (is_int($daysOrDate)) {
            $this->setDays($daysOrDate);
        } elseif (strtotime($daysOrDate) > 0) {
            $this->setDate($daysOrDate);
        } else {
            user_error('You need to set a valid number of days or a valid date.');
        }
        return $this;
    }

    public function setDate(string $date): static
    {
        $this->days = null;
        if (strtotime($date) > 0) {
            $this->date = $date;
        } else {
            user_error('Invalid date format. Use a valid date string.');
        }
        return $this;
    }

    public function setDays(int $days): static
    {
        $this->date = null;
        $this->days = $days;
        return $this;
    }


    public function setBranch(string $branch): static
    {
        $this->branch = $branch;
        return $this;
    }

    public function setFilter(string $filter): static
    {
        $this->filter = $filter;
        return $this;
    }

    public function setMinutesForFirstLineChange(float $minutes): static
    {
        $this->minutesForFirstLineChange = $minutes;
        return $this;
    }

    public function setInstantiationCostInMinutes(float $instantiationCostInMinutes): static
    {
        $this->instantiationCostInMinutes = $instantiationCostInMinutes;
        return $this;
    }

    public function setVerbosity(int $verbosity): static
    {
        $this->verbosity = $verbosity;
        return $this;
    }

    public function setShowFullDiff(bool $showFullDiff): static
    {
        $this->showFullDiff = $showFullDiff;
        return $this;
    }

    public function setBranchesToCheck(array $branchesToCheck): static
    {
        $this->branchesToCheck = $branchesToCheck;
        return $this;
    }

    public function setFileTypes(array $fileTypes): static
    {
        $this->fileTypes = $fileTypes;
        return $this;
    }

    public function setFileType(string $extension): static
    {
        $this->fileTypes = array_filter($this->fileTypes, function ($fileType) use ($extension) {
            return $fileType['extension'] === $extension;
        });
        return $this;
    }

    public function addFileType(array $fileType): static
    {
        $this->fileTypes[] = $fileType;
        return $this;
    }

    public function removeFileType(string $extension): static
    {
        $this->fileTypes = array_filter($this->fileTypes, function ($fileType) use ($extension) {
            return $fileType['extension'] !== $extension;
        });
        return $this;
    }


    /**
     * Run the Git diff analysis for the specified number of days or a specific date.
     */
    public function run(): void
    {
        $this->output(PHP_EOL."Starting Git Diff Analysis", 1, 1);
        // Find all Git repositories that match the filter
        if ($this->date) {
            $this->gitDiffForDay($this->date);
        } else {
            for ($i = 0; $i < $this->days; $i++) {
                $date = date('Y-m-d', strtotime("-$i days"));
                $this->gitDiffForDay($date);
            }
        }
        $this->changeDir($this->directory); // Go back to the parent directory
        $this->output(PHP_EOL."End of Git Diff Analysis", 1, 1);
    }

    /**
     * Analyze Git diffs for the given day.
     */
    protected function gitDiffForDay(string $date): void
    {
        $this->output($date, 1, 1);
        $this->totalChangesPerDayPerRepo[$date] = [];
        $repos = $this->findGitRepos();
        foreach ($repos as $repo) {
            $this->outputDebug("Analyzing repository: $repo", 4);
            $this->changeDir($repo);
            $this->totalChangesPerDayPerRepo[$date][$repo] = $this->gitDiffForDayForRepo($date, $repo);
            if ($this->totalChangesPerDayPerRepo[$date][$repo] > 0) {
                $this->outputEffort($repo, $this->totalChangesPerDayPerRepo[$date][$repo], 3, 3);
            }
        }
        $this->outputEffort($date, array_sum($this->totalChangesPerDayPerRepo[$date]), 2, 1);
    }

    /**
        * Analyze Git diffs for the given day.
        */
    protected function gitDiffForDayForRepo(string $date, string $repo): int
    {
        $noOfChanges = 0;
        // Check which branch to use: develop, main, or master
        $branch = $this->getAvailableBranch();

        if ($branch === null) {
            $this->outputDebug("[ERROR] No branch found for repository {$this->currentDir}. Skipping.");
            return 0;
        }

        // Get the start and end commits for the day
        $startOfDayCommit = trim(shell_exec("git rev-list -n 1 --before='$date 00:00' $branch"));
        $endOfDayCommit = trim(shell_exec("git rev-list -n 1 --before='$date 23:59' $branch"));
        $this->outputDebug("Last commit from previous day: $startOfDayCommit", 4);
        $this->outputDebug("Last commit from current day: $endOfDayCommit", 4);
        // Check if valid commits are found for the day
        if (empty($startOfDayCommit) || empty($endOfDayCommit)) {
            return 0; // Skip if no commits found for the date
        }

        // Fetch the diff for the day
        $diffOutput = shell_exec("git diff $startOfDayCommit $endOfDayCommit | grep -v '/dist/'");

        // remove empty lines and lines that are too long
        $diffOutput = implode("".PHP_EOL, array_filter(explode("".PHP_EOL, $diffOutput), function ($line) {
            return strlen($line) < 1000;
        }));

        $filesChanged = $this->getFilesChanged($startOfDayCommit, $endOfDayCommit);
        $commitMessagesArray = $this->getCommitMessages($startOfDayCommit, $endOfDayCommit);
        if (count($filesChanged) > 0 || count($commitMessagesArray) > 0) {
            $this->output('Total files changed for '.$repo .': '. count($filesChanged), 2, 1);
        } else {
            return 0;
        }

        $this->output("Commit Messages", 4, 1);
        $this->output($commitMessagesArray, 0, 1);


        // Loop through the file types and process changes
        foreach ($this->fileTypes as $fileType) {
            $fileTypeChanges = 0;
            $filesChangedForOutput = [];
            foreach ($filesChanged as $key => $fileChanged) {
                if (preg_match('/'.$fileType['extension'].'$/', $fileChanged)) {
                    unset($filesChanged[$key]);  // Remove the found file from the array
                    $fileTypeChanges += $this->extractChangesForFileName($diffOutput, $fileChanged);
                    $filesChangedForOutput[] = $fileChanged;
                }
            }
            if ($fileTypeChanges > 0) {
                $this->output('Total changes for '.$fileType['type'] . ': ' . $fileTypeChanges, 4, 3);
                $this->output($filesChangedForOutput, 0, 4);
            }
            $noOfChanges += $fileTypeChanges;
        }

        // If no changes in any file types, skip output for this repository

        // Display total changes and estimated time
        $this->outputEffort($repo, $noOfChanges, 3, 2);

        return $noOfChanges;
    }

    /**
     * Determine the branch to use by checking for branchesToCheck values
     *
     * @return string|null The branch to use, or null if no valid branch is found.
     */
    public function getAvailableBranch(): ?string
    {
        foreach ($this->branchesToCheck as $branch) {
            $branchCheck = trim(shell_exec("git branch --list $branch"));
            if (!empty($branchCheck)) {
                return $branch;
            }
        }

        return null;
    }



    /**
     * Find all Git repositories in the current directory (including root and subdirectories)
     * where the remote URL contains the specified filter.
     *
     * @return array
     */
    protected function findGitRepos(): array
    {
        $repos = [];

        // Check if the root directory is a Git repository
        $rootGitDir = ($this->directory) . '/.git';
        if (file_exists($rootGitDir) && is_dir($rootGitDir)) {
            $remoteUrl = shell_exec("git -C " . escapeshellarg(($this->directory)) . " remote -v");

            // Check if the URL contains the filter (e.g., 'sunnysideup')
            if (stripos($remoteUrl, $this->filter) !== false) {
                $repos[] = ($this->directory);
            }
        }

        // Use FilesystemIterator to recursively scan directories for .git folders
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator(
                $this->directory,
                RecursiveDirectoryIterator::SKIP_DOTS
            ),
            RecursiveIteratorIterator::SELF_FIRST
        );

        foreach ($iterator as $dir) {
            if ($dir->isDir() && basename($dir) === '.git') {
                // Found a .git directory, process its parent directory
                $parentDir = dirname($dir->getRealPath());
                $remoteUrl = shell_exec("git -C " . escapeshellarg($parentDir) . " remote -v");

                // Check if the URL contains the filter (e.g., 'sunnysideup')
                if (stripos($remoteUrl, $this->filter) !== false) {
                    $repos[] = realpath($parentDir);
                }
            }
        }

        return array_filter(array_unique($repos));
    }

    /**
     * Helper function to extract and list the number of changes for each file type.
     */
    protected function extractChangesForFileName(string $diffOutput, string $fileName): int
    {
        preg_match_all('#diff --git a/(' . preg_quote($fileName, '#') . ')#', $diffOutput, $matches);
        $files = $matches[1];
        $totalChanges = 0;
        if (!empty($files)) {
            foreach ($files as $file) {
                // Extract changes for each individual file
                $fileDiff = $this->extractFileDiff($diffOutput, $file);
                $linesAdded = substr_count($fileDiff, "\n+ ");
                $linesRemoved = substr_count($fileDiff, "\n- ");

                // Get just the file name without the full path
                $fileName = basename($file);

                // Calculate total changes for this file
                $fileChanges = $linesAdded + $linesRemoved;
                if ($fileChanges > 0) {
                    $totalChanges += $fileChanges;

                    // Print the result in the desired format
                    $this->output("$fileName: $fileChanges changes", 5, 4);
                }
                if (($this->verbosity > 2 && $this->showFullDiff) || $this->verbosity > 3) {
                    $this->output($this->extractDiffInfo($fileDiff), 0, 4);
                }
            }
        }
        return $totalChanges;
    }

    /**
     * Extract the diff for a specific file from the full diff output.
     */
    protected function extractFileDiff(string $diffOutput, string $file): string
    {
        $fileDiffPattern = "#diff --git a/$file.*?(?=diff --git|$)#s";
        preg_match($fileDiffPattern, $diffOutput, $matches);
        return $matches[0] ?? '';
    }

    /**
     * Fetch the commit messages for a given day.
     */
    protected function getCommitMessages(string $startOfDayCommit, string $endOfDayCommit): array
    {
        $commitLog = shell_exec("git log --pretty=format:'%s' $startOfDayCommit..$endOfDayCommit");
        $commitMessages = array_filter(array_map('trim', explode("".PHP_EOL, $commitLog)));
        return array_unique($commitMessages);
    }
    /**
     * Fetch the commit messages for a given day.
     */
    protected function getFilesChanged(string $startOfDayCommit, string $endOfDayCommit): array
    {
        $commitLog = shell_exec("git diff --name-only $startOfDayCommit $endOfDayCommit");
        $filesChanged = array_filter(array_map('trim', explode("".PHP_EOL, $commitLog)));
        return array_unique($filesChanged);
    }

    protected function changeDir(string $dir): void
    {
        $this->currentDir = realpath($dir);
        if (!chdir($dir)) {
            user_error("Could not change to directory: $dir");
        }
    }

    protected function outputEffort(string $name, int $numberOfChanges, ?int $headerLevel = 3, ?int $verbosityLevel = null)
    {
        // Convert total changes to time in minutes and hours
        $timeInMinutes = $numberOfChanges > 0 ? $this->instantiationCostInMinutes : 0;

        for ($i = 0; $i < $numberOfChanges; $i++) {
            $timeInMinutes += $this->minutesForFirstLineChange * (1 / (1 + log($i + 1))) * $this->decreaseFactor;
        }

        $hours = floor($timeInMinutes / 60);
        $minutes = round($timeInMinutes % 60);
        $timeInDecimals = $timeInMinutes / 60;
        $timeInDecimals = round($timeInDecimals * 4) / 4;
        if ($hours > 0) {
            $time = "$hours hours and $minutes minutes";
        } else {
            $time = "$minutes minutes";
        }
        $name = str_replace($this->directory, './', $name);
        $name = str_replace('//', '/', $name);
        $this->output(
            "Summary of efforf $name:",
            $headerLevel,
            $verbosityLevel
        );
        $this->output($numberOfChanges .' (changes)', 0, $verbosityLevel);
        $this->output($time .' ('.$timeInDecimals.' rounded decimal hours)', 0, $verbosityLevel);
    }

    protected function outputDebug(string|array $message, $headerLevel = 0, ?int $verbosityLevel = null)
    {
        if ($this->debug) {
            if ($verbosityLevel === null) {
                $verbosityLevel = 0;
            }
            $this->output($message, $headerLevel, $verbosityLevel);
        }
    }

    protected function output(string|array $message, $headerLevel = 0, ?int $verbosityLevel = null)
    {
        if ($verbosityLevel === null) {
            $verbosityLevel = $this->verbosity;
        }
        if ($verbosityLevel > $this->verbosity) {
            return;
        }
        if (is_array($message)) {
            foreach ($message as $m) {
                $this->output($m, $headerLevel, $verbosityLevel);
            }
        } else {
            $this->outputHeader($message, $headerLevel);
        }
    }
    protected function outputHeader($message, int $headerLevel = 0): void
    {

        if ($headerLevel > 0) {
            $this->outputNewLines($headerLevel, true);
        }

        $headerLine = $this->getHeaderLine($headerLevel);
        if ($headerLine) {
            echo $this->getColor($headerLevel) . $headerLine . $this->resetColor() . PHP_EOL;
        }
        echo $this->getColor($headerLevel) . $message . $this->resetColor() . PHP_EOL;
        if ($headerLine) {
            echo $this->getColor($headerLevel) . $headerLine . $this->resetColor() . PHP_EOL;
        }
        // $this->outputNewLines($headerLevel, false);

    }

    private function outputNewLines(int $headerLevel, bool $isStart): void
    {
        if ($isStart) {
            echo str_repeat(PHP_EOL, max(0, 3 - ($headerLevel)));
        } else {
            echo PHP_EOL;
        }
    }

    private function getHeaderLine(int $headerLevel): ?string
    {
        return match ($headerLevel) {
            1 => '==============================================================',
            2 => '**************************************************************',
            3 => '--------------------------------------------------------------',
            4 => '===',
            5 => '---',
            default => null
        };
    }

    private function getColor(int $headerLevel): string
    {
        return match ($headerLevel) {
            1 => "\033[1;31m", // Red, bold
            2 => "\033[1;33m", // Yellow, bold
            3 => "\033[1;34m", // Blue, bold
            4 => "\033[0;32m", // Green
            5 => "\033[0;36m", // Cyan
            default => $this->resetColor()
        };
    }

    private function resetColor(): string
    {
        return "\033[0m";
    }


    protected function extractDiffInfo(string $diffContent): string
    {
        $lines = explode("\n", $diffContent); // Split the string into lines
        $lineCount = count($lines);
        $string = 'Total line changes: '.$lineCount.PHP_EOL;
        if ($this->verbosity < 4 && $lineCount < $this->maxLinesToShowAll) {
            return $diffContent;
        }
        if ($lineCount < $this->maxLinesToShowAdditionsOnly) {
            $string .= "Showing additions only".PHP_EOL;
            foreach ($lines as $line) {
                // Check if the line starts with a '+'
                if (strpos($line, '+') === 0) {
                    $string .= $line . PHP_EOL;
                }
            }
            return $string;
        } else {
            return implode("\n", $this->cleanDiffContent($diffContent));
        }
    }

    protected function cleanDiffContent(string $diffContent): array
    {
        // List of typical coding words to remove
        $codingWords = [
            // Control structures
            'if', 'else', 'elseif', 'endif', 'then', 'for', 'foreach', 'while', 'do',
            'switch', 'case', 'break', 'continue', 'default', 'return', 'yield', 'throw', 'try', 'catch', 'finally', 'goto',

            // Functions and classes
            'function', 'class', 'abstract', 'interface', 'trait', 'public', 'private', 'protected', 'static', 'final',
            'extends', 'implements', 'new', 'clone', 'self', 'parent', 'this', 'namespace', 'use', 'global', 'const', 'var', 'static',

            // Data types
            'int', 'float', 'string', 'bool', 'boolean', 'array', 'object', 'resource', 'null', 'void', 'mixed', 'iterable', 'callable',

            // PHP specific
            'echo', 'print', 'include', 'include_once', 'require', 'require_once', 'construct', 'destruct', 'call', 'get',
            'set', 'isset', 'unset', 'toString', 'invoke', 'clone', 'debugInfo',

            // JavaScript specific
            'let', 'const', 'var', 'await', 'async', 'function', 'return', 'class', 'constructor', 'import', 'export',

            // Miscellaneous
            'true', 'false', 'null', 'undefined', 'NaN', 'Infinity', 'typeof', 'instanceof', 'in', 'as', 'with', 'extends', 'super', 'delete',
        ];

        // Remove all non-alpha characters and replace them with a space
        $diffContent = preg_replace('/[^a-zA-Z\s]/', ' ', $diffContent);

        // Replace multiple white spaces with a single space
        $diffContent = preg_replace('/\s+/', ' ', $diffContent);

        // Convert the string to an array of words
        $words = explode(' ', trim($diffContent));

        // Filter out coding words, make all words lowercase, and remove words shorter than 3 characters
        $filteredWords = array_filter($words, function ($word) use ($codingWords) {
            return !in_array(strtolower($word), $codingWords) && strlen($word) >= 3;
        });

        // Count word occurrences
        $wordCounts = array_count_values(array_map('strtolower', $filteredWords));

        // Sort words by frequency, from most used to least used
        arsort($wordCounts);

        // Get the top 20 words (keys only)
        return array_keys(array_slice($wordCounts, 0, $this->maxNumberOfKeywords, true));

    }



}
