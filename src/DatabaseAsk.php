<?php
namespace Database\Ask;

class DatabaseAsk
{
    public function prompt($question): string
    {
        $databaseAsk = new DatabaseAskManager();
        return $databaseAsk->prompt($question);
    }
}
