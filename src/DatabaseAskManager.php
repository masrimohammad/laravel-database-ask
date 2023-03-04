<?php

namespace Database\Ask;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Orhanerday\OpenAi\OpenAi;
use stdClass;

class DatabaseAskManager
{
    private $client;
    private $strictMode;
    private $connection;

    function __construct()
    {
        $this->client = new OpenAi(config('database-ask.open_ai_api_key'));
        $this->strictMode = config('database-ask.strict_mode');
        $this->connection = config('database-ask.connection');
    }

    public function prompt(string $question): string
    {
        $query = $this->getQuery($question);

        $result = json_encode($this->evaluateQuery($query));

        $prompt = $this->buildPrompt($question, $query, $result);

        $answer = $this->queryOpenAi($prompt, "\n", 0.7);

        return Str::of($answer)
            ->trim()
            ->trim('"');
    }

    private function getQuery(string $question): string
    {
        $prompt = $this->buildPrompt($question);

        $query = $this->queryOpenAi($prompt, "\n");
        $query = Str::of($query)
            ->trim()
            ->trim('"');

        if (!$this->ensureQueryIsSafe($query)) {
            return "";
        }

        return $query;
    }

    protected function buildPrompt(string $question, string $query = null, string $result = null): string
    {
        $tables = $this->getTables();

        $prompt = (string)view('database-ask::prompts.query', [
            'question' => $question,
            'tables' => $tables,
            'dialect' => $this->getDialect(),
            'query' => $query,
            'result' => $result,
        ]);

        return rtrim($prompt, PHP_EOL);
    }

    protected function getTables(): array
    {
        return DB::connection($this->connection)
            ->getDoctrineSchemaManager()
            ->listTables();
    }

    protected function getDialect(): string
    {
        $databasePlatform = DB::connection($this->connection)
            ->getDoctrineConnection()
            ->getDatabasePlatform();

        return Str::before(class_basename($databasePlatform), 'Platform');
    }

    protected function queryOpenAi(string $prompt, string $stop, float $temperature = 0.0)
    {
        $completions = $this->client->completion([
            'model' => 'text-davinci-003',
            'prompt' => $prompt,
            'temperature' => $temperature,
            'max_tokens' => 100,
            'stop' => $stop,
        ]);
        $completions = json_decode($completions);

        return $completions->choices[0]->text;
    }

    protected function ensureQueryIsSafe(string $query): bool
    {
        if (!$this->strictMode) {
            return true;
        }

        $query = strtolower($query);
        $forbiddenWords = ['insert', 'update', 'delete', 'alter', 'drop', 'truncate', 'create', 'replace'];
        if (Str::contains($query, $forbiddenWords)) {
            return false;
        }
        return true;

    }

    protected function evaluateQuery(string $query)
    {
        return DB::connection($this->connection)->select($this->getRawQuery($query))[0] ?? new stdClass();
    }

    protected function getRawQuery(string $query): string
    {
        if (version_compare(app()->version(), '10.0', '<')) {
            return (string)DB::raw($query);
        }

        return DB::raw($query)->getValue(DB::connection($this->connection)->getQueryGrammar());
    }
}
