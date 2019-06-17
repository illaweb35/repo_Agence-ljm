<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190617104547 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE service (id INTEGER PRIMARY KEY AUTOINCREMENT DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, description CLOB DEFAULT NULL, content CLOB DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, updated_at DATETIME DEFAULT NULL)');
        $this->addSql('DROP INDEX IDX_23A0E66F675F31B');
        $this->addSql('CREATE TEMPORARY TABLE __temp__article AS SELECT id, author_id, caption_image, image, title, content, created_at, updated_at FROM article');
        $this->addSql('DROP TABLE article');
        $this->addSql('CREATE TABLE article (id INTEGER PRIMARY KEY AUTOINCREMENT DEFAULT NULL, author_id INTEGER DEFAULT NULL, caption_image VARCHAR(255) DEFAULT NULL COLLATE BINARY, image VARCHAR(255) DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, content CLOB DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, CONSTRAINT FK_23A0E66F675F31B FOREIGN KEY (author_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO article (id, author_id, caption_image, image, title, content, created_at, updated_at) SELECT id, author_id, caption_image, image, title, content, created_at, updated_at FROM __temp__article');
        $this->addSql('DROP TABLE __temp__article');
        $this->addSql('CREATE INDEX IDX_23A0E66F675F31B ON article (author_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__reference AS SELECT id, name, customer, mission, link, created_at, image_height, caption_image, image, updated_at FROM reference');
        $this->addSql('DROP TABLE reference');
        $this->addSql('CREATE TABLE reference (id INTEGER PRIMARY KEY AUTOINCREMENT DEFAULT NULL, link VARCHAR(255) DEFAULT NULL COLLATE BINARY, name VARCHAR(255) DEFAULT NULL, customer VARCHAR(255) DEFAULT NULL, mission CLOB DEFAULT NULL, created_at DATETIME DEFAULT NULL, image_height INTEGER DEFAULT NULL, caption_image VARCHAR(255) DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, updated_at DATETIME DEFAULT NULL)');
        $this->addSql('INSERT INTO reference (id, name, customer, mission, link, created_at, image_height, caption_image, image, updated_at) SELECT id, name, customer, mission, link, created_at, image_height, caption_image, image, updated_at FROM __temp__reference');
        $this->addSql('DROP TABLE __temp__reference');
        $this->addSql('DROP INDEX IDX_9474526C7294869C');
        $this->addSql('CREATE TEMPORARY TABLE __temp__comment AS SELECT id, article_id, author, content, created_at FROM comment');
        $this->addSql('DROP TABLE comment');
        $this->addSql('CREATE TABLE comment (id INTEGER PRIMARY KEY AUTOINCREMENT DEFAULT NULL, article_id INTEGER DEFAULT NULL, author VARCHAR(255) DEFAULT NULL, content CLOB DEFAULT NULL, created_at DATETIME DEFAULT NULL, CONSTRAINT FK_9474526C7294869C FOREIGN KEY (article_id) REFERENCES article (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO comment (id, article_id, author, content, created_at) SELECT id, article_id, author, content, created_at FROM __temp__comment');
        $this->addSql('DROP TABLE __temp__comment');
        $this->addSql('CREATE INDEX IDX_9474526C7294869C ON comment (article_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE service');
        $this->addSql('DROP INDEX IDX_23A0E66F675F31B');
        $this->addSql('CREATE TEMPORARY TABLE __temp__article AS SELECT id, author_id, title, image, updated_at, caption_image, content, created_at FROM article');
        $this->addSql('DROP TABLE article');
        $this->addSql('CREATE TABLE article (id INTEGER PRIMARY KEY AUTOINCREMENT DEFAULT NULL, caption_image VARCHAR(255) DEFAULT NULL, author_id INTEGER DEFAULT NULL, title VARCHAR(255) DEFAULT NULL COLLATE BINARY, image VARCHAR(255) DEFAULT NULL COLLATE BINARY, updated_at DATETIME DEFAULT NULL, content CLOB DEFAULT NULL COLLATE BINARY, created_at DATETIME DEFAULT NULL)');
        $this->addSql('INSERT INTO article (id, author_id, title, image, updated_at, caption_image, content, created_at) SELECT id, author_id, title, image, updated_at, caption_image, content, created_at FROM __temp__article');
        $this->addSql('DROP TABLE __temp__article');
        $this->addSql('CREATE INDEX IDX_23A0E66F675F31B ON article (author_id)');
        $this->addSql('DROP INDEX IDX_9474526C7294869C');
        $this->addSql('CREATE TEMPORARY TABLE __temp__comment AS SELECT id, article_id, author, content, created_at FROM comment');
        $this->addSql('DROP TABLE comment');
        $this->addSql('CREATE TABLE comment (id INTEGER PRIMARY KEY AUTOINCREMENT DEFAULT NULL, article_id INTEGER DEFAULT NULL, author VARCHAR(255) DEFAULT NULL COLLATE BINARY, content CLOB DEFAULT NULL COLLATE BINARY, created_at DATETIME DEFAULT NULL)');
        $this->addSql('INSERT INTO comment (id, article_id, author, content, created_at) SELECT id, article_id, author, content, created_at FROM __temp__comment');
        $this->addSql('DROP TABLE __temp__comment');
        $this->addSql('CREATE INDEX IDX_9474526C7294869C ON comment (article_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__reference AS SELECT id, name, customer, mission, image, updated_at, link, created_at, image_height, caption_image FROM reference');
        $this->addSql('DROP TABLE reference');
        $this->addSql('CREATE TABLE reference (id INTEGER PRIMARY KEY AUTOINCREMENT DEFAULT NULL, link VARCHAR(255) DEFAULT NULL, name VARCHAR(255) DEFAULT NULL COLLATE BINARY, customer VARCHAR(255) DEFAULT NULL COLLATE BINARY, mission CLOB DEFAULT NULL COLLATE BINARY, image VARCHAR(255) DEFAULT NULL COLLATE BINARY, updated_at DATETIME DEFAULT NULL, created_at DATETIME DEFAULT NULL, image_height INTEGER DEFAULT NULL, caption_image VARCHAR(255) DEFAULT NULL COLLATE BINARY)');
        $this->addSql('INSERT INTO reference (id, name, customer, mission, image, updated_at, link, created_at, image_height, caption_image) SELECT id, name, customer, mission, image, updated_at, link, created_at, image_height, caption_image FROM __temp__reference');
        $this->addSql('DROP TABLE __temp__reference');
    }
}
