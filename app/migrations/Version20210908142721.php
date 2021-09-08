<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210908142721 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE key_language_translation ADD key_id INT NOT NULL, ADD language_id INT NOT NULL, ADD translation_id INT NOT NULL');
        $this->addSql('ALTER TABLE key_language_translation ADD CONSTRAINT FK_37FC770D145533 FOREIGN KEY (key_id) REFERENCES `key` (id)');
        $this->addSql('ALTER TABLE key_language_translation ADD CONSTRAINT FK_37FC77082F1BAF4 FOREIGN KEY (language_id) REFERENCES language (id)');
        $this->addSql('ALTER TABLE key_language_translation ADD CONSTRAINT FK_37FC7709CAA2B25 FOREIGN KEY (translation_id) REFERENCES translation (id)');
        $this->addSql('CREATE INDEX IDX_37FC770D145533 ON key_language_translation (key_id)');
        $this->addSql('CREATE INDEX IDX_37FC77082F1BAF4 ON key_language_translation (language_id)');
        $this->addSql('CREATE INDEX IDX_37FC7709CAA2B25 ON key_language_translation (translation_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE key_language_translation DROP FOREIGN KEY FK_37FC770D145533');
        $this->addSql('ALTER TABLE key_language_translation DROP FOREIGN KEY FK_37FC77082F1BAF4');
        $this->addSql('ALTER TABLE key_language_translation DROP FOREIGN KEY FK_37FC7709CAA2B25');
        $this->addSql('DROP INDEX IDX_37FC770D145533 ON key_language_translation');
        $this->addSql('DROP INDEX IDX_37FC77082F1BAF4 ON key_language_translation');
        $this->addSql('DROP INDEX IDX_37FC7709CAA2B25 ON key_language_translation');
        $this->addSql('ALTER TABLE key_language_translation DROP key_id, DROP language_id, DROP translation_id');
    }
}
