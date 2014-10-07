<?php

namespace Hangman\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140918112443 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('ALTER TABLE guesses DROP PRIMARY KEY');
        $this->addSql('DROP INDEX character_index ON guesses');
        $this->addSql('ALTER TABLE guesses ADD letter CHAR(1) NOT NULL, DROP `character`');
        $this->addSql('ALTER TABLE guesses ADD PRIMARY KEY (game_id, letter)');
        $this->addSql('CREATE INDEX character_index ON guesses (letter)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('ALTER TABLE guesses DROP PRIMARY KEY');
        $this->addSql('DROP INDEX character_index ON guesses');
        $this->addSql('ALTER TABLE guesses ADD `character` VARCHAR(1) NOT NULL, DROP letter');
        $this->addSql('ALTER TABLE guesses ADD PRIMARY KEY (game_id, `character`)');
        $this->addSql('CREATE INDEX character_index ON guesses (`character`)');
    }
}
