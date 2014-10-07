<?php

namespace Hangman\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140918111811 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('CREATE TABLE games (id INT AUTO_INCREMENT NOT NULL, word_id INT DEFAULT NULL, status VARCHAR(255) NOT NULL, INDEX IDX_FF232B31E357438D (word_id), INDEX id_status_guesses_index (id, status), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE guesses (game_id INT NOT NULL, `character` CHAR(1) NOT NULL, INDEX IDX_27FBAF45E48FD905 (game_id), INDEX character_index (`character`), PRIMARY KEY(game_id, `character`)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE words (id INT AUTO_INCREMENT NOT NULL, text VARCHAR(255) NOT NULL, INDEX word_index (text), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE games ADD CONSTRAINT FK_FF232B31E357438D FOREIGN KEY (word_id) REFERENCES words (id)');
        $this->addSql('ALTER TABLE guesses ADD CONSTRAINT FK_27FBAF45E48FD905 FOREIGN KEY (game_id) REFERENCES games (id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('ALTER TABLE guesses DROP FOREIGN KEY FK_27FBAF45E48FD905');
        $this->addSql('ALTER TABLE games DROP FOREIGN KEY FK_FF232B31E357438D');
        $this->addSql('DROP TABLE games');
        $this->addSql('DROP TABLE guesses');
        $this->addSql('DROP TABLE words');
    }
}
