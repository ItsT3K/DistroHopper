<?php
require_once ('../curl.php');

# Branches #
$curl = new Curl ('https://api.github.com/repos/RobinJ1995/be.robinj.ubuntu/branches');
$curl->useragent = 'RobinJ1995';
$result = $curl->exec ();

$branches = json_decode ($result->content);

# Commits #
$lastCommit = NULL;

foreach ($branches as $branch)
{
    $curl = new Curl ('https://api.github.com/repos/RobinJ1995/be.robinj.ubuntu/commits/' . $branch->name);
    $curl->useragent = 'RobinJ1995';
    
    $result = $curl->exec ();
    $commit = json_decode ($result->content);
    
    if ($lastCommit === NULL)
        $lastCommit = $commit;
    else if (strcmp ($commit->commit->committer->date, $lastCommit->commit->committer->date) > 0)
        $lastCommit = $commit;
}

file_put_contents ('lastCommit.json', json_encode ($lastCommit));
?>