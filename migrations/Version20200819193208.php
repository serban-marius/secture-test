<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200819193208 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_264E43A6DD842E46');
        $this->addSql('DROP INDEX IDX_264E43A6296CD8AE');
        $this->addSql('CREATE TEMPORARY TABLE __temp__players AS SELECT id, team_id, position_id, name, price FROM players');
        $this->addSql('DROP TABLE players');
        $this->addSql('CREATE TABLE players (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, team_id INTEGER NOT NULL, position_id INTEGER NOT NULL, name VARCHAR(255) NOT NULL COLLATE BINARY, price INTEGER NOT NULL, CONSTRAINT FK_264E43A6296CD8AE FOREIGN KEY (team_id) REFERENCES team (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_264E43A6DD842E46 FOREIGN KEY (position_id) REFERENCES position (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO players (id, team_id, position_id, name, price) SELECT id, team_id, position_id, name, price FROM __temp__players');
        $this->addSql('DROP TABLE __temp__players');
        $this->addSql('CREATE INDEX IDX_264E43A6DD842E46 ON players (position_id)');
        $this->addSql('CREATE INDEX IDX_264E43A6296CD8AE ON players (team_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_264E43A6296CD8AE');
        $this->addSql('DROP INDEX IDX_264E43A6DD842E46');
        $this->addSql('CREATE TEMPORARY TABLE __temp__players AS SELECT id, team_id, position_id, name, price FROM players');
        $this->addSql('DROP TABLE players');
        $this->addSql('CREATE TABLE players (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, team_id INTEGER NOT NULL, position_id INTEGER NOT NULL, name VARCHAR(255) NOT NULL, price INTEGER NOT NULL)');
        $this->addSql('INSERT INTO players (id, team_id, position_id, name, price) SELECT id, team_id, position_id, name, price FROM __temp__players');
        $this->addSql('DROP TABLE __temp__players');
        $this->addSql('CREATE INDEX IDX_264E43A6296CD8AE ON players (team_id)');
        $this->addSql('CREATE INDEX IDX_264E43A6DD842E46 ON players (position_id)');
    }
}
