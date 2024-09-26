
<?php

// Usage information
if (in_array('--help', $argv) || in_array('-h', $argv)) {
    echo <<<EOL
Usage: php git_diff_analyzer.php [--days=1] [--branch=develop] [--filter=sunnysideup] [--date=YYYY-MM-DD] [--line-changes-per-minute=1] [-v|-vv|-vvv]

Options:
  --days=N                    Number of days to go back in time for the analysis (default: 1).
  --branch=NAME                Specify the branch to analyze (default: develop).
  --filter=STRING              Filter git repos by their remote URL (default: 'sunnysideup').
  --date=YYYY-MM-DD            Analyze for a specific date instead of days back.
  --line-changes-per-minute=N  Set how many line changes are assumed per minute (default: 1 change every 3 minutes).
  -v, -vv, -vvv                Set verbosity level:
                                 -v   : Show total time and total changes only.
                                 -vv  : Show commit messages, file changes, and total time (default).
                                 -vvv : Show detailed changes for each file.
  -h, --help                   Show this help message.

Examples:
  php git_diff_analyzer.php --days=7 --branch=main --filter=myorganization
  php git_diff_analyzer.php --date=2024-09-24 --line-changes-per-minute=2
  php git_diff_analyzer.php -v --days=5 --filter=mycompany

EOL;
    exit;
}

class GitDiffAnalyzer
{
    private $lineChangesPerMinute;
    private $branch;
    private $days;
    private $filter;
    private $verbosity;
    private $date;

    public function __construct(
        int $days = 1,
        string $branch = 'develop',
        string $filter = 'sunnysideup',
        float $lineChangesPerMinute = 1 / 3, // 1 line change per 3 minutes
        int $verbosity = 2,
        string $date = null
    ) {
        $this->lineChangesPerMinute = $lineChangesPerMinute;
        $this->branch = $branch;
        $this->days = $days;
        $this->filter = $filter;
        $this->verbosity = $verbosity;
        $this->date = $date;
    }

    /**
     * Helper function to extract and list the number of changes for each file type.
     */
    private function extractChanges(string $diffOutput, string $filePattern, string $fileType, int &$totalChanges): bool
    {
        preg_match_all('#diff --git a/(.*' . $filePattern . ')#', $diffOutput, $matches);
        $files = $matches[1];
        $hasChanges = false;

        if (!empty($files)) {
            if ($this->verbosity >= 2) {
                echo "\n### $fileType Files ###\n";
            }
            foreach ($files as $file) {
                // Extract changes for each individual file
                $fileDiff = $this->extractFileDiff($diffOutput, $file);
                $linesAdded = substr_count($fileDiff, "\n+");
                $linesRemoved = substr_count($fileDiff, "\n-");

                // Get just the file name without the full path
                $fileName = basename($file);

                // Calculate total changes for this file
                $fileChanges = $linesAdded + $linesRemoved;
                if ($fileChanges > 0) {
                    $hasChanges = true;
                    $totalChanges += $fileChanges;

                    // Print the result in the desired format
                    if ($this->verbosity === 3) {
                        echo "$fileName: $fileChanges changes\n";
                    }
                }
            }
        }

        return $hasChanges;
    }

    /**
     * Extract the diff for a specific file from the full diff output.
     */
    private function extractFileDiff(string $diffOutput, string $file): string
    {
        $fileDiffPattern = "#diff --git a/$file.*?(?=diff --git|$)#s";
        preg_match($fileDiffPattern, $diffOutput, $matches);
        return $matches[0] ?? '';
    }

    /**
     * Fetch the commit messages for a given day.
     */
    private function getCommitMessages(string $startOfDayCommit, string $endOfDayCommit): array
    {
        $commitLog = shell_exec("git log --pretty=format:'%s' $startOfDayCommit..$endOfDayCommit");
        $commitMessages = array_filter(array_map('trim', explode("\n", $commitLog)));
        return array_unique($commitMessages);
    }

    /**
     * Analyze Git diffs for the given day.
     */
    private function gitDiffForDay(string $date): void
    {
        // Check which branch to use: develop, main, or master
        $branch = $this->getAvailableBranch();

        if ($branch === null) {
            if ($this->verbosity >= 2) {
                echo "\n[INFO] No develop, main, or master branch found for repository. Skipping.\n";
            }
            return;
        }

        // Get the start and end commits for the day
        $startOfDayCommit = trim(shell_exec("git rev-list -n 1 --before='$date 00:00' $branch"));
        $endOfDayCommit = trim(shell_exec("git rev-list -n 1 --before='$date 23:59' $branch"));

        // Check if valid commits are found for the day
        if (empty($startOfDayCommit) || empty($endOfDayCommit)) {
            return; // Skip if no commits found for the date
        }

        // Fetch the diff for the day
        $diffOutput = shell_exec("git diff $startOfDayCommit $endOfDayCommit | grep -v '/dist/'");
        $diffOutput = implode("\n", array_filter(explode("\n", $diffOutput), function ($line) {
            return strlen($line) < 1000;
        }));

        // If no changes are found
        if (empty($diffOutput)) {
            return; // Skip if no changes are found
        }

        $totalChanges = 0;
        $hasChanges = false;

        // Show commit messages if verbosity >= 2
        if ($this->verbosity >= 2) {
            $commitMessages = $this->getCommitMessages($startOfDayCommit, $endOfDayCommit);
            if (!empty($commitMessages)) {
                echo "\n### Commit Messages ###\n";
                foreach ($commitMessages as $message) {
                    echo "- $message\n";
                }
            }
        }

        // Process PHP files: extract changes for classes and methods
        $phpHasChanges = $this->extractChanges($diffOutput, '\.php', 'PHP', $totalChanges);
        $hasChanges = $hasChanges || $phpHasChanges;

        // Process other file types
        $jsHasChanges = $this->extractChanges($diffOutput, '\.js', 'JavaScript', $totalChanges);
        $hasChanges = $hasChanges || $jsHasChanges;

        $cssHasChanges = $this->extractChanges($diffOutput, '\.css', 'CSS', $totalChanges);
        $hasChanges = $hasChanges || $cssHasChanges;

        $yamlHasChanges = $this->extractChanges($diffOutput, '\.(yml|yaml)', 'YML/YAML', $totalChanges);
        $hasChanges = $hasChanges || $yamlHasChanges;

        $ssHasChanges = $this->extractChanges($diffOutput, '\.ss', 'SilverStripe (SS)', $totalChanges);
        $hasChanges = $hasChanges || $ssHasChanges;

        // If no changes in any file types, skip output for this repository
        if (!$hasChanges) {
            return;
        }

        // Convert total changes to time in minutes and hours
        $timeInMinutes = $totalChanges / $this->lineChangesPerMinute;
        $hours = floor($timeInMinutes / 60);
        $minutes = round($timeInMinutes % 60);

        // Display total changes and estimated time
        if ($this->verbosity >= 1) {
            echo "\n===== Total Changes for the Day: $totalChanges =====\n";
            if ($hours > 0) {
                echo "Estimated Time: $hours hours and $minutes minutes\n";
            } else {
                echo "Estimated Time: $minutes minutes\n";
            }
        }
    }

    /**
     * Determine the branch to use by checking for develop, main, or master.
     *
     * @return string|null The branch to use, or null if no valid branch is found.
     */
    private function getAvailableBranch(): ?string
    {
        // Check for develop branch
        $developBranch = trim(shell_exec("git branch --list develop"));
        if (!empty($developBranch)) {
            return 'develop';
        }

        // Check for main branch
        $mainBranch = trim(shell_exec("git branch --list main"));
        if (!empty($mainBranch)) {
            return 'main';
        }

        // Check for master branch
        $masterBranch = trim(shell_exec("git branch --list master"));
        if (!empty($masterBranch)) {
            return 'master';
        }

        // No valid branch found
        return null;
    }

    /**
     * Run the Git diff analysis for the specified number of days or a specific date.
     */
    public function run(): void
    {
        // Find all Git repositories that match the filter
        $repos = $this->findGitRepos();
        foreach ($repos as $repo) {
            if ($this->verbosity > 3) {
                echo "\n===== Analyzing repository: $repo =====\n";
            }
            chdir($repo);
            if ($this->date) {
                $this->gitDiffForDay($this->date);
            } else {
                for ($i = 0; $i < $this->days; $i++) {
                    $date = date('Y-m-d', strtotime("-$i days"));
                    $this->gitDiffForDay($date);
                }
            }
            chdir('..'); // Go back to the parent directory
        }
    }

    /**
     * Find all Git repositories in the current directory (including root and subdirectories) where the remote URL contains the specified filter.
     *
     * @return array
     */
    private function findGitRepos(): array
    {
        $repos = [];

        // Check if the root directory is a Git repository
        $rootGitDir = realpath('.') . '/.git';
        if (file_exists($rootGitDir) && is_dir($rootGitDir)) {
            $remoteUrl = shell_exec("git -C " . escapeshellarg(realpath('.')) . " remote -v");

            // Check if the URL contains the filter (e.g., 'sunnysideup')
            if (stripos($remoteUrl, $this->filter) !== false) {
                $repos[] = realpath('.');
            }
        }

        // Use FilesystemIterator to recursively scan directories for .git folders
        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator('.', RecursiveDirectoryIterator::SKIP_DOTS), RecursiveIteratorIterator::SELF_FIRST);

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

        return $repos;
    }
}

// CLI argument handling
$options = getopt('', ['days:', 'branch:', 'filter:', 'line-changes-per-minute:', 'date:', 'v::']);
$days = isset($options['days']) ? (int)$options['days'] : 1;
$branch = $options['branch'] ?? 'develop';
$filter = $options['filter'] ?? 'sunnysideup';
$lineChangesPerMinute = isset($options['line-changes-per-minute']) ? (float)$options['line-changes-per-minute'] : 1 / 3;
$date = $options['date'] ?? null;
$verbosity = isset($options['v']) ? strlen($options['v']) : 2;

// Create an instance of the GitDiffAnalyzer and run the analysis
$analyzer = new GitDiffAnalyzer($days, $branch, $filter, $lineChangesPerMinute, $verbosity, $date);
$analyzer->run();
