<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210908142814 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE video_settings (id INT AUTO_INCREMENT NOT NULL, key_id INT NOT NULL, language_id INT NOT NULL, translation_id INT NOT NULL, INDEX IDX_4DC79279D145533 (key_id), INDEX IDX_4DC7927982F1BAF4 (language_id), INDEX IDX_4DC792799CAA2B25 (translation_id), UNIQUE INDEX video_unique (key_id, language_id, translation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE video_settings ADD CONSTRAINT FK_4DC79279D145533 FOREIGN KEY (key_id) REFERENCES `key` (id)');
        $this->addSql('ALTER TABLE video_settings ADD CONSTRAINT FK_4DC7927982F1BAF4 FOREIGN KEY (language_id) REFERENCES language (id)');
        $this->addSql('ALTER TABLE video_settings ADD CONSTRAINT FK_4DC792799CAA2B25 FOREIGN KEY (translation_id) REFERENCES translation (id)');
        $this->addSql('DROP TABLE key_language_translation');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE key_language_translation (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE video_settings');
    }
}
