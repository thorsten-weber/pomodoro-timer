<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220817143114 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tasks DROP FOREIGN KEY FK_505865971EDE0F55');
        $this->addSql('DROP TABLE projects');
        $this->addSql('DROP TABLE ttt_users');
        $this->addSql('ALTER TABLE tasks DROP FOREIGN KEY FK_50586597AF2D299B');
        $this->addSql('DROP INDEX IDX_505865971EDE0F55 ON tasks');
        $this->addSql('DROP INDEX IDX_50586597AF2D299B ON tasks');
        $this->addSql('ALTER TABLE tasks DROP projects_id, DROP pomodoros_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE projects (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, title VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, creation_date DATETIME NOT NULL, INDEX IDX_5C93B3A4A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE ttt_users (id INT AUTO_INCREMENT NOT NULL, last_name VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, first_name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, email VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, session_id INT DEFAULT NULL, password LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, creation_date DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE projects ADD CONSTRAINT FK_5C93B3A4A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE tasks ADD projects_id INT DEFAULT NULL, ADD pomodoros_id INT NOT NULL');
        $this->addSql('ALTER TABLE tasks ADD CONSTRAINT FK_505865971EDE0F55 FOREIGN KEY (projects_id) REFERENCES projects (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE tasks ADD CONSTRAINT FK_50586597AF2D299B FOREIGN KEY (pomodoros_id) REFERENCES pomodoros (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_505865971EDE0F55 ON tasks (projects_id)');
        $this->addSql('CREATE INDEX IDX_50586597AF2D299B ON tasks (pomodoros_id)');
    }
}
