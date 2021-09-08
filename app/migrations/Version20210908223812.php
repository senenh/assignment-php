<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210908223812 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `key` (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8A90ABA95E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE key_language_translation (id INT AUTO_INCREMENT NOT NULL, key_id INT NOT NULL, language_id INT NOT NULL, translation_id INT NOT NULL, INDEX IDX_37FC770D145533 (key_id), INDEX IDX_37FC77082F1BAF4 (language_id), INDEX IDX_37FC7709CAA2B25 (translation_id), UNIQUE INDEX UNIQ_37FC770D14553382F1BAF49CAA2B25 (key_id, language_id, translation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE language (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, iso VARCHAR(3) NOT NULL, ltr TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE translation (id INT AUTO_INCREMENT NOT NULL, key_id_id INT NOT NULL, language_id INT NOT NULL, text LONGTEXT DEFAULT NULL, INDEX IDX_B469456F9D7AE398 (key_id_id), INDEX IDX_B469456F82F1BAF4 (language_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE key_language_translation ADD CONSTRAINT FK_37FC770D145533 FOREIGN KEY (key_id) REFERENCES `key` (id)');
        $this->addSql('ALTER TABLE key_language_translation ADD CONSTRAINT FK_37FC77082F1BAF4 FOREIGN KEY (language_id) REFERENCES language (id)');
        $this->addSql('ALTER TABLE key_language_translation ADD CONSTRAINT FK_37FC7709CAA2B25 FOREIGN KEY (translation_id) REFERENCES translation (id)');
        $this->addSql('ALTER TABLE translation ADD CONSTRAINT FK_B469456F9D7AE398 FOREIGN KEY (key_id_id) REFERENCES `key` (id)');
        $this->addSql('ALTER TABLE translation ADD CONSTRAINT FK_B469456F82F1BAF4 FOREIGN KEY (language_id) REFERENCES language (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE key_language_translation DROP FOREIGN KEY FK_37FC770D145533');
        $this->addSql('ALTER TABLE translation DROP FOREIGN KEY FK_B469456F9D7AE398');
        $this->addSql('ALTER TABLE key_language_translation DROP FOREIGN KEY FK_37FC77082F1BAF4');
        $this->addSql('ALTER TABLE translation DROP FOREIGN KEY FK_B469456F82F1BAF4');
        $this->addSql('ALTER TABLE key_language_translation DROP FOREIGN KEY FK_37FC7709CAA2B25');
        $this->addSql('DROP TABLE `key`');
        $this->addSql('DROP TABLE key_language_translation');
        $this->addSql('DROP TABLE language');
        $this->addSql('DROP TABLE translation');
    }
}
